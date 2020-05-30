<div class="timmerItem">
  <div class="row">
    <div class="col-5">
      <?php echo $item->title; ?> - <?php echo $item->projectName; ?>
    </div>
    <div class="col-5 text-right">
      <?php echo $item->init; ?> - <?php echo $item->end; ?> <?php echo $item->total; ?>
    </div>
    <div class="col-2 text-right">
      <?php echo CHtml::link('<i class="fas fa-pen"></i>', ['timmer/edit', 'id' => $item->id], ['class' => 'btn btn-primary btn-sm']); ?>
      <?php echo CHtml::link('<i class="fas fa-play"></i>', ['timmer/play', 'id' => $item->id], ['class' => 'btn btn-success btn-sm']); ?>
    </div>
  </div>
</div>
