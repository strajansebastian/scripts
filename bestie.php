<html>
<head>
	<title>The Beastie</title>
	<script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
	<script src="bestie_imp.js"></script>
</head>

<body>

<table class='table' id='table_osdata'>
<tr>
	<th>Hardware node</th>
	<th>Total Memory (MB)</th><th>Used Memory (MB)</th>
	<th>Total Disk Space (GB)</th><th>Available Disk Space (GB)</th>
	<th>Total CPU (Threads) </th><th>Used CPU (Threads)</th>
	<th>VM #</th><th><input class="btn btn-success" onclick="get_full_server_list()" value="Get ALL VMs" /></th>
<tr>

<table>

<script>
get_data();
</script>

<table class="table">
<tr><th>Code</th><th>Color</th><th>Meaning</th></tr>
<tr><td>#6CD27C</td><td style="background-color:#6CD27C;"></td><td>under 25 percent</td></tr>
<tr><td>#F9F787</td><td style="background-color:#F9F787;"></td><td>under 50 percent</td></tr>
<tr><td>#F7C835</td><td style="background-color:#F7C835;"></td><td>under 70 percent</td></tr>
<tr><td>#F77735</td><td style="background-color:#F77735;"></td><td>under 80 percent</td></tr>
<tr><td>#F70035</td><td style="background-color:#F70035;"></td><td>under 90 percent</td></tr>
<tr><td>brown</td><td style="background-color:brown;"></td><td>under 95 percent</td></tr>
<tr><td>black</td><td style="background-color:black;"></td><td>over 95 percent</td></tr>
<table>

</body>
</html>
