<?php
$prevDay = date('Y-m-d', strtotime($day . ' -1day'));
$prev = CHtml::link(
  '<i class="fas fa-chevron-left"></i>',
  ['timmer/index', 'day' => $prevDay],
  ['class' => 'btnMove']
);
$nextDay = date('Y-m-d', strtotime($day . ' +1day'));
$next = CHtml::link(
  '<i class="fas fa-chevron-right"></i>',
  ['timmer/index', 'day' => $nextDay],
  ['class' => 'btnMove']
);
?>

<div class="day">
  <?php echo $prev; ?>
  <?php echo $next; ?>
  <h3>Día <?php echo date('j', strtotime($day)); ?> - <span id="percentDay">0 %</span></h3>
  <div class="progress">
    <div id="percentBar" class="progress-bar bg-success" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
  </div>
</div>

<script>
  var url = "<?php echo Yii::app()->createUrl('timmer/getDay', ['day' => $day]); ?>"
  var percentDay = document.getElementById("percentDay")
  var percentBar = document.getElementById("percentBar")

  if (percentDay && percentBar) {
    updateTotalDay (percentDay, percentBar)
    setInterval(() => {
      updateTotalDay (percentDay, percentBar)
    }, 10000)
  }

  function updateTotalDay (percentDay, percentBar) {
    var r = new XMLHttpRequest()
    r.open("POST", url, true)
    r.onreadystatechange = function () {
      if (r.readyState != 4 || r.status != 200) return;
      var res = JSON.parse(r.responseText)
      percentDay.innerText = `${parseInt(res.percent)} %  ${res.total}`
      percentBar.style.width = `${res.percent}%`
    }
    r.send()
  }
</script>
