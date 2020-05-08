<div class="container">
	<div class="row justify-content-md-center">
		<div class="col-12 col-xs-3 border mt50">
			<h1 class="text-center mt30">Iniciar sesión</h1>

			<?php $form = $this->beginWidget('CActiveForm', array(
				'id' => 'login-form'
			)); ?>

			<div class="form-group mt30">
				<?php echo $form->labelEx($model, 'username'); ?>
				<?php echo $form->textField($model, 'username', ['class' => 'form-control', 'autofocus' => 'autofocus']); ?>
				<?php echo $form->error($model, 'username'); ?>
			</div>

			<div class="form-group">
				<?php echo $form->labelEx($model, 'password'); ?>
				<?php echo $form->passwordField($model, 'password', ['class' => 'form-control']); ?>
				<?php echo $form->error($model, 'password'); ?>
			</div>

			<div class="buttons">
				<?php echo CHtml::submitButton('Login', ['class' => 'btn btn-primary mb20 ml-auto']); ?>
			</div>

			<?php $this->endWidget(); ?>
		</div>
	</div>
</div>
