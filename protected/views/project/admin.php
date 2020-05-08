<div class="row">
  <div class="col-9">
    <h1>Admin projects</h1>
  </div>
  <div class="col-3">
    <?php echo CHtml::link('<i class="fas fa-plus"></i>', ['project/add'], ['class' => 'btnAdd']); ?>
  </div>
</div>

<table class="table table-striped">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Name</th>
      <th scope="col">Status</th>
      <th scope="col">Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($model as $m): ?>
      <tr>
        <td><?php echo $m->id; ?></td>
        <td><?php echo $m->name; ?></td>
        <td><?php echo $m->status; ?></td>
        <td>
          <?php echo CHtml::link('edit', ['project/edit', 'id' => $m->id], ['class' => 'btn btn-success btn-sm']); ?>
          <?php echo CHtml::link('delete', ['project/delete', 'id' => $m->id], ['class' => 'btn btn-danger btn-sm']); ?>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
