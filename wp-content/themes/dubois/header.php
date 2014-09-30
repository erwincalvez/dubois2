<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package dubois
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
  <head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php wp_title('|', true, 'right'); ?></title>
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">

    <?php wp_head(); ?>
  </head>

  <body <?php body_class(); ?>>
    <div id="page" class="hfeed site">
      <a class="skip-link screen-reader-text" href="#content"><?php _e('Skip to content', 'dubois'); ?></a>

      <header id="masthead" class="site-header" role="banner">
        <div class="menu-searchbar">
          <div class="menu-searchbar-inner">
            <span class="open-search">open serach</span>
            <?php get_sidebar('top'); ?>  
          </div>
        </div>
        <div class="search-box">
          <div class="search-box-inner">
            <?php get_template_part('searchform');           // Navigation bar (nav.php) ?>
          </div>
        </div>
        <div class="site-header-inner">
          <div class="site-branding">
            <h1 class="site-title"><a href="<?php echo esc_url(home_url('/')); ?>" rel="home"><?php bloginfo('name'); ?></a></h1>
            <h2 class="site-description"><?php bloginfo('description'); ?></h2>
          </div>
          <div class="menu-pages">
            <?php wp_nav_menu(array('theme_location' => 'Pages')); ?>  
          </div>
        </div>

      </header><!-- #masthead -->

      <div id="content" class="site-content">
