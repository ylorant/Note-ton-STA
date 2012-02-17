<?php 
define('PAGE_TITLE', 'Register');
include(APP_DIR.'views/design/header.php');
?>
<h1>Register</h1>
<?php
echo $form->generate('register');
include(APP_DIR.'views/design/footer.php');
?>
