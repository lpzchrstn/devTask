<?php
/**
 * Template Name: projTemplate
 */

get_header();
?>


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
    
	if ( have_posts() ) {

		while ( have_posts() ) {
			the_post();

			get_template_part( 'template-parts/content-cover' );
		}
	}
    
    
get_footer(); 
