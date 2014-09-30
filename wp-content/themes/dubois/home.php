<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package dubois
 */
get_header();
?>

<div id="primary" class="content-area">

  <?php
  $args = array('post_type' => 'coups-de-coeur', 'posts_per_page' => 1);
  $loop = new WP_Query($args);
  while ($loop->have_posts()) : $loop->the_post();
    ?>
    <?php
      $image = types_render_field("illustration-custom", array());
      $array = array();
      preg_match('/src="([^"]*)"/i', $image, $array);
      //print_r($array[1]);
      $source_coeur = ($array[1]);
      ?>
   <?php
    endwhile;
  ?>

  <?php
  $args = array('post_type' => 'evenements', 'posts_per_page' => 1);
  $loop = new WP_Query($args);
  while ($loop->have_posts()) : $loop->the_post();
    ?>
    <?php
      $image2 = types_render_field("illustration-custom", array());
     
      $array2 = array();
      preg_match('/src="([^"]*)"/i', $image2, $array2);
      //print_r($array[1]);
      $source_evenement = ($array2[1]);
    
      ?>
   <?php
    endwhile;
  ?>
  
  <style type="text/css">
    .main-navigation li.coeur{
      background-image: url('<?php echo $source_coeur ?>') ;
      background-size: cover;
      background-repeat: no-repeat;
    }
.main-navigation li.evenement{
      background-image: url('<?php echo $source_evenement ?>') ;
      background-size: cover;
      background-repeat: no-repeat;
    }
    
    
  </style>

  <nav id="site-navigation" class="main-navigation" role="navigation">
    <!--button class="menu-toggle"><?php // _e('Primary Menu', 'dubois'); ?></button-->
    <?php //wp_nav_menu(array('theme_location' => 'primary'));  ?>

    <?php  $walker = new Menu_With_Description; ?>

    <?php  wp_nav_menu(array('theme_location' => 'primary', 'menu_class' => 'nav-menu', 'walker' => $walker)); ?>

  </nav><!-- #site-navigation -->
</div><!-- #primary -->


<?php get_footer(); ?>
