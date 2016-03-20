<?php
//DADA editor index page
	/*
	Sources:
		UserPie Version: 1.0
		http://userpie.com


	*/
	require_once("../models/config.php");

	/*
	* Uncomment the "else" clause below if e.g. userpie is not at the root of your site.
	*/
	if (!isset($loggedInUser)){
		header('Location: login.php');
	// else
	// 	header('Location: /');
		exit();
	}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $websiteName; ?> Editor</title>
<?php require_once("../head_inc.php"); ?>


</head>
<body>
<?php require_once("../navbar.php"); ?>
	<div id="content">


<h1>Editor page</h1>
<h2>Create page</h2>
<?php include "module_upload.php" ?>
<h2>Edit page</h2>
<?php
if ($handle = opendir('../webcontents/'.str_replace(" ","-", $loggedInUser->display_username))) {

    while (false !== ($entry = readdir($handle))) {
        if ($entry != "." && $entry != "..") {
            echo "<li><a class=dir href=\"editor/postedit.php?post=$entry\">$entry</a>\n<br>";
        }
    }

    closedir($handle);
}
?>


	</div>



</body>
</html>
