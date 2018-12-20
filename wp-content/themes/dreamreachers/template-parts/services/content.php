<?php
/**
 * Service - Content
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package _s
 */
?>
<div class="section-content">
    <div class="inner">
    <div class="container">
    <div class="wrap">
        <div class="column row">
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="entry-header">
                    <?php
                    $page_icon = get_field( 'page_icon' );
                    if( ! empty( $page_icon ) ) {
                        printf( '<span class="icon">%s</span>', _s_get_acf_image( $page_icon, 'thumbnail' ) );
                    }
                    ?>
                    <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
                </header><!-- .entry-header -->
                <div class="entry-content">
                    <?php 
                    the_content(); 
                    
                    $brochure = get_field( 'brochure' );
                    if( ! empty( $brochure ) ) {
                        $button_text = $brochure['button_text'];
                        $pdf = $brochure['pdf'];
                        if( ! empty( $button_text ) && ! empty( $pdf ) ) {
                            printf( '<p class="download-brochure""><a href="%s" class="button">%s</a></p>',$pdf, $button_text );
                        }
                        
                    }
                    ?>
                    
                </div><!-- .entry-content -->
            </article><!-- #post-## -->
        </div>
    </div>
    </div>
    </div>
</div>