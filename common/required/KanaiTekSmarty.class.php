<?php
require_once('Smarty.class.php');
	
class MySmarty extends Smarty{	
	//Class constructor - directives set for each instance
	public function __construct(){
		parent::__construct();
		
		$this->template_dir = 'templates/';
		$this->compile_dir = 'templates_c/';
		$this->config_dir = 'config/';
		$this->cache_dir = 'cache/';
		
		$this->setTemplateDir('templates/');
		$this->setCompileDir('templates_c/');
		$this->setCacheDir('cache/');
		$this->setConfigDir('configs/');
				
		//Place any other Smarty directives here
		$this->autoload_filters = array('output'=> array('trimwhitespace'));
	}
}
?>
