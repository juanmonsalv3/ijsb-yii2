<?php

namespace app\managers;

use app\models\Estudiantes;

class StudentsManager
{
	
	public function getAllStudentsQuery($params){
		$query = Estudiantes::find()
                ->with('grupoActual')
                ->innerJoin('grupos_estudiantes',
                	'estudiantes.id_estudiante = grupos_estudiantes.id_estudiante and anio = '.$params['year'])
                ->where(['activo' => 1])
                
                ->andFilterWhere([
                    'or',
                    ['like', 'estudiantes.nombres', $params['search']],
                    ['like', 'estudiantes.apellidos', $params['search']],
                ])
                ->orderBy($params['orderby'])
                ->limit($params['length'])
                ->offset($params['start']);
        
        if($params['group'] != null){
            $query->andWhere(['id_grupo' => $params['group']]);
        }

        return $query;
	}

	public static function getInstance(){

		return new self();
	}
}