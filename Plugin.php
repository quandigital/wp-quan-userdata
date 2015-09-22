<?php

namespace QuanDigital\UserData;

use QuanDigital\WpLib\Boilerplate;

class Plugin extends Boilerplate
{
    public function __construct($file)
    {
        $profile = $this->profilePage();
        parent::__construct($file, [$profile, 'addRewriteRules']);
        $this->translations();
    }

    private function profilePage()
    {
        new ProfilePage();
    }

    private function translations()
    {
        add_action( 'plugins_loaded', function() {
            load_plugin_textdomain('quandigital-userdata', false, WP_LANG_DIR . '/plugins'); 
        });
    }
}
