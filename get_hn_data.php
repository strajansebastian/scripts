<?php

include("functions.php");

header('Content-Type: application/json');

$connection_values = " --os-username ADMIN_USERNAME --os-tenant-name ADMIN_TENANT --os-auth-url AUTH_URL --os-password ADMIN_PASSWORD ";

$hn = $_GET['hn'];
$request_type = $_GET['type'];
$result = array();
$result['status'] = "nada";

if ($request_type == 'usage') {
	$result = get_hn_usage($hn);
} else if ($request_type == 'server_list') {
	$result = get_vm_list($hn);
}

echo json_encode($result);

?>
