<?php
//DADA editor index page
	/*
	Sources:
		UserPie Version: 1.0
		http://userpie.com
    sources:
    http://www.startutorial.com/articles/view/how-to-build-a-file-upload-form-using-dropzonejs-and-php#sthash.2qcR9DbY.dpuf
	*/
require_once("absolutedir.php");
require_once("models/config.php");
	if (!isset($loggedInUser)){
		header('Location: login.php');
		exit();
	}
$ds = '/';//DIRECTORY_SEPARATOR
$url=$_POST['subdir'].$ds.$_POST['pagename'];
$storeFolder = 'webcontents'.$ds.$url;
if (!file_exists($storeFolder)) {
    mkdir($storeFolder, 0777, true);
}
if (!empty($_FILES)) {
    $tempFile = $_FILES['file']['tmp_name'];
    $targetPath = $storeFolder;
    // $ext = end((explode(".",$_FILE['file']['name'])));
    $targetFile =  $targetPath.$ds."index.jpg";
    move_uploaded_file($tempFile,$targetFile);
		echo "file uploaded";
		writeUrlContent($url,'{"img":"'.$storeFolder.$ds.'index.jpg"}');
		echo "file stored";
}
?>
