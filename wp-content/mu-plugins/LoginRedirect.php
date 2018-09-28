<?php

namespace LoginRedirect;

class LoginRedirect
{
    public function __construct()
    {
        add_action('template_redirect', array($this, 'redirectToLoginPage'));
        add_filter('login_redirect', array($this, 'loginRedirect'), 10, 3);
        add_filter('allow_password_reset', '__return_false');
        add_filter('tml_get_form_links', array($this, 'formLinks'), 10, 3);
        add_action('set_current_user', array($this, 'hideAdminBar'));
    }

    public function redirectToLoginPage()
    {
        if (!is_page('login') && !is_user_logged_in()) {
            auth_redirect();
            exit();
        }
    }

    public function loginRedirect($url, $request, $user)
    {
        if ($user && is_object($user) && is_a($user, 'WP_User')) {
            if ($user->has_cap('administrator') or $user->has_cap('author')) {
                $url = admin_url();
            } else {
                $url = home_url();
            }
        }
        return $url;
    }

    public function formLinks($links)
    {
        return array();
    }

    public function hideAdminBar()
    {
        if (!current_user_can('edit_posts')) {
            add_filter('show_admin_bar', '__return_false');
        }
    }
}

new LoginRedirect();
