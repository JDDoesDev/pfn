<?php

// =============================================================================
// VIEWS/INTEGRITY/WP-SINGLE.PHP
// -----------------------------------------------------------------------------
// Single post output for Integrity.
// =============================================================================

$fullwidth = get_post_meta( get_the_ID(), '_x_post_layout', true );

?>

<?php get_header(); ?>

<?php global $post; ?>

  <?php while ( have_posts() ) : the_post(); ?>
  <div class="featured-image" style="background-image:url(<?php the_post_thumbnail_url(full); ?>); ?>) !important;" data-x-element="section" data-x-params="{&quot;type&quot;:&quot;image&quot;,&quot;parallax&quot;:true}";">
   <div class="x-container max width offset">
    <div class="caption">
      <h1 class="title"><?php the_title(); ?></h1>
    </div>
   </div>
  </div>
  <?php endwhile; ?>

  <div class="x-container max width offset">
    <div class="<?php x_main_content_class(); ?>" role="main">

      <?php while ( have_posts() ) : the_post(); ?>
        <?php x_get_view( 'integrity', 'content', get_post_format() ); ?>
        <?php x_get_view( 'global', '_comments-template' ); ?>
      <?php endwhile; ?>

    </div>

    <?php if ( $fullwidth != 'on' ) : ?>
      <?php get_sidebar(); ?>
    <?php endif; ?>

  </div>

<?php get_footer(); ?>
