<?php
/**
 * Template Name: projTemplate
 */

get_header();
?>
    <div id="app">
    
    </div>

    <div class="main_posts">
        <div class="addPost">
            <h3>Add post</h3>
            <input type="text" name="title" placeholder="Title" style="width: 400px;margin-bottom: 10px;"><br>
            <textarea name="content" placeholder="Content" rows="5" style="width: 100%;"></textarea><br>
            <input type="button" id="btnPost" name="btnPost" value="Add Post">
            <hr>
        </div>

        <div class="latest-posts">
        <!-- Posts will be posted here from apiPostsFetch.js-->
        </div>

        <!-- div with 3 columns and rows -->
        <div class="divTable">

            <?php for( $b = 0; $b <= 8; $b++ ) : ?>
            <div class="divcol">
                <img src="../wp-content/themes/neve/assets/img/placeholder.png" draggable="false">
            </div>
            <?php endfor; ?>
                  
        </div>

    <?php 

get_footer(); 
