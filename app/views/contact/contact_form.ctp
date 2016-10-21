<?php $this->set('title', 'Contact ' . Configure::read('website.name') ); ?>
<style type="text/css">
/* From cake.generic.css */

/* Forms */




 .error, .error-message { color: #BF4D13; } 
 
 #flashMessage { color: #808CA3; font-size:1.4em; text-align:center; font-weight: bold; }
 
form#contact_form  {
	clear: both;
	margin-right: 20px;
	padding: 0;
	width: 80%;
}
 fieldset {
	border: 1px solid #ccc;
	margin-top: 30px;
	padding: 16px 20px;
}
 fieldset legend {
	background:#fff;
	color: #86A6D3;
	font-size: 160%;
	font-weight: bold;
}
 fieldset fieldset {
	margin-top: 0px;
	margin-bottom: 20px;
	padding: 16px 10px;
}
 fieldset fieldset legend {
	font-size: 1.2em%;
	font-weight: normal;
}
 fieldset fieldset div {
	clear: left;
	margin: 0 20px;
}
 form div {
	clear: both;
	margin-bottom: 1em;
	padding: .5em;
	vertical-align: text-top;
}
 form div.input {
	color: #444;
}
 form div.required {
	color: #333;
	font-weight: bold;
}
 form div.submit {
	border: 0;
	clear: both;
	margin-top: 10px;
	margin-left: 140px;
}
 label {
	display: block;
	font-size: 1em;
	padding-right: 20px;
}
#contact_form  input, textarea {
	clear: both;
	font-size: 1em;
	font-family: "frutiger linotype", "lucida grande", "verdana", sans-serif;
	padding: 2px;
	width: 100%;
}
 select {
	clear: both;
	font-size:  1em;
	vertical-align: text-bottom;
}
 select[multiple=multiple] {
	width: 100%;
}
option {
	font-size: 120%;
	padding: 0 3px;
}
 input[type=checkbox] {
	clear: left;
	float: left;
	margin: 0px 6px 7px 2px;
	width: auto;
}
 input[type=radio] {
	float:left;
	width:auto;
	margin: 0 3px 7px 0;
}
 div.radio label {
	margin: 0 0 6px 20px;
}
 input[type=submit] {
	display: inline;
	font-size:  1em;
	padding: 2px 5px;
	width: auto;
	vertical-align: bottom;
}

</style>

<div class="grid_9">
	<h1>Contact <?php echo Configure::read('website.name') ?></h1>

	<p><strong>Listing your venue is free!</strong><br/>
	If you'd like your venue (restaurant, bar, cafe or cater) added to SimcoeDining.com, please include the following information: Hours of operation, address, phone number, website (if you have one) and a brief description (300 words or less).</p>
	
	<fieldset style="width: 300px">
	<legend>Contact Form</legend>
	<?php echo $form->create('ContactForm', array('url' => '/contact/contact_form/', 'style' => 'width: 300px', 'id' => 'contact_form' ) ); ?>
	
	<?php echo $form->input('ContactForm.name', array('label' => 'Your name') ); ?>
	
	<?php echo $form->input('ContactForm.email', array('label' => 'Contact e-mail') ); ?>
	
	<?php echo $form->input('ContactForm.comment', array('label' => 'Comment') ); ?>
	
	<?php echo $form->end('Send Comment'); ?>
	
	</fieldset>
</div>
<div class="grid_3">
</div>
