<?php 
	Configure::write('debug',0);
	
	$output = $form->input('Venue.chain_id', array('output' => false, 'div' => false, 'label' => false, 'selected' => $id ) );
	
	// remove select tags leaving only options
	$output = preg_replace('/<select .*">/', '', $output);
	$output = str_replace('</select>', '', $output);

	$data['html'] = $output;
	
	echo json_encode($data);
?>