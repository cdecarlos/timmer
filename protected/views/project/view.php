<div class="row">
  <div class="col-12">
    <h2 class="text-center"><?php echo $model->name; ?></h2>
    <h3 class="text-center"><?php echo $model->totalHours; ?></h3>
  </div>
</div>

<?php
$criteria = new CDbCriteria;
$criteria->addCondition ('idUser = ' . Yii::app()->user->id);
$criteria->addCondition ('idProject = ' . $model->id);
$criteria->order = 'timeInit DESC';
$blocks = Blocks::model()->findAll($criteria);

foreach ($blocks as $i => $b) {
  $this->renderPartial ('../timmer/_listItem', [
    'item' => $b
  ]);
}
?>
