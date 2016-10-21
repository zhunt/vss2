<div class="clear">&nbsp;</div>
<div class="grid_9 comments">

<h1>Contact <?php echo Configure::read('Vcc.site_name')?></h1>

<p><strong>Listing your venue is free!</strong>
If you'd like your venue added to <?php echo Configure::read('Vcc.site_name')?>, please include the following information: hours of operation, address, phone number, website (if you have one) and a brief description (300 words or less).
</p>

	<div class="comments form">
	<?php echo $form->create('Contact', array('action' => 'add') );?>
		<fieldset>
			<?php
			echo $form->input('Contact.name', array('label' => 'Contact Name:', 'class' => 'wide' )); ?>
			<span class="hint black-text">(Name is optional)</span>
			<?php
			echo $form->input('Contact.email', array('label' => 'Contact E-mail:', 'class' => 'wide' )); ?>
			<span class="hint black-text">(Email is optional)</span>
			<?php
			echo $form->input('Contact.comment', array('label' => 'Comment:', 'class' => 'wide' ));
			echo $form->input('Contact.' . Configure::read('checkfield_1'), 
								array('value' => Configure::read('demambo1'), 'style' => 'display: none', 'label' => false ) );
			echo $form->input('Contact.' . Configure::read('checkfield_2'), 
								array('value' => Configure::read('demambo2'), 'style' => 'display: none', 'label' => false ) );
		?>
		
		<?php echo $form->end('Send Comment' );?>
		</fieldset>
	</div>
<p>
</p>
	<div class="clear">&nbsp;</div>
</div>

<?php echo $html->script( array(
				'http://ajax.microsoft.com/ajax/jquery.validate/1.7/jquery.validate.js'), array('inline' => false) )  ?>

<?php $this->Html->scriptBlock('
$(document).ready(function(){ 
	$("#ContactAddForm").validate({
	  debug: false,	
	  rules: {
		"data[Contact][name]": {
			required: true,
			minlength: 3,
			maxlength: 30
		},
		"data[Contact][author_email]": {
			required: true,
			email: true,
			maxlength: 50
		},
		"data[Contact][comment]": {
			required: true,
			minlength: 3,
			maxlength: 500
		}
	  }
	})
})
'
 , array('inline' => false ) ); ?>
