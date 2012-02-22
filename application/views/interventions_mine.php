<?php 
define('PAGE_TITLE', 'My interventions');
include(APP_DIR.'views/design/header.php');
?>
<h1>My interventions</h1>
<table>
	<tr>
		<th style="width:25%">Subject</th>
		<th>Campus</th>
		<th>Begin</th>
		<th>End</th>
		<th>Status</th>
		<th>Global Event Mark</th>
	</tr>
	<?php
		
		if(!count($interventions))
			echo '<tr><td colspan="6" class="disabled">There is no intervention yet.</td></tr>'; 
		else
		{
			foreach($interventions as $el)
			{
				?>
				<tr title="<?php echo $el->evaluations; ?> evaluation<?php echo $el->evaluations > 1 ? 's' : ''; ?>">
					<td><a href="interventions/view/<?php echo $el->id; ?>"><?php echo $el->subject; ?></a></td>
					<td><?php echo $el->campus->name; ?></td>
					<td><?php echo $el->start; ?></td>
					<td><?php echo $el->end; ?></td>
					<td><?php echo ucfirst($el->status); ?></td>
					<td><?php echo (float)$el->avg_mark; ?></td>
				</tr>
				<?php
			}
		}
	?>
</table>

<p>
	<a href="new">Add an intervention.</a>
</p>
<?php include(APP_DIR.'views/design/footer.php'); ?>
