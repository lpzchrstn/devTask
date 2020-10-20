<?php
/**
 * Template Name: projTemplate
 */

get_header();
?>
    <div class="main_posts">
        <div class="latest-posts">



	<?php
	/*if ( have_posts() ) {

		while ( have_posts() ) {
			the_post();

			get_template_part( 'template-parts/content-single' );
		}
    }*/
    ?>
    </div>
    </div>

    <div class="divTable">
        <?php for( $a = 0; $a <= 2; $a++ ) : ?>
            <div class="divrow">

                <?php for( $b = 0; $b <= 2; $b++ ) : ?>
                <div class="divcol"></div>
                <?php endfor; ?>
            
            </div>  
        <?php endfor; ?>
    </div>

    <!--<script>
        const url = 'http://localhost/proj/wp-json/katana/posts';
        const postsContainer = document.querySelector( '.latest-posts' );

        fetch( url )
        .then( response => response.json() )
        .then( data => {
            data.map( post => {
                const innerContent = 
                `
                <li>
                    <h2>${post.title}</h2>
                    ${post.content}
                    <a href="${post.link}">Read More</a>
                </li>
                `
                postsContainer.innerHTML += innerContent;
            }) 
        });
    </script>-->

    <?php 

get_footer(); 
