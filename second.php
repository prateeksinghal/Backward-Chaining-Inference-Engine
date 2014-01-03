<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<body>
<style>
body {background-image:url('bg.jpg');}
</style>
<?php
require("include/dbinfo.php");
$link=mysql_connect($server,$user,$pass)or die(errorReport(mysql_error()));
mysql_select_db($db,$link);

mysql_query("use $db");
echo "<center><h1> KB Table - 2 </h1></center>";
echo "<center><table border=\"2\">";
echo '<tr><th>RULE NAME</th><th>DEPENDENT FACTS</th><th>Comes from previous Rule</th><th>DERIVED FACT</th><th>Leads to next Rule</th></tr>';
$result=mysql_query("select * from kb2");
		for($i=0;$i<mysql_num_rows($result);$i=$i+1)
		{
			$row=mysql_fetch_array($result);
			$fact=$row['rule'];
			$index=$row['dependFacts'];
			$bas=$row['previousRule'];
			$level=$row['derived'];
			$lhs=$row['nextRule'];
			echo "<tr><td>$fact</td><td>$index</td><td>$bas</td><td>$level</td><td>$lhs</td></tr>";
		}
		echo "</table></center>";

?>
</body>
</html>