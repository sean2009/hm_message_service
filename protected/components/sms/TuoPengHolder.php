<?php

/**
 * 拓鹏
 */
class TuoPengHolder implements SMSHolder {
    
    private $wsdl = 'http://122.144.130.36:1210/Services/MsgSend.asmx?wsdl';
    private $userCode = 'hmsc';
    private $userPass = 'hmsc8000';
    private $errorMsg;
    
    public function send($mobile, $content) {
        try {
            $client = new SoapClient($this->wsdl);
            $ret = $client->SendMsg(array(
                'userCode' => $this->userCode,
                'userPass' => $this->userPass,
                'DesNo' => $mobile,
                'Msg' => $content
            ));
            return $ret->SendMsgResult > 0;
        } catch (Exception $ex) {
            $this->errorMsg = $ex->getMessage();
        }
        
        return false;
    }

    public function getError() {
        return $this->errorMsg;
    }

}