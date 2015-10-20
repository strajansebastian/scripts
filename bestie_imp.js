
var hns = ['compute-node01', 'compute-node02', 'compute-node03', 'compute-node04'];

function get_data() {
	for (var index in hns) {
		get_row(hns[index]);
	}

	setInterval(function() { add_colors() }, 1000);
}

function get_full_server_list() {
	for (var index in hns) {
		get_server_list(hns[index]);
	}
}

function get_row(hn) {
	$.getJSON( "get_hn_data.php?type=usage&hn=" + hn, function( json ) {
		var row_data = "<tr class='td_data'>\n";
		row_data += "<td class='td_hardware_node'>" + json["name"] + "</td>\n";
		for (var prop in json['prop']) {
			row_data += "<td class='td_val_" + prop + "'>" + json['prop'][prop] + "</td>\n";
		}
		row_data += "<td class='td_vms' id='td_" + json["name"] + "'>";
		row_data += "<input class='btn btn-primary btn-sm' type='button' onclick='get_server_list(\"" + json['name'] + "\")' value='Get VM list' style='font-size:10px; padding: 0px 4px 0px 4px;'>";
		row_data += "</td>\n</tr>\n";
		$("#table_osdata tr:last").after(row_data);
	});
}

function get_server_list(hn) {
	$.getJSON( "get_hn_data.php?type=server_list&hn=" + hn, function( json ) {
		console.log(json);
		$("#td_" + hn).text(json["vm_list"].sort().join(", "));
	});
}

function add_colors() {
	$("#table_osdata tr.td_data").each(function () {
		var row_ref = this;
	
		var data = {};
		var prop = ['memory_mb', 'memory_mb_used', 'local_gb', 'disk_available_least', 'vcpus', 'vcpus_used'];
		prop.forEach(function(entry) {
		    data[entry] = parseInt($(row_ref).find(".td_val_" + entry).text());
		});
	
	        var groups = [['memory_mb', 'memory_mb_used'], ['local_gb', 'disk_available_least'], ['vcpus', 'vcpus_used']];
		groups.forEach(function(entry) {
			var used_percentage;
			if (entry[1].indexOf("available") > -1) {
				used_percentage = ((data[entry[0]] - data[entry[1]]) / data[entry[0]]) * 100;
			} else {
				used_percentage = (data[entry[1]] / data[entry[0]]) * 100;
			}
			// console.log(used_percentage);
			var color = "pink";
			if (used_percentage < 25) { color = "#6CD27C";
			} else if (used_percentage < 50) { color = "#F9F787";
			} else if (used_percentage < 70) { color = "#F7C835";
			} else if (used_percentage < 80) { color = "#F77735";
			} else if (used_percentage < 90) { color = "#F70035";
			} else if (used_percentage < 95) { color = "brown";
			} else { color = "black";
				$(row_ref).find(".td_val_" + entry[1]).css("color", "white");
			}
			$(row_ref).find(".td_val_" + entry[1]).css("background-color", color);
		});
	});
}
