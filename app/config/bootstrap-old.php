<?php
/**
 * This file is loaded automatically by the app/webroot/index.php file after the core bootstrap.php
 *
 * This is an application wide file to load any function that is not used within a class
 * define. You can also use this to include or require any files in your application.
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
 * @since         CakePHP(tm) v 0.10.8.2117
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

/**
 * The settings below can be used to set additional paths to models, views and controllers.
 * This is related to Ticket #470 (https://trac.cakephp.org/ticket/470)
 *
 * App::build(array(
 *     'plugins' => array('/full/path/to/plugins/', '/next/full/path/to/plugins/'),
 *     'models' =>  array('/full/path/to/models/', '/next/full/path/to/models/'),
 *     'views' => array('/full/path/to/views/', '/next/full/path/to/views/'),
 *     'controllers' => array('/full/path/to/controllers/', '/next/full/path/to/controllers/'),
 *     'datasources' => array('/full/path/to/datasources/', '/next/full/path/to/datasources/'),
 *     'behaviors' => array('/full/path/to/behaviors/', '/next/full/path/to/behaviors/'),
 *     'components' => array('/full/path/to/components/', '/next/full/path/to/components/'),
 *     'helpers' => array('/full/path/to/helpers/', '/next/full/path/to/helpers/'),
 *     'vendors' => array('/full/path/to/vendors/', '/next/full/path/to/vendors/'),
 *     'shells' => array('/full/path/to/shells/', '/next/full/path/to/shells/'),
 *     'locales' => array('/full/path/to/locale/', '/next/full/path/to/locale/')
 * ));
 *
 */

/**
 * As of 1.3, additional rules for the inflector are added below
 *
 * Inflector::rules('singular', array('rules' => array(), 'irregular' => array(), 'uninflected' => array()));
 * Inflector::rules('plural', array('rules' => array(), 'irregular' => array(), 'uninflected' => array()));
 *
 */

Configure::write( 'Venue.published', 3);
define('VENUE_PUBLISHED', 3);
Configure::write( 'Comment.published', 2 );
define('COMMENT_PUBLISHED', 2);

Configure::write( 'ClientType.premium', 2);

//Configure::write( 'Search.num_results', 10); // number of search results to show

Configure::write('Time.format_short', 'jS M, Y'); // 10th Nov, 1952
Configure::write('Time.format_short_no_year', 'jS M'); // 10th Nov, 1952
Configure::write('Time.format_day_time', 'jS M, Y H:m');

// check-fields
Configure::write('checkfield_1','demambo1');
Configure::write('demambo1', '45' );
define('EMAIL_CHECK_DEMAMBO1', '45');
define('EMAIL_CHECKFIELD_1', 'demambo1');

Configure::write('checkfield_2','demambo2');
Configure::write('demambo2', '' );
define('EMAIL_CHECK_DEMAMBO2', '');
define('EMAIL_CHECKFIELD_2', 'demambo2');

// Configure::write('Google.ajax_key', 'ABQIAAAAoTmiAVjOtlkN3bzjMb7HiBRi_j0U6kJrkFvY4-OX2XYmEAa76BQXC-gH0m77rZjImOnHe6qfWeeY8Q');
// ABQIAAAAoTmiAVjOtlkN3bzjMb7HiBSxXSodDRK3zI0pH23koHkZBG57ohTGUscCma7RQEd9N2i9rqa5-vwsAQ - live

Configure::write('Disqus.key', 'DWQ8EChK0JlienUXkXTg3wOFDIyLw1vPOeNgdsPxVt6K4mVsMRVLI00ZTDkF68jW'); // public key
Configure::write('Disqus.forum', 'SimcoeDining');

Configure::write('Facebook.key', 'ab779e7ca966b0a5a85e07649c53f5ed');


if ( strpos( $_SERVER['HTTP_HOST'],'simcoedining.com') !== false)
    Configure::write('Google.ajax_key', 'ABQIAAAAoTmiAVjOtlkN3bzjMb7HiBQbR5wRczcW0lgwGkualHHkcf_hTRT8CEe-yXMsUlaXQi3Ddb55Fg_keg');
else
    Configure::write('Google.ajax_key', 'ABQIAAAAoTmiAVjOtlkN3bzjMb7HiBRi_j0U6kJrkFvY4-OX2XYmEAa76BQXC-gH0m77rZjImOnHe6qfWeeY8Q');

?>