<?php

/*
 * 消息服务
 */

class MessageSmsService extends BaseService {

    const SMS_CACHE_PREFIX = 'sms_blanklist_';
    
    public $send_type_sys = array(
        '收款单','会员列表','安全验证','找回密码','订单支付成功通知用户','抢购用户手机短信验证','商城后台'
    );

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /*
     * 过滤手机号码，在黑名单的过滤掉
     */

    public function checkBlackList($mobiles) {
        $this->smsBlackToCache();
        $cache = Yii::app()->cache;
        if (!is_array($mobiles)) {
            $mobiles = array($mobiles);
        }
        $mobiles_send = array();
        foreach ($mobiles as $mobile) {
            $key = self::SMS_CACHE_PREFIX . $mobile;
            $check = $cache->get($key);
//            var_dump($check);
            if ($check === false) {
                $mobiles_send[] = $mobile;
            }
        }

        return $mobiles_send;
    }

    /*
     * 将黑名单数据全部缓存
     */

    public function smsBlackToCache() {
        $cache = Yii::app()->cache;
        $cache_time = 180;
        $key = 'sms_blanklist_iscache';
        if ($cache->get($key)) {
            return true;
        }
        $cache->set($key, 1, $cache_time);
        $list = SmsBlanklistModel::model()->findAll(array(
            'select' => 'mobiles'
        ));
        foreach ($list as $val) {
            $key = self::SMS_CACHE_PREFIX . $val->mobiles;
            $cache->set($key, 1, $cache_time + 30);
        }
    }

    /*
     * 发送短信
     */

    public function send_sms($mobiles, $content, $send_type, $max) {
        if (!is_array($mobiles)) {
            $mobiles = array($mobiles);
        }
        
        $content = str_replace('【', '', $content);
        $content = str_replace('】', '', $content);
        $content = '【星易家】'.$content;
        if(mb_strlen($content,'UTF-8')<=61){
            $content .= ' 退订请回复0000';
        }
        
        // 返回的信息，如果发送失败则,msg中为失败信息
        $ret = array('success' => false, 'msg' => '');

        //暂时不做发送类型的限制
//        $sms_send_type = $this->getSendTypeList();
//        if(!in_array($send_type, $sms_send_type)){
//            return '-3';
//        }
        //发送通道
        Yii::import('application.components.sms.*');
        
        $cache = Yii::app()->cache;
        $cache_time = 15;
        $key = 'sms_send_type';
        $sms_type = $cache->get($key);
        if (empty($sms_type)) {
            $return = SmsSettingModel::model()->find('sms_type=1');
            $sms_type = $return->content;
            $cache->set($key, $sms_type, $cache_time);
        }
        
        
        foreach ($mobiles as $mobile) {
            $send_count = $this->getSendSmsTodayCount($mobile, $send_type);
            $smsHolder = null;
            $isSend = false;

            if ($send_count < $max) {
                switch ($sms_type) {
                    case 2:
                        // 亿美短信发送
                        $smsHolder = new EucpHolder();
                        break;
                    case 3:
                        // 拓鹏
                        $smsHolder = new TuoPengHolder();
                        break;
                    case 4:
                        //国都
                        $send_type_sys = $this->send_type_sys;
                        if(in_array($send_type, $send_type_sys)){
                            $smsHolder = new GuoDuHolder();
                        }  else {
                            $smsHolder = new GuoDuHolder2();
                        }
                        
                        break;
                    case 5:
                        //企信港
                        $smsHolder = new QixingangHolder();
                        break;
                    default :
                        // 梦网短信发送
                        $smsHolder = new MontnetsHolder();
                }

                $isSend = $ret['success'] = $smsHolder->send($mobile, $content);
                $ret['msg'] = $smsHolder->getError();
            } else {
                $ret['msg'] = '该手机号已超过今天能发送次数';
            }

            $this->saveSmsSendLog($mobile, $content, $send_type, (int) $isSend, $smsHolder ? get_class($smsHolder) : '');
        }
        return $ret;
    }

    private function getSendTypeList() {
        $list = SmsSettingModel::model()->findAll(array(
            'condition' => 'status = 0 and sms_type = :type',
            'params' => array(':type' => '2'),
            'select' => 'name'
        ));
        $return = array();
        foreach ($list as $val) {
            $return[] = $val['name'];
        }
        return $return;
    }

    /*
     * 获取同一类型同一个手机号在当天的发送次数
     */

    private function getSendSmsTodayCount($mobile, $send_type) {
        $criteria = new EMongoCriteria();
        $criteria->mobile('==', $mobile);
        $criteria->send_type('==', $send_type);
        $criteria->is_send('==', 1);
        $criteria->send_time('>=', strtotime(date('Y-m-d') . ' 00:00:00'));
        return SmsSendLogMgDbModel::model()->count($criteria);
    }

    /**
     * 保存发送日志
     * 
     * @param string $mobile 手机号码
     * @param string $content 发送的内容
     * @param string $send_type 短信的类型
     * @param boolean $is_send 是否已经发送
     * @param string $channel 通道类
     */
    private function saveSmsSendLog($mobile, $content, $send_type, $is_send, $channel) {
        $model = new SmsSendLogMgDbModel();

        $model->mobile = $mobile;
        $model->content = $content;
        $model->send_type = $send_type;
        $model->is_send = $is_send;
        $model->send_time = time();
        $model->channel = $channel;

        $model->save();
    }

}

/**
 * 短信发送接口，所有的其他通道，请实现这个接口
 */
interface SMSHolder {

    /**
     * @params string $mobile 手机号码
     * @params string $content 发送的内容
     * @return boolean 返回发送成功或失败
     */
    public function send($mobile, $content);

    public function getError();
}
