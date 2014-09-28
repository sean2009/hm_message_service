<?php

/*
 * 消息服务
 */

class MessageController extends ApplicationController {
    
    /*
     * 测试接口用方法
     */
    public function actionSendTest(){
        Yii::import('application.components.sms.*');
        Yii::import('MessageSmsService',true);
        $smsHolder = new QixingangHolder();
        $mobile = '13818361965';
        $content = 'sdfsdfsf';
        $isSend = $ret['success'] = $smsHolder->send($mobile, $content);
        $ret['msg'] = $smsHolder->getError();
        print_r($ret);
    }
    
    /*
     * 测试接口用方法
     */
    public function actionTestEmail(){
        $return = MessageEmailService::model()->send_email('sdfsf', 'sdfsf', '549102486@qq.com');
        var_dump($return);
    }
    
    /*
     * 发送短信
     * 四个参数：mobiles,content,send_type,max
     */

    public function actionSendSms() {
        $params = $this->getRequest();
        $code = 0;
        $msg = '';
        if (empty($params['mobiles']) || empty($params['content']) || empty($params['send_type'])) {
            $code = -1;
            $msg = '接收手机号、内容或类型不能为空';
        }
        $mobiles_send = MessageSmsService::model()->checkBlackList($params['mobiles']);
        if(empty($mobiles_send)){
            $code = -2;
            $msg = '黑名单号码';
        }
        if ($code === 0) {
            $params['max'] = isset($params['max']) ? $params['max'] : 10;
            $return = MessageSmsService::model()->send_sms($mobiles_send, $params['content'], urldecode($params['send_type']), $params['max']);
            $code = $return['success'] ? 0 : -1;
            $msg = $return['msg'];
        }
        return $this->response($code, $msg);
    }

    /*
     * 发送邮件
     */

    public function actionSendEmail() {
        $params = $this->getRequest();
        $code = 0;
        $msg = '';

        $return = MessageEmailService::model()->send_email($params['mail_title'], $params['mail_content'], $params['mail_to']);
        if ($return !== true) {
            $code = -1;
            $msg = $return;
        }
        return $this->response($code, $msg);
    }

}

?>
