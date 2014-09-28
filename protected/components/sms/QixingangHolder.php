<?php

/**
 * 企信港短信发送
 */
class QixingangHolder implements SMSHolder {

    /**
     * 网关地址
     * 
     * @var string
     */
    private $gwUrl = 'http://175.102.15.131/msg/HttpBatchSendSM';
    /**
     * 用户名
     * 
     * @var string
     */
    private $username = 'aisibote';
    /**
     * 密码
     * 
     * @var string 
     */
    private $password = 'wZ@D8@LwDj';
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
        
    }

    public function send($mobile, $content) {
        $ret = HttpCurl::request($this->gwUrl, array(
            'account'=>$this->username,
            'pswd'  =>  $this->password,
            'mobile'    => $mobile,
            'msg'   => urlencode($content)
            ), 'POST');
        $ret = explode("\n", $ret);
        $ret = explode(',',$ret[0]);
        if($ret[1] == 0){
            return true;
        }
        return $ret[1];
    }

    public function getError() {
        return $this->errorMsg;
    }

}