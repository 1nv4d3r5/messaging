<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

/**
* This is our API routing file, it's how all API calls are routed to their URLs
*/

$url = $_SERVER['REQUEST_URI'];
$split = explode('/', $url);
try {
	if(empty($split[1]) || empty($split[2])) {
		throw new Exception('Invalid API call', 400);
	}
	if(empty($split[0])) {
		unset($split[0]);
	}
	$folder = $split[1];
	$file = explode('?', $split[2]);
	$file = $file[0];
	if(!is_dir($split[1])) {
		throw new Exception('Invalid API group call', 404);
	}
	if(!is_file($folder . '/' . $file . '.php')) {
		throw new Exception('Invalid API action call', 404);
	}
	$con = mysqli_connect('localhost', 'root', '', 'messaging');
	/**
	* Do some work on this
	*/
	require_once $folder . '/functions.php';
	require_once $folder . '/' . $file . '.php';
	echo json_encode($file::call($con));
} catch(Exception $e) {
	echo json_encode(['code' => $e->getCode(), 'message' => $e->getMessage()]);
	exit;
}