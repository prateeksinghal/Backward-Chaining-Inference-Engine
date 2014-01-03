In this repository I have implemented the Backward Chaining Inference Engine using PHP and MySQL Technologies.

It is a Web Application asking the user to enter Knowledge Base and Goal to be deduced and gives in the form of output that
whether the Goal is TRUE or FALSE. Also provides the facility for the user to have the explanation for the same.


============REQUIREMENTS============

1. Web Browser (e.g Google Chrome, Mozilla FireFox, Internet Explorer, etc.)
2. Wamp Server or (installed individually PHP & MySql)




==========STEPS==========

1. Run wamp server with PHP and MySQL Services.
2. Change config in /include/dbinfo.php according to your settings of MySQL
3. Open MySQL console and execute command:
	>mysql source <path to fc.sql file>  /* bc.sql file is provided in the source code folder */
4. Open localhost/<path to home.php> in your web-browser
