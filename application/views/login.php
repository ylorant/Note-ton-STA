<?php 
define('PAGE_TITLE', 'Login');
include(APP_DIR.'views/design/header.php');
?>
<h1>Login</h1>
<?php

if(!empty($error))
	echo '<div class="error">Invalid identifiers</div>';

echo $form->generate('speaker/login');
include(APP_DIR.'views/design/footer.php');
?>
