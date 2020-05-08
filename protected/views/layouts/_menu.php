<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="<?php echo Yii::app()->homeUrl; ?>">Timmer</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav ml-auto">
      <?php if (!Yii::app()->user->isGuest): ?>
        <li class="nav-item"><?php echo CHtml::link('Timmer', ['timmer/index'], ['class' => 'nav-link']); ?></li>
        <li class="nav-item"><?php echo CHtml::link('Projects', ['project/admin'], ['class' => 'nav-link']); ?></li>
        <li class="nav-item"><?php echo CHtml::link('Logout', ['site/logout'], ['class' => 'nav-link']); ?></li>
      <?php endif; ?>
    </ul>
  </div>
</nav>
