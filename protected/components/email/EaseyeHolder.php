<?php

/**
 * 亿业邮件
 */
class EaseyeHolder extends EmailHolder {
    
    private $host = 'smtp.easeye.com.cn';
    private $port = 25;
    private $userName = 'lu.yongde@chinaredstar.com';
    private $password = 'hm123456';

    public function send($to, $title, $content) {
        Yii::app()->mailer->IsSMTP();
        Yii::app()->mailer->SMTPAuth = true;
        Yii::app()->mailer->Username = $this->userName;
        Yii::app()->mailer->Password = $this->password;
        
        Yii::app()->mailer->Host = $this->host;
        Yii::app()->mailer->Port = $this->port;
        Yii::app()->mailer->From = $this->from;
        Yii::app()->mailer->FromName = $this->fromName;
        Yii::app()->mailer->CharSet = $this->charset;
        Yii::app()->mailer->Subject = $title;
        Yii::app()->mailer->Body = $content;
        Yii::app()->mailer->IsHTML($this->isHtml());
        
        Yii::app()->mailer->AddAddress($to);
        
        Yii::app()->mailer->Send();
        
        return true;
    }

}
