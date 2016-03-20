
<script src="assets/js/dropzone.js"></script>
<!-- Change /upload-target to your upload address -->
<form action="editor/uploader.php" class="dropzone" method="GET">
  <input type="hidden" name="subdir" value="<?php echo str_replace(" ","-", $loggedInUser->display_username); ?>"></input>
  <p>Name your page:</p>
  <input type="text" name="pagename" value="<?php echo date('Ymd'); ?>"></input>

  <!-- <span class="up">+</span> -->
</form>
<!--Dropzone source: http://www.dropzonejs.com/ -->
