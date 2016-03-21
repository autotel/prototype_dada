<?php
//source: Userpie
require_once("/models/settings.php");
//Dbal Support - Thanks phpBB ; )
require_once("/models/db/".$dbtype.".php");
require_once("/models/funcs.user.php");
$db = new $sql_db();
if(is_array($db->sql_connect($db_host,$db_user,$db_pass,$db_name,$db_port,false,false))) {
	echo "<strong>ContentFunctions was unable to connect to the content database</strong>";
	echo "Contact the administrator for this.";
	print_r($_SERVER);
}
//the $query should never be direct user input nor directly gotten from post or get
function sql($query){
	global $db;
	if($db->sql_query($query)){
		echo "<p>".$query." executed </p>";
	}else{
		echo "<p>couln't $query: ";
		echo print_r($db->_sql_error());
	}
	return $db;
}

	if(!$db_issue)
	echo "<p><strong>Contents database setup complete</p>";
	else
	echo "<p><a href=\"?install=true\">Try again</a></p>";

?>
