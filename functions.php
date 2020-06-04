<?php 

add_action( 'wp_enqueue_scripts', 'salient_child_enqueue_styles', 100);

function salient_child_enqueue_styles() {
		
		$nectar_theme_version = nectar_get_theme_version();
		wp_enqueue_style( 'salient-child-style', get_stylesheet_directory_uri() . '/style.css', '', $nectar_theme_version );
		
    if ( is_rtl() ) {
   		wp_enqueue_style(  'salient-rtl',  get_template_directory_uri(). '/rtl.css', array(), '1', 'screen' );
		}
}



// ----------------Selfinserted php----------------

// Modify the comment section
function wpb_alter_comment_form_fields($fields) {     
    // This line removes the website URL from comment form.       
    $fields['url'] = '';

    // Removing the url part of the comments
    unset($fields['url']);
     
    return $fields;
    }
add_filter('comment_form_default_fields', 'wpb_alter_comment_form_fields');

// // Hide the wordpress toolbar for all non-admin users
// add_action('after_setup_theme', 'remove_admin_bar');
 
// function remove_admin_bar() {
//     if (!current_user_can('administrator') && !is_admin()) {
//         show_admin_bar(false);
//     }
// }

// Redirect the user if user is logged in as a customer and not the specific customer page
add_action('wp', 'add_login_check');
function add_login_check() {
    if (current_user_can('q8visitor') && !in_category(['Q8', 'Public'])) {
        wp_redirect('https://banners.thomasdsiemsen.com/q8/');
        exit;
    }
    if (current_user_can('starkvisitor') && !in_category(['Stark', 'Public'])) {
        wp_redirect('https://banners.thomasdsiemsen.com/q8/');
        exit;
    }
    if (current_user_can('apotekvisitor') && !in_category(['Apotek', 'Public'])) {
        wp_redirect('https://banners.thomasdsiemsen.com/q8/');
        exit;
    }
}

// Logout without a confimation page
function getLogoutUrl($redirectUrl = ''){
    if(!$redirectUrl) $redirectUrl = site_url();
    $return = str_replace("&amp;", '&', wp_logout_url($redirectUrl));
    return $return;
}

function logout_without_confirmation($action, $result){
    if(!$result && ($action == 'log-out')){ 
        wp_safe_redirect(getLogoutUrl()); 
        exit(); 
    }
}
add_action( 'check_admin_referer', 'logout_without_confirmation', 1, 2);

?>