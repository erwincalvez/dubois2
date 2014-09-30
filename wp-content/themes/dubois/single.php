<?php
/**
 * The template for displaying all single posts.
 *
 * @package dubois
 */
get_header();
?>

<div id="primary" class="content-area">
  <?php
  if (function_exists('yoast_breadcrumb')) {
    yoast_breadcrumb('<p id="breadcrumbs">', '</p>');
  }
  ?>
  
  <section class="">
    <?php while (have_posts()) : the_post(); ?>
      <?php get_template_part('content', 'single'); ?>
      <?php //dubois_post_nav(); ?>
    <?php endwhile; // end of the loop.   ?>
  </section>
</div><!-- #primary -->
<?php get_footer(); ?>