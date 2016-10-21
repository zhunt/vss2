An error has been reported for <?php echo $venue ?>:

<?php if (isset($errors) && !empty($errors) ): ?>
Errors:
	<?php foreach( $errors as $row):?>
		<?php echo $row . "\n"; ?>
	<?php endforeach; ?>
<?php endif; ?>

End.