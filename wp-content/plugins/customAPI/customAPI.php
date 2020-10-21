<?php
/**
 * @package customAPI
 * @version 1.7.2
 */
/*
Plugin Name: customAPI
Description: for custom routes in API
Author: Christian Lopez
Version: 1.0
*/

add_action('rest_api_init', 'get_katana_posts');

// Register 'katana' as a route
function get_katana_posts(){
    register_rest_route('katana/', 'posts', array(
        'method' => 'GET',
        'callback' => 'get_posts_info'
    ));
}

function get_posts_info(){
    $args = [
        'numberposts' => -1,
        'post_type' => 'post'
    ];

    $posts = get_posts($args);

    $data = [];
    $i = 0;

    foreach($posts as $post) {
        $data[$i]['id'] = $post->ID;
        $data[$i]['title'] = $post->post_title;
        $data[$i]['author'] = $post->post_author;
        $data[$i]['date'] = $post->post_date;
        $data[$i]['content'] = $post->post_content;
        $data[$i]['link'] = $post->guid;
        $data[$i]['slug'] = $post->post_name;
        $data[$i]['featured_image']['thumbnail'] = get_the_post_thumbnail_url($post->ID, 'thumbnail');
        $data[$i]['featured_image']['medium'] = get_the_post_thumbnail_url($post->ID, 'medium');
        $data[$i]['featured_image']['large'] = get_the_post_thumbnail_url($post->ID, 'large');
        $i++;
    }

    return $data;
}