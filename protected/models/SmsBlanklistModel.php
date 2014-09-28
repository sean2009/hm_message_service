<?php

/**
 * This is the model class for table "sms_blanklist".
 *
 * The followings are the available columns in table 'sms_blanklist':
 * @property integer $id
 * @property integer $mobiles
 * @property string $add_time
 * @property string $upd_time
 */
class SmsBlanklistModel extends BaseActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SmsBlanklistModel the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'sms_blanklist';
	}
        
        public function getDbConnection() {
            return Yii::app()->db_boss;
        }
    
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('mobiles', 'required'),
			array('mobiles', 'numerical', 'integerOnly'=>true),
                        array('mobiles', 'length','max'=>11),
                        array('mobiles','unique','message'=>'该手机号码已经存在！'),
			array('add_time, upd_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, mobiles, add_time, upd_time', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'mobiles' => '手机号码',
			'add_time' => 'Add Time',
			'upd_time' => 'Upd Time',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('mobiles',$this->mobiles);
		$criteria->compare('add_time',$this->add_time,true);
		$criteria->compare('upd_time',$this->upd_time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function beforeSave() {
		if ($this->isNewRecord){
                        $this->add_time = new CDbExpression('NOW()');
		}else
			$this->upd_time = new CDbExpression('NOW()');
		return parent::beforeSave();
	}
}