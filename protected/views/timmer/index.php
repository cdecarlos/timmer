<?php
if ($actual == null):
  echo CHtml::link('<i class="fas fa-plus"></i>', ['timmer/add'], ['class' => 'btnAdd']);
else: ?>
  <div class="row">
    <div class="col-6 d-flex">
      <h2 class="ml-auto mb0 mt10" id="actualTime"><?php echo $actual->init; ?> <?php echo $actual->toNow; ?></h2>
    </div>
    <div class="col-6">
      <?php echo CHtml::link('<i class="fas fa-stop"></i>', ['timmer/stop', 'id' => $actual->id], ['class' => 'btnStop float-left']); ?>
      <?php echo CHtml::link('<i class="fas fa-plus"></i>', ['timmer/add', 'actualId' => $actual->id], ['class' => 'btnAdd float-left']); ?>
    </div>
    <div class="col-12">
      <h2 class="text-center"><?php echo $actual->title; ?> - <?php echo $actual->projectName; ?></h2>
    </div>
  </div>
<?php endif; ?>

<?php
foreach ($blocks as $day => $blockArray) {
  echo '<p class="mt20">' . $day . '</p>';
  foreach ($blockArray as $b) {
    $this->renderPartial ('_listItem', [
      'item' => $b
    ]);
  }
}
?>

<?php if ($actual != null): ?>
  <script>
    var urlActual = "<?php echo Yii::app()->createUrl('timmer/getActual', ['id' => $actual->id]); ?>"
    var actualTime = document.getElementById("actualTime")

    if (actualTime) {
      updateActualTime (actualTime)
      setInterval(() => {
        updateActualTime (actualTime)
      }, 10000)
    }

    function updateActualTime (actualTime) {
      var r = new XMLHttpRequest()
      r.open("POST", urlActual, true)
      r.onreadystatechange = function () {
        if (r.readyState != 4 || r.status != 200) return;
        actualTime.innerText = r.responseText
      }
      r.send()
    }
  </script>
<?php endif; ?>

<?php echo $this->renderPartial('_day', [
  'day' => $day
]); ?>
