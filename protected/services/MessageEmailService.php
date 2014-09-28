<?php

class MessageEmailService extends BaseService {

    /**
     * 
     * @param type $className
     * @return MessageEmailService
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * 发送邮件
     * $mail_title:邮件主题
     * $mail_content:邮件内容
     * $mail_to:收件人
     * Enter description here ...
     * @param $mail_title
     */
    public function send_email($mail_title, $mail_content, $mail_to) {
        Yii::import('application.components.email.*');

        $holder = new RadicaepostHolder();
        $holder->setFrom('星易家', 'service@chinaredstar.com');
//        
//        $holder = new EaseyeHolder();
//        $holder->setFrom('星易家', 'xingyijia@edmyy.mmall.com');

        $holder->send($mail_to, $mail_title, $mail_content);
        
        return true;
    }

}

abstract class EmailHolder {

    protected $from;
    protected $fromName;
    protected $charset = 'UTF-8';
    private $isHtml = true;

    public function setFrom($fromName, $from) {
        $this->from = $from;
        $this->fromName = $fromName;
    }

    abstract public function send($to, $title, $content);

    public function getError() {
        
    }
    
    public function isHtml() {
        return $this->isHtml;
    }
}
