<?php

    namespace Quan\UserData;

    /**
     * Plugin Name: Quan User Data
     * Plugin URI: http://www.quandigital.com/
     * Description: Adds custom user data without the need for the backend (with the help of acf)
     * Version: 1.0.0
     * License: MIT
     */


    defined( 'ABSPATH' ) or die();

    if (!class_exists('acf')) {
        add_action('admin_init', function() {
            deactivate_plugins( plugin_basename( __FILE__ ) );
            add_action('admin_notices', function() {
                echo '<div class="error"><p>Please activate <a href="https://wordpress.org/plugins/advanced-custom-fields/" target="_blank">Advanced Custom Fields</a> first.</p></div>';
            });
        });
    } else {
        \spl_autoload_register(function($class) {
            $class = ltrim($class, '\\');

            if(strpos($class, __NAMESPACE__) !== 0) {
                return;
            }

            $class = str_replace(__NAMESPACE__, '', $class);
            $path = __DIR__ . str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.class.php';

            require_once($path);
        });

        $profile = new \Quan\UserData\ProfilePage();
        \register_activation_hook( __FILE__, [$profile, 'addRewriteRule'] );
    }