<?php

/**
 *  Theme settings
 */
include get_template_directory() . '/includes/theme.php';

function create_testimonials_post_type() {
    if (get_current_blog_id() == 4) {

        $labels = array(
            'name'               => _x('Testimonials', 'post type general name'),
            'singular_name'      => _x('Testimonial', 'post type singular name'),
            'add_new'            => _x('Add New', 'Testimonial'),
            'add_new_item'       => __('Add New Testimonial'),
            'edit_item'          => __('Edit Testimonial'),
            'new_item'           => __('New Testimonial'),
            'all_items'          => __('All Testimonials'),
            'view_item'          => __('View Testimonial'),
            'search_items'       => __('Search Testimonials'),
            'not_found'          => __('No Testimonials found'),
            'not_found_in_trash' => __('No Testimonials found in the Trash'),
            'parent_item_colon'  => '',
            'menu_name'          => 'Testimonials'
        );
        $args = array(
            'labels'        => $labels,
            'public'        => true,
            'menu_icon'     => 'dashicons-testimonial',
            'menu_position' => 5,
            'has_archive'   => true,
            'supports'      => array('title', 'editor', 'thumbnail', 'custom-fields'),
            'show_in_rest'  => true, 
        );
        register_post_type('testimonials', $args);
    }
}

add_action('init', 'create_testimonials_post_type');



function search_testimonials($search_query) {
    $api_url = home_url('/wp-json/wp/v2/testimonials'); 
    $args = array(
        'search' => $search_query,
    );
    $request_url = add_query_arg($args, $api_url);
    
    $response = wp_remote_get($request_url);

    if (is_wp_error($response)) {
        return false;
    }

    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);

    return $data;
}

function search_testimonials_handler() {
    $search_query = $_GET['search_query'];

    if (isset($_GET['sub_site_search']) && $_GET['sub_site_search']) {
        $sites = get_sites();
        $results = array();

        foreach ($sites as $site) {
            switch_to_blog($site->blog_id);
            $query_args = array(
                'post_type' => 'testimonials', 
                's' => $search_query,
            );

            $query = new WP_Query($query_args);

            if ($query->have_posts()) {
                while ($query->have_posts()) {
                    $query->the_post();
                    $results[] = array(
                        'title' => get_the_title(),
                        'permalink' => get_permalink(),
                    );
                }
            }

            restore_current_blog();
        }

        echo json_encode($results);
    } else {
        $query_args = array(
            'post_type' => 'testimonials', 
            's' => $search_query,
        );

        $query = new WP_Query($query_args);

        $results = array();

        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                $results[] = array(
                    'title' => get_the_title(),
                    'permalink' => get_permalink(),
                );
            }
        }

        echo json_encode($results);
    }
    wp_die();
}

add_action('wp_ajax_search_testimonials', 'search_testimonials_handler');
add_action('wp_ajax_nopriv_search_testimonials', 'search_testimonials_handler');
