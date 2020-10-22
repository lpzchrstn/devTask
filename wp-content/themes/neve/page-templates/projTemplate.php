<?php
/**
 * Template Name: projTemplate
 */

get_header();
?>
    <!--<div id="app">
        <ol v-for="message in messages ">
            <li>{{ message.test }}</li>
        </ol>
        <h1>{{ title }}</h1>
    </div>-->

    <div class="main_posts">

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
                <?php for( $b = 0; $b <= 8; $b++ ) : ?>
                <div class="divcol">
                    <img src="../wp-content/themes/neve/assets/img/placeholder.png" draggable="false">
                </div>
                <?php endfor; ?>
            </div>
        </div>
    <?php 

get_footer(); 
