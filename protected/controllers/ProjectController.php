<?php
class ProjectController extends Controller {
	public function filters() {
		return [
			'accessControl'
		];
	}

	public function accessRules() {
		return [
			['allow',
				'users' => ['@']
			],
			['deny',
				'users' => ['*']
			],
		];
	}

	public function actionAdmin() {
		$criteria = new CDbCriteria;
		$criteria->order = 'name ASC';
		$model = Projects::model()->findAll($criteria);

		$this->render('admin', [
      'model' => $model,
    ]);
	}

	public function actionEdit ($id) {
		$model = Projects::model()->findByPk($id);

		if (isset ($_POST['Projects'])) {
			$model->attributes = $_POST['Projects'];
			if ($model->save()) {
				$this->redirect (['project/admin', 'edit' => 1]);
			}
		}

		$this->render('edit', [
			'model' => $model
		]);
	}

	public function actionDelete ($id) {
		$model = Projects::model()->findByPk($id);

		if ($model != null) {
			$model->status = Projects::STATUS_DELETED;
			$model->save();
		}

		$this->redirect (['project/admin', 'deleted' => 1]);
	}

	public function actionAdd () {
		$model = new Projects;

		if (isset ($_POST['Projects'])) {
			$model->attributes = $_POST['Projects'];
			if ($model->save()) {
				$this->redirect (['project/admin', 'edit' => 1]);
			}
		}

		$this->render('add', [
			'model' => $model
		]);
	}
}
