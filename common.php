<?php
//set_magic_quotes_runtime(0);

if(PHP_VERSION < '4.1.0') {
    $_GET = &$HTTP_GET_VARS;
    $_POST = &$HTTP_POST_VARS;
    $_COOKIE = &$HTTP_COOKIE_VARS;
    $_SERVER = &$HTTP_SERVER_VARS;
    $_ENV = &$HTTP_ENV_VARS;
    $_FILES = &$HTTP_POST_FILES;
}

define('ABSPATH', dirname(__FILE__).'/');
include_once('./config.inc.php');
include_once(ABSPATH.'./include/common.func.php');

$magic_quotes_gpc = get_magic_quotes_gpc();
@extract(daddslashes($_COOKIE));
@extract(daddslashes($_POST));
@extract(daddslashes($_GET));
if(!$magic_quotes_gpc) {
    $_FILES = daddslashes($_FILES);
}

db_connect();
?>