<?php
/*
Template Name: Clients
*/

get_header(); ?>

<?php
_s_get_template_part( 'template-parts/clients', 'hero' );
?>

<div id="primary" class="content-area">

    <main id="main" class="site-main" role="main">
    
        <?php
        _s_get_template_part( 'template-parts/clients', 'industries' );
                   
        _s_get_template_part( 'template-parts/clients', 'clients' );
                
        ?>

    </main>

</div>

<?php
get_footer();
