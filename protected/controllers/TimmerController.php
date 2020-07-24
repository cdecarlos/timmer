<?php
class TimmerController extends Controller {
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

	public function actionIndex ($day = null) {
		if (!isset ($day))
			$day = date('Y-m-d');
    $criteria = new CDbCriteria;
    $criteria->addCondition ('idUser = ' . Yii::app()->user->id);
		$criteria->order = 'timeInit DESC';
		$criteria->limit = 100;
		$blocksModel = Blocks::model()->findAll($criteria);

		$blocks = [];
		foreach ($blocksModel as $b) {
			$index = strtotime($b->day);
			if (!isset ($blocks[$index])) {
				$blocks[$index] = [
					'date' => $b->day,
					'hours' => 0,
					'items' => [],
				];
			}
			if ($b->timeEnd != null) {
				$blocks[$index]['hours']+= $b->timeEnd - $b->timeInit;
			} else {
				$blocks[$index]['hours']+= time() - $b->timeInit;
			}
			$blocks[$index]['items'][] = $b;
		}
		krsort($blocks);

		$criteria = new CDbCriteria;
    $criteria->addCondition ('idUser = ' . Yii::app()->user->id);
    $criteria->addCondition ('timeEnd IS NULL');
		$criteria->order = 'timeInit DESC';
		$actual = Blocks::model()->find($criteria);

		$this->render('index', [
      'blocks' => $blocks,
			'actual' => $actual,
			'day' => $day
    ]);
	}

	public function actionAdd ($actualId = null) {
		$model = new Blocks;
		$model->day = date('Y-m-d');

		$model->timeInit = date('Y-m-d\TH:i', time());

		if (isset ($_POST['Blocks'])) {
			$model->attributes = $_POST['Blocks'];
			$model->idUser = Yii::app()->user->id;

			// If received empty set last value
			if ($model->timeInit == '') {
				$model->timeInit = time();
			} else {
				$model->timeInit = strtotime($model->timeInit);
			}

			// If received empty set null
			if ($model->timeEnd == '') {
				$model->timeEnd = null;
			} else {
				$model->timeEnd = strtotime($model->timeEnd);
			}

			if ($model->save()) {
				if ($actualId != null) {
					$actual = Blocks::model()->findByPk($actualId);
					if ($actual != null) {
						$actual->timeEnd = time();
						$actual->save();
					}
				}
				$this->redirect (['timmer/index']);
			}
		}

		$this->render('add', [
			'model' => $model
		]);
	}

	public function actionStop ($id) {
		$model = Blocks::model()->findByPk($id);
		$model->timeEnd = time();
		$model->save();

		$this->redirect (['timmer/index']);
	}

	public function actionEdit ($id) {
		$model = Blocks::model()->findByPk($id);

		$timeInit = $model->timeInit;
		$model->timeInit = date('Y-m-d\TH:i', $model->timeInit);
		if ($model->timeEnd != null)
			$model->timeEnd = date('Y-m-d\TH:i', $model->timeEnd);

		if (isset ($_POST['Blocks'])) {
			$model->attributes = $_POST['Blocks'];
			// If received empty set last value
			if ($model->timeInit == '') {
				$model->timeInit = $timeInit;
			} else {
				$model->timeInit = strtotime($model->timeInit);
			}

			// If received empty set null
			if ($model->timeEnd == '') {
				$model->timeEnd = null;
			} else {
				$model->timeEnd = strtotime($model->timeEnd);
			}

			if ($model->save()) {
				$this->redirect (['timmer/index']);
			}
		}

		$this->render('add', [
			'model' => $model
		]);
	}

	public function actionGetDay ($day = null) {
		if (!isset ($day))
			$day = date('Y-m-d');
		$max = 8 * 60 * 60; // Seconds from 8 hours
		$total = 0;
		$blocks = Blocks::model()->findAllByAttributes ([
			'day' => $day
		]);

		foreach ($blocks as $b) {
			if ($b->timeEnd == null) {
				$total+= time() - $b->timeInit;
			} else {
				$total+= $b->timeEnd - $b->timeInit;
			}
		}

		$percent = $total / $max * 100;
		echo json_encode ([
			'percent' => $percent,
			'total' => Blocks::formatSeconds ($total)
		]);
	}

	public function actionGetActual ($id) {
		$res = '';
		$actual = Blocks::model()->findByPk ($id);
		if ($actual != null) {
			$res = $actual->init . ' ' . $actual->toNow;
		}
		echo $res;
		die;
	}

	public function actionPlay ($id = null) {
		$model = new Blocks;
		$model->day = date('Y-m-d');
		$model->timeInit = date('Y-m-d\TH:i', time());

		if ($id != null) {
			$reload = Blocks::model()->findByPk($id);
			if ($reload != null) {
				$model->title = $reload->title;
				$model->idProject = $reload->idProject;
			}
		}

		if (isset ($_POST['Blocks'])) {
			$model->attributes = $_POST['Blocks'];
			$model->idUser = Yii::app()->user->id;

			// If received empty set last value
			if ($model->timeInit == '') {
				$model->timeInit = time();
			} else {
				$model->timeInit = strtotime($model->timeInit);
			}

			// If received empty set null
			if ($model->timeEnd == '') {
				$model->timeEnd = null;
			} else {
				$model->timeEnd = strtotime($model->timeEnd);
			}

			if ($model->save())
				$this->redirect (['timmer/index']);
		}

		$this->render('add', [
			'model' => $model
		]);
	}
}
