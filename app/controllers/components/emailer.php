<?php
class EmailerComponent extends Object {

    var $components = array('SwiftMailer');

    function initialize(&$controller, $settings = array()) {
        // saving the controller reference for later use
        $this->controller =& $controller;
    }

    function commentSent( $venueId, $commentId, $commentType = null) {
        $venueId = Sanitize::paranoid($venueId);
        $commentId = Sanitize::paranoid($commentId);

        if( !$venueId)
            $this->log('commentSent: invalid venueId passed');

        if (!$commentId)
            $this->log('commentSent: invalid $commentId passed');

        if (!$venueId || !$commentId)
            return false;
        

        //$this->controller->_loadVccOptions();

        $venue = ClassRegistry::init('Venue')->findById($venueId);
        $venueName = $venue['Venue']['full_name'];

        $to = Configure::read('Vcc.support_email');
        $replyTo = Configure::read('Vcc.support_email');

        if ( $commentType == 'error_report') {
            $subject = 'Error report sent for ' . $venueName . ' from ' . Configure::read('Vcc.site_name');
        } else {
            $subject = 'Comment for ' . $venueName . ' from ' . Configure::read('Vcc.site_name');
        }

        $body = "
        A comment has been sent for {$venueName}

        Go to http://" . Configure::read('Vcc.site_url') . '/admin/comments/edit/' . $commentId . "

        To edit/approve this comment
        ";

        $this->_sendEmail($to, $replyTo, $subject, $body, 'venue_comment_form');
    }

    function sendContact( $name, $email, $comment, $metaData = null ) {
        $subject = 'Contact form message from ' . Configure::read('Vcc.site_name');

        $to =       Configure::read('Vcc.support_email');
        $replyTo =  Configure::read('Vcc.support_email');

        $body = "
            Contact form message:
            From: {$name} {$email}

            Message:
            {$comment}
        ";

        if ($metaData) {
            foreach( $metaData as $key => $value) {
                $body .= "\n" . $key . ': ' . $value;
            }

        }
            
        $this->_sendEmail($to, $replyTo, $subject, $body, 'contact_form');
    }

    function _sendEmail( $to, $replyTo, $subject, $body, $template) {
        $this->log( '_sendEmail: $to ' . $to );
        $this->log( '_sendEmail: $replyTo ' . $replyTo );
        $this->log( '_sendEmail: $subject ' . $subject );
        $this->log( '_sendEmail: $template ' . $template );

        $body = nl2br(trim($body));
        $this->SwiftMailer->smtpType = 'tls';

        $this->SwiftMailer->smtpHost = 'smtp.gmail.com';
        $this->SwiftMailer->smtpPort = 465;
        $this->SwiftMailer->smtpUsername = Configure::read('Vcc.support_email');
        $this->SwiftMailer->smtpPassword = Configure::read('Vcc.support_password');


        $this->SwiftMailer->sendAs = 'html';
        $this->SwiftMailer->from = $replyTo;
        $this->SwiftMailer->replyTo = $replyTo;
        $this->SwiftMailer->to = $to;
        //set variables to template as usual
        $this->controller->set('message', $body);

        try {
            if(!$this->SwiftMailer->send($template, $subject)) {
                $this->log('Error sending email (' . $subject . ') to ' . $to);
               
            }
        }
        catch(Exception $e) {
              $this->log("Failed to send email: ".$e->getMessage());
              return false;
        }

        return true;
    }
}
?>
