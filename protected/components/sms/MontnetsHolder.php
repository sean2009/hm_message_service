<?php

/**
 * 梦网短信接口
 */
class MontnetsHolder implements SMSHolder {

    private $server_url = 'http://ws.montnets.com:7902/MWGate/wmgw.asmx?wsdl';
    private $user_name = 'J20716';
    private $password = '889651';
    private $pszSubPort = '*';
    private $errorMsg;
    
    public function __construct() {
        Yii::import('application.extensions.sms_montnets.sms_montnets',true);
    }
    
    public function send($mobile, $content) {
        $smsInfo['server_url'] = 'http://ws.montnets.com:7902/MWGate/wmgw.asmx?wsdl';
        $smsInfo['user_name'] = 'J20716';
        $smsInfo['password'] = '889651';
        $smsInfo['pszSubPort'] = '*';
        $sms = new sms_montnets($this->server_url, $this->user_name, $this->password);
        $sms->pszSubPort = $this->pszSubPort;
        $sms->setOutgoingEncoding("UTF-8");
        
        $ret = $sms->sendSMS(array($mobile), $content);
        $success = false;
        
        if ($ret && $ret['status']) {
            $success = true;
        } else {
            $this->errorMsg = $ret['msg'];
        }
        return $success;
    }

    public function getError() {
        return $this->errorMsg;
    }

}