<?php
//pendant: erase this file
include_once("config.php");
//based in userpie code

//write content to an entry by specifying url field and content
function writeUrlContent($url=NULL,$content=NULL)
{
	global $db,$db_content_table,$loggedInUser;
	echo $url;
	echo $db->sql_escape(sanitize($content));
	if(getUrlContent($url)){
		echo ("updating an existing content");
		if($url!=NULL&&$content!=NULL)
		{
			$sql = "UPDATE ".$db_content_table."
					SET edition_date = '".time()."',
							last_visit = '".time()."',
							allowed_groups = 'all',
							allowed_users = 'all',
							url = '".$db->sql_escape(sanitize($url))."',
							content = '".$db->sql_escape(sanitize($content))."',
							postmeta = ''
					WHERE
					url ='".$db->sql_escape(sanitize($url))."'
					LIMIT 1";

		}else{
			echo ("Error in ContentFunctions.php: Requested to write content without specifying either the Url or the Contents");
		}
	}else{
		echo ("content didnt exist, creating");
		$sql = "INSERT INTO ".$db_content_table." (creation_date, edition_date, last_visit, creator_id, allowed_groups, allowed_users, url, content, postmeta)
				VALUES ('".time()."',
						 '".time()."',
						 '".time()."',
						 '".$loggedInUser->user_id."',
						 'all',
						 'all',
						 '".$db->sql_escape(sanitize($url))."',
						 '".$db->sql_escape(sanitize($content))."',
						 'none')";
	}
	return ($db->sql_query($sql));
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
 // echo writeUrlContent("tesstHtml",'{name:"hola", try:"baby", html:"\<h1>&lt;tes&gt;</h1>"}');
?>
