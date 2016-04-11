<?php
//pendant: erase this file
include_once("config.php");
//based in userpie code

//write content to an entry by specifying url field and content
function writeUrlContent($url=NULL,$content=NULL)
{
	global $db,$db_content_table;
	echo $content;
	echo $db->sql_escape(sanitize($content));
	if($url!=NULL&&$content!=NULL)
	{
		$sql = "UPDATE ".$db_content_table."
				SET content = '".$db->sql_escape(sanitize($content))."'
				WHERE
				url ='".$db->sql_escape(sanitize($url))."'
				LIMIT 1";

		return ($db->sql_query($sql));
	}else{
		return ("Error in ContentFunctions.php: Requested to write content without specifying either the Url or the Contents");
	}
}

//get content from an entry by specifying its url field
function getUrlContent($url=NULL)
{
	//pendant: check that loggedin user has permission to see content.
	global $db,$db_content_table;

	if($url!=NULL)
	{
		$sql = "SELECT * FROM ".$db_content_table."
				WHERE
				url = '".$db->sql_escape(sanitize($url))."'
				LIMIT
				1";
				//will sanitize remove slashes?
	}
	else
	{
		die ("Error in ContentFunctions.php: Asked for content without specifying the url");
	}

	$result = $db->sql_query($sql);

	$row = $db->sql_fetchrow($result);

	return ($row);
}

// check if any content has the url. false if doesn't, the id if it does
function existsUrlContent($url){
	//pendant: check that loggedin user has permission to see content.
	global $db,$db_content_table;
	if($url!=NULL)
	{
		echo ((($url)));
		$sql = "SELECT * FROM ".$db_content_table."
				WHERE
				url = '".$db->sql_escape(sanitize($url))."'
				LIMIT
				1";
	}
	else
	{
		die ("Error in ContentFunctions.php: Asked for content without specifying the url");
	}

	$result = $db->sql_query($sql);

	$row = $db->sql_fetchrow($result);

	return ($row['post_id']);
}

echo writeUrlContent("test",'{name:"hola", try:"tes"}');
?>
