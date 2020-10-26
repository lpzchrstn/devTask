<?php
/**
 * Template Name: projTemplate
 */

add_action( 'wp_enqueue_scripts', function() {
    wp_enqueue_script('vue', 'https://cdn.jsdelivr.net/npm/vue@2.6.12/dist/vue.js', null, null, true); // change to vue.min.js for production
    wp_enqueue_script('main', get_template_directory_uri() . '/assets/js/vueMain.js', 'vue', null, true);
});

get_header();
?>

    <div class="main_posts">
        <div id="app">
            <?php get_template_part('page-templates/add-post'); ?>

            <?php get_template_part('page-templates/search-post'); ?>

            <?php get_template_part('page-templates/view-post'); ?>

            <?php get_template_part('page-templates/see-more'); ?>
        </div>

    <?php 

get_footer(); 
