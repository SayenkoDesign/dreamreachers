<?php
/**
 * Template part for displaying single posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package _s
 */
?>

<section class="section-content">
    <div class="container">
    <div class="wrap">
        <div class="row">
            <article id="post-<?php the_ID(); ?>" <?php post_class( 'column small-12 large-7' ); ?>>
                <header class="entry-header">
                    <?php
                    $project = new Single_Project( get_the_ID() );
                    $icon = $project->get_industry_icon();
                    if( ! empty( $icon ) ) {
                        printf( '<span class="icon">%s</span>', $icon );
                    }
                    
                    the_title( '<h1 class="entry-title">', '</h1>' ); 
                    ?>
                </header><!-- .entry-header -->
    
                <div class="entry-content">
                
                    <?php 
                    the_content(); 		
                    ?>
                    
                </div><!-- .entry-content -->
                        
            </article><!-- #post-## -->
            <div class="column small-12 large-4 sidebar">
                <?php
                $columns = '';
                $project = new Single_Project( get_the_ID() );
                $industry = $project->get_industry();
                $location = $project->get_location();
                $services = $project->get_services(); 
                if( $industry || $location ) {
                    $columns .= sprintf( '<div class="column column-block">%s%s</div>', $industry, $location );
                }
                
                if( $services ) {
                    $columns .= sprintf( '<div class="column column-block">%s</div>', $services );
                }
                
                printf( '<div class="row">%s</div><hr />', $columns );
                
                $logo = get_field( 'logo' );
                if( ! empty( $logo ) ) {
                    echo _s_get_acf_image( $logo, 'thumbnail' );
                }
                ?>
            </div>
        </div>
        
    </div>
    </div>
</section>