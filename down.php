<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-3-25
 * Time: 下午4:49
 */
$file_url=$_GET['file_url'];
$file_suffix=$_GET['suffix'];
$file_name=$_GET['file_name'].'.'.$file_suffix;
header("Content-Disposition: attachment; filename=$file_name");
readfile("$file_url");
