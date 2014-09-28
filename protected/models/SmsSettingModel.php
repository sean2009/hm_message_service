<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class SmsSettingModel extends EOracleActiveRecord{
    
    /**
     * 
     * @param type $className
     * @return SmsSettingModel
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public function getDbConnection() {
        return Yii::app()->db;
    }
    
    public function tableName(){
        return 'sys_sms_setting';
    }
    
    public function beforeSave(){
        if(empty($this->status)){
            $this->status = 0;
        }
        return parent::beforeSave();
    }
}
?>
