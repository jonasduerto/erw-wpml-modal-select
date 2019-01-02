<?php
/**
 * Plugin Name: ERW Modal Lang Select
 * Description: ERW WPML Languaje Selector is a simple Modal for select languaje by cookie
 * Plugin URI: http://www.elreyweb.com/
 * Author: Team elreyweb
 * Author URI: http://www.elreyweb.com/
 * Version: 2.0.8
 * License: GPL2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: erwlangselect
 


 * Name is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 *
 * Name is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Name. If not, see https://www.gnu.org/licenses/gpl-2.0.html.
 */

defined( 'ABSPATH' ) or exit;

define('ERWSL_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('ERWSL_PLUGIN_URL' , plugin_dir_url(__FILE__));

define('ERW_LANG_SELECT_JS', ERWSL_PLUGIN_URL . 'assets/js/');
define('ERW_LANG_SELECT_CSS', ERWSL_PLUGIN_URL . 'assets/css/');

require_once ERWSL_PLUGIN_DIR . 'settings.php';
require_once ERWSL_PLUGIN_DIR . 'functions.php';


