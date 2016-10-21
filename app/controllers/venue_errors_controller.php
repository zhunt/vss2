<?php
class VenueErrorsController extends AppController {

    var $name = 'VenueErrors';
    var $uses = array('Venue');
    var $helpers = array('Html', 'Form', 'Text', 'Time');
    var $components = array('RequestHandler', 'SwiftMailer');

    function ajax_add() {
        App::import('Sanitize');

        $this->layout = 'ajax';
        if ( $this->RequestHandler->isAjax() ) {
            if (!empty($this->data)) {

                $this->data = Sanitize::clean($this->data, array('encode' => false));
                $venueId = (int)$this->data['VenueError']['venue_id'];

                $this->Venue->contain();
                $result = $this->Venue->findById($venueId);

                if ($result) {
                    $venueName = $result['Venue']['name'] . ' ' . $result['Venue']['subname'];

                    $lines = array();
                    foreach( $this->data['VenueError'] as $key => $value) {
                        array_push($lines, Inflector::humanize($key) . ' : ' . $value );
                    }

                    $this->mail( $venueName, $lines);
                }

            }
        }
    }

    /*
     * sends error report e-mail
     */
    function mail( $venueName, $data) {
        $this->SwiftMailer->smtpType = 'tls';
        $this->SwiftMailer->smtpHost = 'smtp.gmail.com';
        $this->SwiftMailer->smtpPort = 465;
        $this->SwiftMailer->smtpUsername = Configure::read('smtp.username');
        $this->SwiftMailer->smtpPassword = Configure::read('smtp.password');

        $this->SwiftMailer->sendAs = 'text';
        $this->SwiftMailer->from = Configure::read('smtp.username');
        $this->SwiftMailer->fromName = 'Venue Error Report';
        $this->SwiftMailer->to = Configure::read('smtp.username');
        //set variables to template as usual
        $this->set('message', 'My message');

        $this->set('venue', $venueName);
        $this->set('errors', $data );


        try {
            if(!$this->SwiftMailer->send('error_report', 'Error report sent for ' . $venueName)) { // error_report
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