<?php
    
namespace QuanDigital\UserData;

class ProfilePage
{
    private $user;
    public $data;

    public function __construct()
    {
        \add_action('wp', function() {
            if (\is_author()) {
                \add_filter('template_include',[$this, 'includeTemplate']);
                $this->user = new \WP_User(\get_the_author_meta('ID'));
            }
        });

        \add_action('init', [$this, 'addRewriteRulesFilter']);
        \add_action('set_user_role', [$this, 'removeUserRewriteRule'], 10, 3);
        \add_action('user_register', [$this, 'addRewriteRules']);
    }

    /**
     * include the template from this plugin and not from the theme
     * @return string template path
     */
    function includeTemplate()
    {
        $new_template = __DIR__ . '/user-profile.php';
        if ( '' != $new_template ) {
            return $new_template ;
        }
    }

    /**
     * trigger the rewriting of rules, flush present rules
     */
    function addRewriteRules()
    {
        $this->addRewriteRulesFilter();
        \flush_rewrite_rules();
    }

    /**
     * add a rewrite rules for every author/editor on the page to get rid of the /author slug
     * WP filter
     * @return array new rewrite rules
     */
    function addRewriteRulesFilter()
    {
        add_filter('author_rewrite_rules', function ($author_rewrite_rules)
        {
            $author_rewrite_rules = [];
            $authors = get_users(['role' => 'author']);
            $editors = get_users(['role' => 'editor']);
            $authors = array_merge($authors, $editors);
            foreach ($authors as $author) {
                $author_rewrite_rules["({$author->data->user_nicename})/page/?([0-9]+)/?$"] = 'index.php?author_name=$matches[1]&paged=$matches[2]';
                $author_rewrite_rules["({$author->data->user_nicename})/?$"] = 'index.php?author_name=$matches[1]';
            }  
            return $author_rewrite_rules;
        });
    }

    /**
     * If a user is either added or removed as author/editor flush and rewrite the rewrite rules
     * @param  int $userId   wp user id
     * @param  string $newRole  new role name
     * @param  array $oldRoles previous user roles
     * @return void
     */
    function removeUserRewriteRule($userId, $newRole, $oldRoles) 
    {   
        if (in_array($newRole, ['author', 'editor']) || !empty(array_intersect($oldRoles, ['author', 'editor']))) {
            $this->addRewriteRulesFilter($userId);
        }
    }

}
