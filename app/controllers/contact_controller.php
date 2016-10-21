<?php
class ContactController extends AppController {

    var $name = 'Contact';
    var $uses = array('ContactForm');
    var $helpers = array('Html', 'Form', 'Text', 'Time');
    var $components = array('RequestHandler', 'SwiftMailer');

    function contact_form() {

        $menuButtons = array(
            'home' => '',
            'about' => '',
            'register' => '',
            'contact' => '-down'
        );

        $this->set( 'menuButtons', $menuButtons);

        if (!empty($this->data) && $this->RequestHandler->isPost() ) {
            //$this->layout = 'ajax';

            App::import('Sanitize');
            $this->data = Sanitize::clean($this->data, array('encode' => false));

            $this->ContactForm->set( $this->data );

            if ($this->ContactForm->validates()) {
                $lines = array();

                foreach( $this->data['ContactForm'] as $key => $value) {
                    array_push($lines, Inflector::humanize($key) . ' : ' . $value );
                }
             
                $this->mail(  Configure::read('website.name') . ' contact form', $lines);

                $this->Session->setFlash('Thank You. Your comment has been sent.', false);
                $this->redirect($this->referer(), null, true);

            }else{
                // error
            }

        }
    }

    /*
     * sends error report e-mail
     */
    function mail( $title, $data) {
        $this->SwiftMailer->smtpType = 'tls';
        $this->SwiftMailer->smtpHost = 'smtp.gmail.com';
        $this->SwiftMailer->smtpPort = 465;
        $this->SwiftMailer->smtpUsername = Configure::read('smtp.username');
        $this->SwiftMailer->smtpPassword = Configure::read('smtp.password');

        $this->SwiftMailer->sendAs = 'text';
        $this->SwiftMailer->from = Configure::read('smtp.username');
        $this->SwiftMailer->fromName = $title;
        $this->SwiftMailer->to = Configure::read('smtp.username');
        //set variables to template as usual

        $this->set('title', $title);

        $comment = '';
        foreach( $data as $line )
            $comment = $comment . "{$line}\n";

        $this->set('comment', $comment);

        try {
            if(!$this->SwiftMailer->send('visitor_comment', $title)) {
                $this->log("Error sending email");
            }
        }
        catch(Exception $e) {
              $this->log("Failed to send email: ".$e->getMessage());
        }
        //$this->redirect($this->referer(), null, true);
    }

}
?>