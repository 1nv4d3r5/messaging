<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

$url = $_SERVER['REQUEST_URI'];
$split = explode('/', $url);
if(empty($split[0])) {
    unset($split[0]);
}
$folder = $split[1];
$file = explode('?', $split[2]);
$file = $file[0];
if(!is_dir($split[1])) {
    echo json_encode(array(
        'status' => 'ERROR',
        'message' => 'Invalid api group call'
    ));
    exit;
}
if(!is_file($folder . '/' . $file . '.php')) {
    echo json_encode(array(
        'status' => 'ERROR',
        'message' => 'Invalid api action call'
    ));
    exit;
}
$con = mysqli_connect('localhost', 'root', '', 'messaging');
require_once $folder . '/' . $file . '.php';
$file::call($con);