<?php

spl_autoload_register(function($class_name){ 
		if(file_exists('../../core/Models/'.$class_name.'.php')){
			require_once '../../core/Models/'.$class_name.'.php';
		}
		elseif (file_exists('../../core/Controllers/'.$class_name.'.php')) {
			require_once '../../core/Controllers/'.$class_name.'.php';
		}
});

?>