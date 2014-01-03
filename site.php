<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="css.css" type="text/css" media="screen" />
<title>KDIS</title>
</head>
<body>
<ul id="menu">
	<li><a href="#">Display</a>
		<ul>
			<li><a href="first.php">KB Table - 1</a></li>
			<li><a href="second.php">KB Table -2</a></li>
		</ul>
	</li>
	<li>
		<a href="#">Input</a>
		<ul>
			<li><a href="?pid=input">Goal to be deduced</a></li>	
		</ul>
	</li>
	<li>
		<a href="#">Implement Algorithm</a>
		<ul>
			<li><a href="algo.php">Backward Chaining</a></li>	
		</ul>
	</li>
	
	
	
	<li><a href="about.html">About Application</a></li>
	<li><a href="contact.html">Contact Us</a></li>
</ul>
<br><br><br>
<center><table border="1"><tr><td><p><font face="Comic Sans MS" size ="4">Backward chaining (or backward reasoning) is an inference method that can be described (in lay terms) as working backward from the goal(s).<br>
It is used in automated theorem provers, proof assistants and other artificial intelligence applications, but it has also been observed in primates.<br>
In game theory, its application to (simpler) subgames in order to find a solution to the game is called backward induction. In chess, it is called <br>
retrograde analysis, and it is used to generate tablebases for chess endgames for computer chess. Backward chaining is implemented in logic<br>
programming by SLD resolution. Both rules are based on the modus ponens inference rule. It is one of the two most commonly used methods of <br>
reasoning with inference rules and logical implications – the other is forward chaining. Backward chaining systems usually employ a depth-first<br>
search strategy, e.g. Prolog.</font></p></tr></td></table></center><br><br>
<?php
if(isset($_GET['pid'])&&((strcmp($_GET['pid'],"input")==0)))
{
	if(isset($_POST['goal']))
	{
			require("include/dbinfo.php");
			$link=mysql_connect($server,$user,$pass)or die(errorReport(mysql_error()));
			mysql_select_db($db,$link);
			$create=mysql_query("create table input (goal varchar(500) NOT NULL)");
			$input=$_POST['goal'];
			$x=mysql_query("select * from input");
			$drop=mysql_query("drop table inference_array;");
			if(mysql_num_rows($x)==0)
			{
				$insert=mysql_query("insert into input values(\"$input\");");
				echo "<script type=\"text/javascript\">alert(\"Input Value Taken!!\")</script>";
			}
			else
			{
				$insert=mysql_query("update input set goal=\"$input\";");
				echo "<script type=\"text/javascript\">alert(\"Input Value Taken!!\")</script>";
			}
			
	}


		echo "<center><form action=\"site.php?pid=input\" method=\"post\">
		Goal To Be Deduced: <input type=\"text\" name=\"goal\">
		<input type=\"submit\" name=\"submit\" value=\"Enter\" >
		</form></center>";
		
}
?>		
</body>
</html>