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
            }
            $i++;
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
    $data['featured_image']['thumbnail'] = get_the_post_thumbnail_url($post->ID, 'thumbnail');
    $data['featured_image']['medium'] = get_the_post_thumbnail_url($post->ID, 'medium');
    $data['featured_image']['large'] = get_the_post_thumbnail_url($post->ID, 'large');

    return $data;
}


function create_posts_info( $request ){
    /*if ( ! empty( $request['id'] ) ) {
        return new WP_Error( 'rest_post_exists', __( 'Cannot create existing post.' ), array( 'status' => 400 ) );
    }

    $post = $this->prepare_item_for_database( $request );
    if ( is_wp_error( $post ) ) {
        return $post;
    }

    $post->post_type = $this->post_type;
    $post_id = wp_insert_post( $post, true );

    if ( is_wp_error( $post_id ) ) {

        if ( 'db_insert_error' === $post_id->get_error_code() ) {
            $post_id->add_data( array( 'status' => 500 ) );
        } else {
            $post_id->add_data( array( 'status' => 400 ) );
        }
        return $post_id;
    }
    $post->ID = $post_id;

    $schema = $this->get_item_schema();

    if ( ! empty( $schema['properties']['sticky'] ) ) {
        if ( ! empty( $request['sticky'] ) ) {
            stick_post( $post_id );
        } else {
            unstick_post( $post_id );
        }
    }

    if ( ! empty( $schema['properties']['featured_media'] ) && isset( $request['featured_media'] ) ) {
        $this->handle_featured_media( $request['featured_media'], $post->ID );
    }

    if ( ! empty( $schema['properties']['format'] ) && ! empty( $request['format'] ) ) {
        set_post_format( $post, $request['format'] );
    }

    if ( ! empty( $schema['properties']['template'] ) && isset( $request['template'] ) ) {
        $this->handle_template( $request['template'], $post->ID );
    }
    $terms_update = $this->handle_terms( $post->ID, $request );
    if ( is_wp_error( $terms_update ) ) {
        return $terms_update;
    }

    $post = $this->get_post( $post_id );
    if ( ! empty( $schema['properties']['meta'] ) && isset( $request['meta'] ) ) {
        $meta_update = $this->meta->update_value( $request['meta'], (int) $request['id'] );
        if ( is_wp_error( $meta_update ) ) {
            return $meta_update;
        }
    }

    $fields_update = $this->update_additional_fields_for_object( $post, $request );
    if ( is_wp_error( $fields_update ) ) {
        return $fields_update;
    }

    do_action( "rest_insert_{$this->post_type}", $post, $request, true );

    $request->set_param( 'context', 'edit' );
    $response = $this->prepare_item_for_response( $post, $request );
    $response = rest_ensure_response( $response );
    $response->set_status( 201 );
    $response->header( 'Location', rest_url( sprintf( '%s/%s/%d', $this->namespace, $this->rest_base, $post_id ) ) );

    return $response;
    */
}