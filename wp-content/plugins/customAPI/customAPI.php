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

    register_rest_route('katana/', 'posts', array(
        'methods' => 'POST',
        'callback' => 'create_posts_info'
    ));
}

function get_posts_info( $request ){
    
    $parameters = $request->get_params();
    $title = $parameters['title'];


    $args = [
        'numberposts' => -1,
        'post_type' => 'post',
        'orderby' => 'date',
        'order' => 'DESC'
    ];

    get_post_field('post_title', 1);

    $posts = get_posts($args);
    

    $data = [];
    $i = 0;

    if( empty( $parameters )) {
        foreach($posts as $post) {
            $data[$i] = populateResult( $post );
            $i++;
        }
    } else {
        foreach($posts as $post) {
            if( $title == $post->post_title ) {
                $data[$i] = populateResult( $post );
                $i++;
            }
        }
    }

    return $data;
}

function populateResult( $post ) {
    $data['id'] = $post->ID;
    $data['title'] = $post->post_title;
    $data['author'] = $post->post_author;
    $data['date'] = $post->post_date;
    $data['content'] = $post->post_content;
    $data['link'] = $post->guid;
    $data['slug'] = $post->post_name;
    $data['featured_image']['thumbnail'] = get_the_post_thumbnail_url( $post->ID, 'thumbnail' );
    $data['featured_image']['medium'] = get_the_post_thumbnail_url( $post->ID, 'medium' );
    $data['featured_image']['large'] = get_the_post_thumbnail_url( $post->ID, 'large' );

    $meta = [
        "katana_post_token" => get_post_meta( $post->ID, 'katana_post_token', true ),
        "katana_referrer_url" => get_post_meta( $post->ID, 'katana_referrer_url', true )
    ];

    $data['meta'] = $meta;

    return $data;
}


function create_posts_info( $request ){
    $parameters = sanitize_post( $request->get_params(), 'db' );
    $post_id = wp_insert_post( $parameters, true );


    if ( is_wp_error( $post_id ) ) {

        if ( 'db_insert_error' === $post_id->get_error_code() ) {
            $post_id->add_data( array( 'status' => 500 ) );
        } else {
            $post_id->add_data( array( 'status' => 400 ) );
        }
    }

    update_post_meta( $post_id, 'katana_post_token', 'insert_post_token' );
    update_post_meta( $post_id, 'katana_referrer_url', 'insert_referrer_url' );

    return $post_id;
}