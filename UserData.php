<?php

namespace QuanDigital\UserData;

/**
 * Just a bunch of getters to correctly display user meta data
 */
class UserData
{
    private $user;
    public $tweetImage;
    public $twitter;
    public $xing;
    public $linkedin;
    public $job;
    public $bio;
    private $resolution;
    public $profileLink;

    public function __construct($user)
    {
        $this->user = $user;
        $this->twitter = $this->getTwitter();
        $this->xing = $this->getXing();
        $this->linkedin = $this->getLinkedIn();
        $this->job = $this->getJob();
        $this->bio = $this->getBio();
        $this->profileLink = $this->getProfileLink();
        $this->tweetImage = $this->getUserImage(160,160);
        $this->resolution = isset($_COOKIE['resolution']) ? explode(',', $_COOKIE['resolution']) : [1920, 1];
    }

    function getUserImage($dimension)
    {
        if (class_exists('Aq_Resize')) {
            $image = \get_field('quan_userimage', 'user_' . $this->user->ID);
            if (!empty($image)) {
                $resized = \aq_resize($image['url'], $dimension, $dimension, true);
                return $resized ? $resized : $image['url'];
            }
        }
    }

    function getUserProfileImage()
    {
        $dimension = ($this->resolution[0] > 800) ? 800 * .5 * $this->resolution[1] : $this->resolution[0] * $this->resolution[1];
        return $this->getUserImage($dimension);
    }

    function getUserSidebarImage()
    {
        $dimension = $this->resolution[0] * $this->resolution[1] * .1;
        return $this->getUserImage($dimension);
    }

    function getTwitter()
    {
        return get_field('twitter', 'user_' . $this->user->ID);
    }

    function getXing()
    {
        return get_field('xing', 'user_' . $this->user->ID);
    }

    function getLinkedIn()
    {
        return get_field('linkedin', 'user_' . $this->user->ID);
    }

    function getJob()
    {
        return get_field('job', 'user_' . $this->user->ID);
    }

    function getBio()
    {
        return get_field('description', 'user_' . $this->user->ID);
    }

    function getProfileLink()
    {
        if (!empty($this->user->roles)) {
            foreach ($this->user->roles as $role) {
                if (in_array($role, ['author', 'editor'])) {
                    return \trailingslashit(\get_bloginfo('url')) . $this->user->data->user_nicename;
                }
            }
        }
    }
}