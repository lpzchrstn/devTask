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
        <div id="site-wrapper">
            {{ message }}
        </div>

        <div class="addPost">
            <h3>Add post</h3>
            <input type="text" name="title" placeholder="Title" style="width: 400px;margin-bottom: 10px;"><br>
            <textarea name="content" placeholder="Content" rows="5" style="width: 100%;"></textarea><br>
            <input type="button" id="btnPost" name="btnPost" value="Add Post">
        </div>

        <div class="searchPost" style="margin: 50px 0px;">
            <h3>Search Post</h3>
            <input type="text" id="searchField" name="search" placeholder="Search..." style="width: 400px;margin-bottom: 10px;">
            <input type="button" value="Get Post" id="btnGetPost">
        </div>

        <div class="latest-posts">
            <ul class="postList">
            
            </ul>
        </div>

        <!-- div with 3 columns and rows -->
        <div class="divTable">
            <div class="innerTable">
                
            </div>
        </div>
        <h5 id="seemore">See More...</h5>
    <?php 

get_footer(); 
