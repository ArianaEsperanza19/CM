<?php

function autocargar($classname){
	include 'Controladores/' . $classname . '.php';
}

spl_autoload_register('autocargar');