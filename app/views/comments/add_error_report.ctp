<p>
    Thank you for taking time to help make the site better.
</p>
<p>
    Please check the item(s) that you noticed where incorrect.
</p>
<div class="comments form" id="error_form">
    <?php echo $form->create('Comment', array('action' => 'add_error_report') );?>
    <?php
        echo $form->input('Comment.venue_id', array('type' => 'hidden', 'value' => $venueId) );

        echo $form->input('Comment.hours_wrong', array('label' => 'Hours', 'type' => 'checkbox', 'style' => 'width:20px'));
        echo $form->input('Comment.address_wrong', array('label' => 'Address / Phone Number', 'type' => 'checkbox', 'style' => 'width:20px'));
        echo $form->input('Comment.venue_closed', array('label' => 'Venue is Closed', 'type' => 'checkbox', 'style' => 'width:20px'));

        echo $form->input('Comment.comment', array('label' => 'Other:' ));
        echo $form->input('Comment.demambo1', array('value' => Configure::read('demambo1'), 'style' => 'display: none', 'label' => false ) );
        echo $form->input('Comment.demambo2', array('value' => Configure::read('demambo2'), 'style' => 'display: none', 'label' => false ) );
    ?>
        <div id="comment_messages">&nbsp;</div>
        <div class="submit">
            <input type="submit" value="Submit" id="CommentAddFormBtn" >
        </div>
</form>
</div>

<script type="text/javascript">

	$("#CommentAddErrorReportForm").validate({
	  debug: false,
	  rules: {
		"data[Comment][comment]": {
			required: false,
			minlength: 3,
			maxlength: 500
		}
	  },
          submitHandler: function(form) {
                    jQuery(form).ajaxSubmit({
                            dataType:  'json',
                            beforeSubmit: function() {
                                $('#CommentAddFormBtn').val('Sending...');
                                $('#CommentAddFormBtn').attr("disabled", true);
                            },
                            success: function(data) {
                                //console.log('message sent');
                                $('#comment_messages').html(data.msg).hide().fadeIn(1500, function() {
                                    $('#CommentAddFormBtn').val('Sent').fadeOut(3000, function() {
                                        $("#error-dialog").dialog('close');
                                    })
                                })

                            }
                    });
            }


	})
        

</script>