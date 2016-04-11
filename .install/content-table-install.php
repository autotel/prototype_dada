<?php

require_once("../models/settings.php");
//Dbal Support - Thanks phpBB ; )
require_once("../models/db/".$dbtype.".php");
require_once("../models/funcs.user.php");

$db = new $sql_db();
if(is_array($db->sql_connect(
						$db_host,
						$db_user,
						$db_pass,
						$db_name,
						$db_port,
						false,
						false
))) {
	echo "<strong>Unable to connect to the database, check your settings.</strong>";
	echo "<p><a href=\"?install=true\">Try again</a></p>";
}else{
	$db_issue = false;
	$content_sql = "
		CREATE TABLE IF NOT EXISTS `".$db_content_table."` (
		`post_id` int(11) NOT NULL auto_increment,
		`creation_date` int(11) NOT NULL,
		`edition_date` int(11) NOT NULL,
		`last_visit` int(11) NOT NULL,
		`creator_id` int(11) NOT NULL,
		`allowed_groups` varchar(30) NOT NULL,
		`allowed_users` varchar(30) NOT NULL,
		`url` varchar(225) NOT NULL,
		`content` LONGTEXT,
		`postmeta` LONGTEXT,
		PRIMARY KEY (`post_id`),
		FOREIGN KEY (`creator_id`) REFERENCES userpie_users(`user_id`)
		) engine=myisam DEFAULT charset=latin1 auto_increment=2 ;
	";

	if($db->sql_query($content_sql))
	{
		echo "<p>".$db_content_table." table created.....</p>";
	}
	else
	{
		echo "<p>Error constructing ".$db_table_prefix."groups table.</p><br /><br /> DBMS said: ";

		echo print_r($db->_sql_error());
		$db_issue = true;
	}

	if(!$db_issue)
	echo "<p><strong>Contents database setup complete</p>";
	else
	echo "<p><a href=\"?install=true\">Try again</a></p>";
}
?>
