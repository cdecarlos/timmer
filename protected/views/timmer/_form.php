<?php $form = $this->beginWidget('CActiveForm'); ?>
  <div class="row">
    <div class="col-12 mt10">
      <?php echo $form->labelEx($model, 'title'); ?>
      <?php echo $form->textField($model, 'title', ['class' => 'form-control']); ?>
      <?php echo $form->error($model, 'title'); ?>
    </div>

    <div class="col-12 mt10">
      <?php echo $form->labelEx($model, 'idProject'); ?>
      <?php echo $form->dropDownList($model, 'idProject', $model->projectSelect, ['class' => 'form-control']); ?>
      <?php echo $form->error($model, 'idProject'); ?>
    </div>

    <div class="col-12 mt10">
      <?php echo $form->labelEx($model, 'timeInit'); ?>
      <?php echo $form->dateTimeLocalField($model, 'timeInit', ['class' => 'form-control']); ?>
      <?php echo $form->error($model, 'timeInit'); ?>
    </div>

    <div class="col-12 mt10">
      <?php echo $form->labelEx($model, 'timeEnd'); ?>
      <?php echo $form->dateTimeLocalField($model, 'timeEnd', ['class' => 'form-control']); ?>
      <?php echo $form->error($model, 'timeEnd'); ?>
    </div>

    <div class="col-12 mt10">
      <?php echo $form->labelEx($model, 'day'); ?>
      <?php echo $form->dateField($model, 'day', ['class' => 'form-control']); ?>
      <?php echo $form->error($model, 'day'); ?>
    </div>

    <div class="col-12 mt10 d-flex">
      <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', ['class' => 'btn btn-success ml-auto']); ?>
    </div>
  </div>

<?php $this->endWidget(); ?>
