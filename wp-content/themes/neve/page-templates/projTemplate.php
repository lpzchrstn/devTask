<?php
/**
 * Template Name: projTemplate
 */

get_header();
?>
    <div class="main_posts">
        <div class="latest-posts">
        <!-- Posts will be posted here from apiPostsFetch.js-->
    </div>

    <!-- div with 3 columns and rows -->
    <div class="divTable">
        <?php for( $a = 0; $a <= 2; $a++ ) : ?>
            <div class="divrow">

                <?php for( $b = 0; $b <= 2; $b++ ) : ?>
                <div class="divcol"></div>
                <?php endfor; ?>
            
            </div>  
        <?php endfor; ?>
    </div>

    <?php 

get_footer(); 
