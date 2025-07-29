<?php
function plugin_function($plugin = null){
	
	if (function_exists($plugin)) {$plugin();} else {}
	
}