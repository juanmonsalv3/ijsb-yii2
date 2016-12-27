<?php

namespace app\controllers;

use Yii;
use app\classes\Security;
use app\controllers\BaseController;
use app\models\Grupos;
use app\managers\StudentsManager;
use yii\helpers\ArrayHelper;

class StudentsController extends BaseController
{
	public function actionIndex(){
		$grupos = ArrayHelper::map(Grupos::find()->orderBy('id_grupo')->all(),'id_grupo', 'nombre');

		$view =[
			'grupos' => $grupos
		];
		return $this->render('list',$view);
	}

	public function actionList(){

		$columns_map =[
			0 => 'id_grupo',
			1 => 'apellidos'
		];

		$post = \Yii::$app->getRequest()->post();

		$post['year'] = Yii::$app->cache->get('parametros')['anioencurso']['valor'];

		$orderby = $columns_map[$post['order'][0]['column']];
		$orderby .= ' ' .$post['order'][0]['dir'];

		$post['orderby'] = $orderby;

		$query = StudentsManager::getInstance()->getAllStudentsQuery($post);

		$data = $query->asArray()->all();

		$data = $this->formatStudentsRows($data);
		$totaldata = $query->count();

		$json_data = array(
                "draw"            => intval( $post['draw'] ),
                "recordsTotal"    => intval( $totaldata ),
                "recordsFiltered" => intval( $totaldata ),
                "data"            => $data
            );
		echo json_encode($json_data);
	}

	public function formatStudentsRows($array){

		$formatted_data = array();
		foreach ($array as $row) {
			$student = array();
			$student['nombres'] 	= $row['apellidos'] . ' ' .$row['nombres'];
			$student['grupo'] 	= $row['grupoActual']['nombre'];
			$student['id_estudiante'] 	= Security::getInstance()->encrypt($row['id_estudiante']);
			$formatted_data[] = $student;
		}

		return $formatted_data;
	}

	public function actionView($id){
		print_r(Security::getInstance()->decrypt($id));
	}

	public function actionGradesReport($id){
		$id = Security::getInstance()->decrypt($id);

		Yii::$app->runAction('informes/boletin', ['id'=>$id]);
	}
}