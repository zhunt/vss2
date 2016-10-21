<!-- Displays published comments for this venue -->
<?php if ( empty($venue['Comment']) ): ?>
    <h3 class="comments">No Comments about <?php echo trim($venue['Venue']['name']) ?><br/>
            Be the first!</h3>
<?php else: ?>
    <h3 class="comments">What visitors are saying about <?php echo trim($venue['Venue']['full_name']) ?>:</h3>

    <?php foreach( $venue['Comment'] as $comment):?>
    <p>
        <strong><?php
        if ( empty($comment['author_url']) ):
                        echo $comment['author'];
        else:
                echo $this->Html->link( $comment['author'], $comment['author_url'], array('target' => 'blank', 'rel' => 'nofollow') );
        endif;
        ?></strong>
        said on <?php echo $this->Time->format( Configure::read('Time.format_short_no_year') , $comment['created']) ?>:
        <q><?php echo $this->Text->Truncate(nl2br(trim($comment['comment'])),400) ?></q>
    </p>

    <?php endforeach; ?>
<?php endif; ?>