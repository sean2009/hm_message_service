<?php
/**
 * 从服务端获取数据
 * @author xiaopeng
 *
 */
Yii::import('yii_ext_lib.library.yar.API_Client');

class LogsWebService {
    /*
     * 发送短信
     */
    public static function getSmsLogs($params) {
        return API_Client::call(API_LOG_URL, 'sms/get', $params);
    }
    
    /*
     * 发送短信
     */
    public static function addSmsLogs($params) {
        return API_Client::call(API_LOG_URL, 'sms/add', $params);
    }
}