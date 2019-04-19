<?php
/**
 * wp-gatsby-theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package wp-gatsby-theme
 */

add_theme_support('title-tag');
add_theme_support('post-thumbnails');
add_theme_support('html5', array(
    'search-form',
    'comment-form',
    'comment-list',
    'gallery',
    'caption',
));

add_action('publish_post', 'post_published_notification', 10, 2);
function post_published_notification($ID, $post)
{
    wp_remote_post('https://api.netlify.com/build_hooks/5c3c61c7ccd232cd98299079');
}
// Fonction pour modifier l'adresse email de l'expéditeur
add_filter('wp_mail_from', 'wpm_email_from');
function wpm_email_from($original_email_address)
{
    $domain_name = substr(strrchr($original_email_address, "@"), 1);
    return 'no-reply@' . $domain_name;
}
// Fonction pour changer le nom de l'expéditeur de l'email
add_filter('wp_mail_from_name', 'wpm_expediteur');
function wpm_expediteur($original_email_from)
{
    return 'API Portfolio';
}

require get_template_directory() . '/custom/types.php';
require get_template_directory() . '/custom/fields.php';
require get_template_directory() . '/custom/api.php';
