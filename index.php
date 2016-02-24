<?php
//ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
session_start();
header("Content-type: text/html; charset=utf-8");
include_once('./common.php');
$dos = array('activitie','club','commember','complaint','consultation','detail',
    'edu','edumember','edusup','exit','file','finance','golf','hotel','login',
    'main','mange','member','order','product','restaurant','tour','user'
    );
$do = (!empty($_GET['do']) && in_array($_GET['do'], $dos))?$_GET['do']:'main';
if(is_mobile()){
	header("Status: 403 Not Found"); 
	exit;
}
include_once(ABSPATH.'./include/'.$do.'.func.php');

?>