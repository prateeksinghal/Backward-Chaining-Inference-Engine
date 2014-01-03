<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<body>
<style>
body {background-image:url('bg.jpg');}

.right
{
float:right;
width:300px;
margin-top:-150px;
margin-bottom:100%;
}
</style>




<!--<form action="site.php"><input id="edit-submit" class="form-submit" type="image" src="back.jpg" name="submit">-->
<font face="Comic Sans MS" size="40">&nbsp<a href="site.php"><img src="bac.jpg" align="left"></a><h1> &nbsp&nbsp&nbsp&nbsp&nbsp&nbspINPUT THE TRUTH VALUES </font></h1>
<br> <br><br>

<?php
require("include/dbinfo.php");
$link=mysql_connect($server,$user,$pass)or die(errorReport(mysql_error()));
mysql_select_db($db,$link);
mysql_query("use $db");

echo"<div class=\"right\">";

$q10=mysql_query("select * from kb1 order by level");
echo "<h3> <center><u>Fact Table </u></h3></center>";
echo "<center><table border=\"2\">";
echo '<tr><th>FACT</th><th>INDEX</th></tr>';
for($a=0;$a<mysql_num_rows($q10);$a=$a+1)
{
$r10=mysql_fetch_array($q10);
$fa=$r10['fact'];
$de=$r10['dex'];
echo "<tr><td>$fa</td><td>$de</td></tr>";
}
	echo "</table></center>";



echo "</div>";

$input=mysql_query("select * from input");
$row=mysql_fetch_array($input);
$table=mysql_query("create table inference_array (fact varchar(500) NOT NULL,num varchar(500) NOT NULL, truth varchar(7) NOT NULL,PRIMARY KEY (fact))");
//$inference_array["foo"]="1";
//echo $inference_array["foo"];
$goal_TBD=$row['goal'];


//searching in KB-1
		$q1=mysql_query("select fact from kb1");
		$f=0;

		for($i=0;$i<mysql_num_rows($q1);$i=$i+1)
		{
			$row=mysql_fetch_array($q1);
			$fact=$row['fact'];
			if($fact==$goal_TBD)
			{
				$q2=mysql_query("select basicDerived from kb1 where fact=\"$fact\";");
				$r2=mysql_fetch_array($q2);
				$basDer=$r2['basicDerived'];
				$f=1;
				break;
			}
		}
		
		//Implement backward Chaining
		if($f==0)
			echo"<script type=\"text/javascript\">alert(\"ERROR : The Goal input is not found in KB-1..!!!\")</script>";
		else
		{
			if($basDer=="Basic")
			{
				echo "<script type=\"text/javascript\">alert(\"ERROR : The Goal is a Basic Fact so there is no need to Deduce it..!!!\")</script>";
				
			}
			else if($basDer=="Derived")
			{
				BackwardChainingInferenceEngine($goal_TBD);
			}
			$q8=mysql_query("select * from inference_array where fact=\"$goal_TBD\";");
			$q9=mysql_query("select * from inference_array;");
			$number=mysql_num_rows($q9);
			$r8=mysql_fetch_array($q8);
			$truval=$r8['truth'];
			//echo "value od str=\"$str\" ";
			if($truval=="true")
			{
				echo "<script type=\"text/javascript\">alert(\"Result: \'$goal_TBD\' is TRUE\")</script>";
			}
			else
			{
				echo "<center><table border=\"1\" color=\"000000\" ><tr><th>Result till now: \"$goal_TBD\" is FALSE</th></tr></table></center><br>";
			}
			echo "<center><h3> Inference Array </h3></center>";
			echo "<center><table border=\"2\">";
			echo '<tr><th>FACT</th><th>INDEX</th><th>TRUTH VALUE</th></tr>';
			for($i=0;$i<mysql_num_rows($q9);$i=$i+1)
			{
				$row=mysql_fetch_array($q9);
				$fact=$row['fact'];
				$index=$row['num'];
				$tval=$row['truth'];
				
				echo "<tr><td>$fact</td><td>$index</td><td>$tval</td></tr>";
			}
			echo "</table></center>";
			
		}

//print_r($inference_array);
function BackwardChainingInferenceEngine($goal_TBD)
{		
		//Search goalTBD in KB-1
		$q1=mysql_query("select * from kb1");
		for($i=0;$i<mysql_num_rows($q1);$i=$i+1)
		{
			$row=mysql_fetch_array($q1);
			$fact=$row['fact'];
			if($fact==$goal_TBD)
			{
				$q2=mysql_query("select rhs from kb1 where fact=\"$fact\";");
				$r2=mysql_fetch_array($q2);
				$rhs=$r2['rhs'];
				$tok=strtok($rhs," \n\t");
				$rules =array();
				$count=0;
				
				//Tokenizer for rhs rules
				while($tok!==false)
				{
					$rules[$count]=$tok;
					$count=$count+1;
					$tok=strtok(" \n\t");
				}//end of rule tokenizer
				
				//Search dependent fact for each rule
				for($k=0;$k<$count;$k=$k+1)
				{
					//echo "$rules[$k]<br />";
					
					
					//Search rule in KB-2
					$q3=mysql_query("select * from kb2");
					for($j=0;$j<mysql_num_rows($q3);$j=$j+1)
					{
						
						$r3=mysql_fetch_array($q3);
						$rule=$r3['rule'];
						
						if($rules[$k]==$rule)
						{
							$q4=mysql_query("select dependFacts from kb2 where rule=\"$rule\";");
							$r4=mysql_fetch_array($q4);
							$depFac=$r4['dependFacts'];
							$fac=strtok($depFac,".+! \n\t");
							$fcts =array();
							$count1=0;
				
							//Tokenizer for rhs facts
							while($fac!==false)
							{
								$fcts[$count1]=$fac;
								$count1=$count1+1;
								
								$fac=strtok(".+! \n\t");
							}//end of facts tokenizer
							//echo "count = $count1 <br/>";
							for($m=0;$m<$count1;$m=$m+1)
							{
								$q6=mysql_query("select fact from inference_array where fact=\"$fcts[$m]\";");
								
								if(mysql_num_rows($q6)==0)
								{
									//echo "$fcts[$m] <br />";
									//Search KB1 for for the fact
									$q5=mysql_query("select * from kb1");
									for($l=0;$l<mysql_num_rows($q5);$l=$l+1)
									{
										$r5=mysql_fetch_array($q5);
										$fj=$r5['dex'];
										
										if($fj==$fcts[$m])
										{
											
											$type=$r5['basicDerived'];
											$fval=$r5['fact'];
											if($type=="Derived")
											{
												BackwardChainingInferenceEngine($fval);
											}
											else
											{
												if(isset($_GET['pid'])&&((strcmp($_GET['pid'],"$fj")==0)))
												{
													if(isset($_POST['truth']))
													{
														$truth=$_POST['truth'];
														$insert=mysql_query("insert into inference_array values(\"$fval\",\"$fj\",\"$truth\")");
													}
														 
												}
												

												echo"<center><form action=\"algo.php?pid=$fj\" method=\"post\">
												<table><tr><th>Enter truth value for fact : \"$fval\" -- ></th><th><input type=\"text\" name=\"truth\"></th>
												<th><input type=\"submit\" onclick=\"demoDisplay()\" value=\"Submit\"></th></tr></table>
												</form></center>";
												
											}
										}
									}//end of loop to search fact in KB1
									
									
								}
								
								//echo "$fac <br />";
							}//end of dependent facts loop
							
									//echo $str;
									$str=$depFac;
									$q11=mysql_query("select dex from kb1 where fact=\"$goal_TBD\";");
									$r11=mysql_fetch_array($q11);
									$dexi=$r11['dex'];
									echo "<center><table border=\"1\"><tr><th>For \"$goal_TBD ($dexi)\" to be true -- >$str should be true</th></tr></table></center><br>";
									//echo $goal_TBD;
									$token=strtok($str,".+!() \n\t");
									while($token!==false)
									{
										$q8=mysql_query("select * from inference_array where num=\"$token\";");
										$r8=mysql_fetch_array($q8);
										$truval=$r8['truth'];
										if($truval=="true")
											$str=str_replace($token,"1",$str);
										else
											$str=str_replace($token,"0",$str);
										$token=strtok(".+!() \n\t");
									}
									
									$str=str_replace("."," AND ",$str);
									$str=str_replace("+"," OR ",$str);
									$str="(".$str.")";
									echo "<center><b><u> Boolean Expression:</u></b>&nbsp&nbsp&nbsp$str</center><br>";
									echo "<hr size=\"5\" color=\"000000\">";
									eval("\$ans=$str;");
									if($ans!=1)
										$final="false";
									else
										$final="true";
									if($final=="true")
									{
										
										$q9=mysql_query("select dex from kb1 where fact=\"$goal_TBD\";");
										$r9=mysql_fetch_array($q9);
										$variable=$r9['dex'];
										$insert=mysql_query("insert into inference_array values(\"$goal_TBD\",\"$variable\",\"true\")");
										//$insert=mysql_query("update  inference_array set truth=\"true\" where num=\"$variable\" ");
										goto label;
									}
									/*else
									{	$q9=mysql_query("select dex from kb1 where fact=\"$goal_TBD\";");
										$r9=mysql_fetch_array($q9);
										$variable=$r9['dex'];
										$insert=mysql_query("insert into inference_array values(\"$goal_TBD\",\"$variable\",\"false\")");
									}*/
						}
					}
				}// end of Search in KB-2
			}
			
		}
		label: return;
}//end of function
	

//echo $val;











?>
</body>
</html>