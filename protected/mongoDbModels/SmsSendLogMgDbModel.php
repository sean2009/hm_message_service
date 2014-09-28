<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class SmsSendLogMgDbModel extends EMongoDocument {
    public $mobile;
    public $content;
    public $send_type;
    public $is_send;
    public $send_time;
    public $channel;
    
    /**
     * 
     * @param type $className
     * @return UserMgDbModel
     */
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}
    
    // This method is required!
	public function getCollectionName() {
		return 'admin_sms_send_log';
	}
}
?>
