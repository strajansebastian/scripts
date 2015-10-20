<?php

# change the values from below to your opentack setup
$connection_values = " --os-username ADMIN_USERNAME --os-tenant-name ADMIN_TENANT --os-auth-url AUTH_URL --os-password ADMIN_PASSWORD ";

function get_hn_usage($hn) { 
	global $connection_values;

	$result = array();
	
	if (preg_match("/^[a-z0-9_]{1,50}$/i", $hn)) {
		$result['status'] = 'bon';
	} else {
		$result['status'] = 'nbon';
		return json_encode($result);
	}

	$result['name'] = $hn;
	$result['prop'] = array();
	
	$val = exec("nova $connection_values hypervisor-show $hn 2>&1 | sed -r 's/( |-){2,}/\\1/g' | tr '\n' '}'");
	foreach (array('memory_mb', 'memory_mb_used', 'local_gb', 'disk_available_least', 'vcpus', 'vcpus_used', 'running_vms') as $prop) {
		$prop_value = exec("echo '$val' | tr '}' '\n' | grep '^| $prop |' | sed -r 's/^[|] $prop [|] ([0-9]+) [|]$/\\1/'");
		$result['prop'][$prop] = $prop_value;
	}

	return $result;
}

function get_vm_list($hn) {
	global $connection_values;
	$result = array();

	if (preg_match("/^[a-z0-9_]{1,50}$/i", $hn)) {
		$result['status'] = 'bon';
	} else {
		$result['status'] = 'nbon';
		return json_encode($result);
	}

	$val = exec("nova $connection_values hypervisor-servers $hn 2>&1 | grep 'instance-' | sed -r 's/( |-){2,}/\\1/g' | tr '\n' '}' | sed -r 's/[ }]+\$//'");
	$all_servers = explode('}', $val);

	$result['name'] = $hn;
	$result['vm_list'] = array();

	foreach ($all_servers as $vm) {
		$vm_val = exec("echo '$vm' | sed -r 's/^[|]\s+([a-zA-Z0-9-]+)\s+[|]\s+instance-.+\s+$hn\s+.+$/\\1/g' | xargs nova $connection_values show | tr '\n' '}'");
		$vm_name = exec("echo '$vm_val' | tr '}' '\n' | grep ' name ' | sed -r 's/^[|]\s+name\s+[|]\s+([a-zA-Z0-9_-]+)\s+[|]\s*\$/\\1/'");
		$result['vm_list'][] = $vm_name;
	}

	return $result;
}

?>
