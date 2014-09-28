<?php

/**
 * 亿美短信发送
 */
class EucpHolder implements SMSHolder {

    /**
     * 网关地址
     * 
     * @var string
     */
    private $gwUrl = 'http://sdk4report.eucp.b2m.cn:8080/sdk/SDKService';
    /**
     * 序列号
     * 
     * @var string
     */
    private $serialNumber = '6SDK-EMY-6688-JCYQO';
    /**
     * 密码
     * 
     * @var string 
     */
    private $password = '779507';
    /**
     * session key
     * 
     * @var string
     */
    private $sessionKey = '123456';
    private $connectTimeOut = 2;
    private $readTimeOut = 10;
    private $errorMsg;

    public function __construct() {
        Yii::import('application.extensions.sms_eucp.Client', true);
    }

    public function send($mobile, $content) {
        $proxyhost = false;
        $proxyport = false;
        $proxyusername = false;
        $proxypassword = false;

        $client = new Client($this->gwUrl, $this->serialNumber, $this->password, $this->sessionKey, $proxyhost, $proxyport, $proxyusername, $proxypassword, $this->connectTimeOut, $this->readTimeOut);
        $client->setOutgoingEncoding("UTF-8");
        
        $ret = $client->sendSMS(array($mobile), $content);
        
        return true;
    }

    public function getError() {
        return $this->errorMsg;
    }

}