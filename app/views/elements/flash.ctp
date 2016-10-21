<?php if($session->check('Message.flash')): ?>
     <?php $class = isset($error) ? 'contentError' : 'contentSuccess'; ?>
		 <div id="flashMessage" class="<?php echo $class; ?>">
			 <?php $session->flash(); ?>
		 </div>         
<?php endif; ?>