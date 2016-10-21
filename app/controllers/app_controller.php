<?php
/**
 * Short description for file.
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.cake.libs.controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

/**
 * This is a placeholder class.
 * Create the same file in app/app_controller.php
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       cake
 * @subpackage    cake.cake.libs.controller
 */

App::import('Sanitize');

class AppController extends Controller {
    var $metaTags = array();
    var $components = array('RequestHandler', 'Session', 'Auth');

    function beforeFilter() { //debug('here 1');
        // load-up VSS options and put them into config
        $this->_loadVccOptions();
        //debug( Configure::read('Vcc.site_url')  );
        //debug( Configure::read('Vcc.support_email') );
        $this->Auth->deny('*');
        
    }

    function beforeRender()
    {
        parent::beforeRender();

        // change layout for admin section
        if (isset($this->params['prefix']) &&
                !$this->RequestHandler->isAjax() ) {
            $this->layout = 'admin_default';
        }

        // --- set up meta-tags  ---
        $this->_configureMeta();

        if ( !isset($this->viewVars['meta_description']) )
            $this->set('meta_description', $this->_metaDescription());

        // 1.3 oddity: can not set, only check if title set somewhere else
      //  if ( empty($this->pageTitle) )
       //    $this->set('title_for_layout', $this->_pageTitle() );
    }

    /*
     * Loads the VCC options into config data
     * This allows changing conig options without editing files
     * Options are cached so DB is not called ever time
     */
     function _loadVccOptions() {
       $vssOptions = Cache::read('vssOptions', 'long_cache');
       
        if ($vssOptions != null) {
            
            foreach( $vssOptions as $key => $value)
                Configure::write('Vcc.' . $key , $value);

            $this->log("loading options from cache", 'activity');

        } else {
            
            $data = ClassRegistry::init('VssOption')->find('list',
                            array('fields' => array('option_key', 'option_value') )
                        );
          
            Cache::write('vssOptions', $data, 'long_cache'); // save for long time
          //  debug('wrote ' . $data . ' to cache');
            foreach( $data as $key => $value)
                Configure::write('Vcc.' . $key , $value);

            $this->log("loading options from DB", 'activity');
        }
        
    }

    /*
     * loads up meta data for this page
     */
    private function _configureMeta()
    {
        $meta = ClassRegistry::init('VssPageMeta')->__findCurrentPage( array('url' => $this->here));
       
        $this->metaTags = $meta['VssPageMeta'];
        //$this->meta = $meta;
        
        //return $this->meta;
    }

    // Meta description
    private function _metaDescription()
    {
       return (!empty($this->metaTags['meta_description']) ? $this->metaTags['meta_description'] : NULL);
    }

    // Page title (<title>)
    private function _pageTitle()
    {
       return ($this->metaTags['page_title'] ? $this->metaTags['page_title'] : NULL);
    }
}
?>