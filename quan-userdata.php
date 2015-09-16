<?php

namespace QuanDigital\UserData;

use QuanDigital\WpLib\Autoload;

/**
 * Plugin Name: Quan User Data
 * Plugin URI: https://github.com/quandigital/wp-quan-userdata
 * Author: Quan Digital GmbH
 * Author URI: http://www.quandigital.com/
 * Description: Adds custom user data with the help of acf
 * Version: 1.0.1
 * License: MIT
 */

new Autoload(__DIR__, __NAMESPACE__);

new Plugin(__FILE__);
