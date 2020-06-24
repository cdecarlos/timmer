<?php

/**
 * This is the model class for table "Projects".
 *
 * The followings are the available columns in table 'Projects':
 * @property integer $id
 * @property string $name
 * @property integer $idUser
 * @property string $status
 */
class Projects extends CActiveRecord
{
	const STATUS_ACTIVE = 'active';
	const STATUS_DELETED = 'deleted';
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'Projects';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, idUser, status', 'required'),
			array('idUser', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>200),
			array('status', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, idUser, status', 'safe', 'on'=>'search'),
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
			'name' => 'Name',
			'idUser' => 'User',
			'status' => 'Status',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('idUser',$this->idUser);
		$criteria->compare('status',$this->status,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Projects the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getUserSelect () {
		$criteria = new CDbCriteria;
		$criteria->order = "name ASC";
		$model = Users::model()->findAll($criteria);

		$arr = [
			'' => '- Choose -'
		];
		foreach ($model as $m) {
			$arr[$m->id] = $m->name;
		}
		return $arr;
	}

	public function getStatusSelect () {
		return [
			Projects::STATUS_ACTIVE => 'Active',
			Projects::STATUS_DELETED => 'Deleted'
		];
	}

	public function getTotalHours () {
		$total = 0;

		$criteria = new CDbCriteria;
    $criteria->addCondition ('idUser = ' . Yii::app()->user->id);
    $criteria->addCondition ('idProject = ' . $this->id);
		$blocks = Blocks::model()->findAll($criteria);

		foreach ($blocks as $i => $b) {
			$total+= $b->timeEnd - $b->timeInit;
		}

		$total = Blocks::formatSeconds ($total);

		return $total;
	}
}
