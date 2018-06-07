<?php
require_once 'master/epiqworx/epiqrithm/full.php';

$action = filter_input(INPUT_POST,'action');
if($action == null){
	$action = filter_input(INPUT_GET, 'action');
	if($action == null){
		$action = 'home';
	}
}
switch ($action) {
	case 'home':
		$title = "SICT SBS";
		require_once 'master/view/default/home.php';
		break;
	case 'phpinfo':
	phpinfo();
	break;
	case 'test':
		echo PATH;
		break;
	default:
		echo "case not handle for action <b>$action</b>";
		break;
}