<?php
class UsersController extends AppController {

    var $name = 'Users';

    function beforeFilter(){
        parent::beforeFilter();

        $this->Auth->login = array('controller' => 'venues', 'action' => 'admin_index');
        $this->Auth->logout = array('controller' => 'landings', 'action' => 'home');
        
        $this->Auth->fields = array('username' => 'email', 'password' => 'password');
        $this->Auth->userScope = array('User.flag_active' => true);
        $this->Auth->autoRedirect = false;

        $this->Auth->allow('register');

    }

    function login() {
       
        if ($this->Auth->user()) {
           
            $this->User->id = $this->Auth->user('id');
            $this->User->saveField('last_login', date('c') );
            $this->Session->setFlash('Login Successfull');
            $this->redirect($this->Auth->redirect());
        }
    }

    function admin_login() {
        $this->redirect( array('action' => 'login', 'admin' => false) );
    }


    function logout() {
        $this->redirect($this->Auth->logout());
    }

    function register() {
        if(!empty($this->data)) {
            $this->User->create();
            //$assigned_password = "password";
            //$this->data['User']['password'] = $assigned_password;
            if($this->User->save($this->data)) {
                // send signup email containing password to the user
                //$this->Auth->login($this->data);
                $this->Session->setFlash('Account Created');
                $this->redirect($this->Auth->login());
            }
        }
    }


}
?>