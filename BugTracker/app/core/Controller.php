<?php

class Controller{
	

	public function get_model($model){
		//require_once '../app/models/'. $model . '.php';

		return new $model();
	}

	public function render_view($layout='', $view_name, $method_name, $data = []){
		// $view_name, $method_name, and $data will be available on the layout
		if($layout == '')
			include "BugTracker/app/views/{$view_name}/{$method_name}.php";
		else
			include 'BugTracker/app/views/layout/'. $layout . '.php';
	}

	public function get_deleted_records($data, $items){
		$del_ids = [];
	
		if(!empty($data)){
			foreach($data as $row){
	  			$id = $row['id'];
	  			
	  			if(!array_key_exists($id,$items)){
	    			array_push($del_ids,$id);
	  			}     
			}
		}

		return $del_ids;
	}


}