<?php
/**
 * Short description for file.
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different urls to chosen controllers and their actions (functions).
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
 * @subpackage    cake.app.config
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/views/pages/home.ctp)...
 */
	Router::connect('/', array('controller' => 'landings', 'action' => 'home'));
/**
 * ...and connect the rest of 'Pages' controller's urls.
 */
	Router::connect('/pages/*', array('controller' => 'pages', 'action' => 'display'));

        Router::connect('/searches/autocomplete/*',
                array('controller' => 'searches', 'action' => 'autocomplete'));

        Router::connect('/searches/index/*',
                array('controller' => 'searches', 'action' => 'index'));

        Router::connect('/searches/*',
                array('controller' => 'searches', 'action' => 'index'));
				
		// next 2 lines for blog posts		
		Router::connect('/news_events',
                array('controller' => 'posts', 'action' => 'index'));	

		Router::connect('/news_events/:slug', array('controller' => 'posts', 'action' => 'view'),
                            array('slug' => '[A-Za-z0-9\-]{5,200}') );		

        
    // Landing pages- convert old paths to new (actual) paths
    Router::connect('/venues/internet-cafes-home/',
                    array('controller' => 'landings',
                            'action' => 'cafe_venues'
                             ));

    Router::connect('/venues/computer-dealers-home/',
                    array('controller' => 'landings',
                            'action' => 'computer_venues'
                             ));

        

        // sitemaps  
        Router::connect('/sitemap', array('controller' => 'sitemaps', 'action' => 'index'));
        Router::connect('/sitemap/:action/*', array('controller' => 'sitemaps'));
        // sitemaps- Optional
        Router::connect('/robots/:action/*', array('controller' => 'sitemaps', 'action' => 'robot'));

        Router::parseExtensions();

        Router::connect('/:slug', array('controller' => 'venues', 'action' => 'view'),
                            array('slug' => '[A-Za-z0-9\-]{3,100}') );
?>