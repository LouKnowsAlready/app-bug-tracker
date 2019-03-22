<?php

class InstallApp{

	protected $controller = 'install';
	protected $method = 'index';
	protected $params = [];

	public function __construct(){
		$url = $this->parseUrl();

		if(file_exists('installation/controllers/'. $url[0] . '_controller.php')){
			$this->controller = $url[0];
			unset($url[0]);
		}

		require_once 'installation/controllers/'. $this->controller . '_controller.php';

		$this->controller = $this->cleanCntrlName($this->controller) . 'Controller';
		$this->controller = new $this->controller;

		if(isset($url[1])){
			if(method_exists($this->controller, $url[1])){
				$this->method = $url[1];
				unset($url[1]);
			}
		}

		$this->params = $url ? array_values($url) : [];

		call_user_func_array([$this->controller,$this->method], $this->params);

	}

	public function parseUrl(){
		if(isset($_GET['url'])){
			return $url = explode('/',filter_var(rtrim($_GET['url'],'/'), FILTER_SANITIZE_URL));
		}
	}

	private function cleanCntrlName($url){
		return str_replace("-", "", $url);
	}


}