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
echo "<center><h1> KB Table - 1 </h1></center>";
echo "<center><table border=\"2\">";
echo '<tr><th>FACT</th><th>INDEX</th><th>Basic or Derived</th><th>LEVEL</th><th>List of rules where fact appeared in LHS</th><th>List of rules where fact appeared in LHS</th><th>This fact is derived from</th></tr>';
$result=mysql_query("select * from kb1");
		for($i=0;$i<mysql_num_rows($result);$i=$i+1)
		{
			$row=mysql_fetch_array($result);
			$fact=$row['fact'];
			$index=$row['dex'];
			$bas=$row['basicDerived'];
			$level=$row['level'];
			$lhs=$row['lhs'];
			$rhs=$row['rhs'];
			$der=$row['derivedFrom'];
			echo "<tr><td>$fact</td><td>$index</td><td>$bas</td><td>$level</td><td>$lhs</td><td>$rhs</td><td>$der</td></tr>";
		}
		echo "</table></center>";
?>
</body>
</html>