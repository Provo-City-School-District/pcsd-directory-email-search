<?php
/**
 * Plugin Name: PCSD Directory Email Search
 * Description: A plugin to search for emails in our postmeta where our website directory information is stored.
 * Version: 1.0
 * Author: Josh Espinoza
 */

// Add a new page to the WordPress admin dashboard.
add_action('admin_menu', 'email_search_plugin_menu');

function email_search_plugin_menu() {
    add_menu_page('Directory Email Search Plugin Page', 'Dir Email Search', 'manage_options', 'email-search-plugin', 'email_search_plugin_page', 'https://globalassets.provo.edu/image/icons/pcsd-icon-16x16.png', 6);
}

// The function that outputs the HTML for the admin page.
function email_search_plugin_page() {
    echo '<h1>Directory Email Search</h1>';
    echo '<form method="post" action="">';
    echo '<p><label for="email">Email: </label><input type="text" name="email" id="email"></p>';
    echo '<p><input type="submit" value="Search"></p>';
    echo '</form>';

    if (isset($_POST['email'])) {
        global $wpdb;
        $email = sanitize_text_field($_POST['email']);
        
        //Query search
        $results = $wpdb->get_results("SELECT post_id, meta_key, meta_value FROM {$wpdb->prefix}postmeta WHERE meta_key = 'email' AND meta_value LIKE '%$email%'", ARRAY_A);
        //display results
        echo '<ul>';
        foreach ($results as $result) {
            echo $result['meta_value'] . ' found in post <a href="https://provo.edu/wp-admin/post.php?post='.$result['post_id'] .'&action=edit&classic-editor">' . $result['post_id'] . '<a/>';
        }
        echo '</ul>';

        //display message if no results found
        if (empty($results)) {
            echo '<p>No results found.</p>';
        }
    }

}
?>