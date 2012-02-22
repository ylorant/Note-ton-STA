<?php 
define('PAGE_TITLE', 'Register');

$form->addNote('password', 'Password must be at least 5 characters long.');

include(APP_DIR.'views/design/header.php');
?>
<h1>Register</h1>
<p class="form-note">Note: All fields are required.</p>
<?php echo $form->generate('speaker/register'); ?>
<?php include(APP_DIR.'views/design/footer.php'); ?>
