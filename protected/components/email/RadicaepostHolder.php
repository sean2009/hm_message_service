<?php


class RadicaepostHolder extends EmailHolder {

    private $host = 'mmall-cn.radicaepost.com';
    private $port = 25;

    public function send($to, $title, $content) {
        Yii::app()->mailer->Host = $this->host;
        Yii::app()->mailer->Port = $this->port;
        Yii::app()->mailer->From = $this->from;
        Yii::app()->mailer->FromName = $this->fromName;
        Yii::app()->mailer->CharSet = $this->charset;
        Yii::app()->mailer->Subject = $title;
        Yii::app()->mailer->Body = $content;
        Yii::app()->mailer->IsHTML($this->isHtml());
        
        Yii::app()->mailer->AddAddress($to);
        Yii::app()->mailer->IsSMTP();
        Yii::app()->mailer->Send();
        
        return true;
    }

}
