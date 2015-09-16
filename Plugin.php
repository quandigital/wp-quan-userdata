<?php

namespace QuanDigital\UserData;

use QuanDigital\WpLib\Boilerplate;

class Plugin extends Boilerplate
{
    public function __construct($file)
    {
        $profile = $this->profilePage();
        parent::__construct($file, [$profile, 'addRewriteRules']);

    }

    private function profilePage()
    {
        new ProfilePage();
    }
}