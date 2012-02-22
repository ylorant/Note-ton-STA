<?php 
define('PAGE_TITLE', 'New intervention');
include(APP_DIR.'views/design/header.php');
?>
<h1>New intervention</h1>
<?php echo $form->generate('intervention/create'); ?>
<script type="text/javascript">
	window.onload = function(){
		new JsDatePick({
			useMode:2,
			target:"begin",
			dateFormat:"%m/%d/%Y"
		});
		new JsDatePick({
			useMode:2,
			target:"end",
			dateFormat:"%m/%d/%Y"
		});
	};
</script>

<?php include(APP_DIR.'views/design/footer.php'); ?>
