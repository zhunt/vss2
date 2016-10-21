<p>
    Recommendations should be generally positive to be
    published on the site.
</p>
<p>
    <em>Please Note: recommendations are not sent to <?php echo $venueName ?>.<br/>
        Please contact
        them directly using the phone or web address provided.</em>
</p>
<div class="comments form" id="comment_form">
    <?php echo $form->create('Comment', array('action' => 'add') );?>
    <?php
        echo $form->input('Comment.venue_id', array('type' => 'hidden', 'value' => $venueId) );
        echo $form->input('Comment.author', array('label' => 'Your Name:' ) );
        echo $form->input('Comment.author_email', array('label' => 'E-mail:' ));
        ?>
        <span class="hint black-text">Your email address will not be published.</span>
        <?php
        echo $form->input('Comment.author_url', array('label' => 'Your Website:' ));
        ?>
        <span class="hint black-text">(Website is optional)</span>
        <?php
        echo $form->input('Comment.comment', array('label' => 'Your Recommendation:' ));
        echo $form->input('Comment.demambo1', array('value' => Configure::read('demambo1'), 'style' => 'display: none', 'label' => false ) );
        echo $form->input('Comment.demambo2', array('value' => Configure::read('demambo2'), 'style' => 'display: none', 'label' => false ) );
    ?>
    <?php //echo $form->end('Submit', array('id' => 'submit_button') );?>
        <div id="comment_messages">&nbsp;</div>
        <div class="submit">
            <input type="submit" value="Submit" id="CommentAddFormBtn" >
        </div>
</form>
</div>

<script type="text/javascript">

	$("#CommentAddForm").validate({
	  debug: false,
	  rules: {
		"data[Comment][author]": {
			required: true,
			minlength: 3,
			maxlength: 30
		},
		"data[Comment][author_email]": {
			required: true,
			email: true,
			maxlength: 50
		},
		"data[Comment][author_url]": {
			required: false,
			minlength: 3,
			maxlength: 50
		},
		"data[Comment][comment]": {
			required: true,
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
                                        $("#comment-dialog").dialog('close');
                                    })
                                })

                            }
                    });
            }


	})
        

</script>