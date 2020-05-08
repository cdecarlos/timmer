<?php

/**
 * This is the model class for table "Blocks".
 *
 * The followings are the available columns in table 'Blocks':
 * @property integer $id
 * @property string $title
 * @property integer $timeInit
 * @property integer $timeEnd
 * @property integer $idProject
 * @property integer $idUser
 * @property string $day
 */
class Blocks extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'Blocks';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, timeInit, idProject, idUser', 'required'),
			array('timeInit, timeEnd, idProject, idUser', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>200),
			array('day', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, title, timeInit, timeEnd, idProject, idUser, day', 'safe', 'on'=>'search'),
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
			'title' => 'Title',
			'timeInit' => 'Time Init',
			'timeEnd' => 'Time End',
			'idProject' => 'Project',
			'idUser' => 'User',
			'day' => 'Day',
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
		$criteria->compare('title',$this->title,true);
		$criteria->compare('timeInit',$this->timeInit);
		$criteria->compare('timeEnd',$this->timeEnd);
		$criteria->compare('idProject',$this->idProject);
		$criteria->compare('idUser',$this->idUser);
		$criteria->compare('day',$this->day,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Blocks the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getProjectName () {
		$project = Projects::model()->findByPk($this->idProject);
		if ($project != null) {
			return $project->name;
		}
		return '-';
	}

	public function getInit () {
		return date(Yii::app()->params['timeFormat'], $this->timeInit);
	}

	public function getEnd () {
		if ($this->timeEnd != null) {
			return date(Yii::app()->params['timeFormat'], $this->timeEnd);
		}
		return 'now';
	}

	public function getToNow () {
		return $this->formatSeconds (time() - $this->timeInit);
	}

	public function getTotal () {
		if ($this->timeEnd != null) {
			return $this->formatSeconds ($this->timeEnd - $this->timeInit);
		}
		return '';
	}

	public static function formatSeconds ($total) {
		$day = 60 * 60 * 24;
		$hour = 60 * 60;
		$minute = 60;
		// $second = 60 * 60 * 24;
		$d = floor ($total / $day);
		$total = $total - ($d * $day);

		$h = floor ($total / $hour);
		if ($h < 10) $h = '0' . $h;
		$total = $total - ($h * $hour);

		$m = floor ($total / $minute);
		if ($m < 10) $m = '0' . $m;
		$total = $total - ($m * $minute);

		$s = $total;
		if ($s < 10) $s = '0' . $s;

		$res = '';
		if ($d != 0)
			$res.= $d . 'd ';
		if ($h != 0)
			$res.= $h . ':';
		$res.= $m . ':' . $s;
		return '(' . $res . ')';
	}

	public function getProjectSelect () {
		$criteria = new CDbCriteria;
		$criteria->addCondition ('idUser = ' . Yii::app()->user->id);
		$criteria->order = "name ASC";
		$model = Projects::model()->findAll($criteria);

		$arr = [
			'' => '- Choose -'
		];
		foreach ($model as $m) {
			$arr[$m->id] = $m->name;
		}
		return $arr;
	}
}
