<?php

	/*
		UserCake Version: 1.0
		http://usercake.com


	*/
require_once("absolutedir.php");
?>
<div class="navbar navbar-fixed-top">
  <ul class="nav">
    <?php if(isUserLoggedIn()) { ?>
      <li><a href="<?php echo $websiteUrl ?>">Account Home</a></li>
      <li><a href="change-password.php">Change password</a></li>
      <li><a href="update-email-address.php">Update email address</a></li>
      <li><a href="logout.php"> Logout</a></li>
      <?php } else { ?>

        <?php } ?>
  </ul>
  <a id="logo" href="<?php echo $websiteUrl ?>">
    <img style="width:180px; display:inline" src="assets/img/dadahead_small.png"></img>
  </a>
</div>
