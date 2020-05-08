<?php $form = $this->beginWidget('CActiveForm'); ?>
  <div class="row">
    <div class="col-12 mt10">
      <?php echo $form->labelEx($model, 'name'); ?>
      <?php echo $form->textField($model, 'name', ['class' => 'form-control', 'autofocus' => 'autofocus']); ?>
      <?php echo $form->error($model, 'name'); ?>
    </div>

    <div class="col-12 mt10">
      <?php echo $form->labelEx($model, 'idUser'); ?>
      <?php echo $form->dropDownList($model, 'idUser', $model->userSelect, ['class' => 'form-control']); ?>
      <?php echo $form->error($model, 'idUser'); ?>
    </div>

    <div class="col-12 mt10">
      <?php echo $form->labelEx($model, 'status'); ?>
      <?php echo $form->dropDownList($model, 'status', $model->statusSelect, ['class' => 'form-control']); ?>
      <?php echo $form->error($model, 'status'); ?>
    </div>

    <div class="col-12 mt10 d-flex">
      <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', ['class' => 'btn btn-success ml-auto']); ?>
    </div>
  </div>

<?php $this->endWidget(); ?>
