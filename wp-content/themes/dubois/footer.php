<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package dubois
 */
?>

</div><!-- #content -->

<footer id="colophon" class="site-footer" role="contentinfo">
  <div class="site-info">


    <div class="menu-footer">
      <h4>Nos produits</h4>
      <?php wp_nav_menu(array('theme_location' => 'Footer')); ?>  
    </div>

    <div class="sidebar-footer">
      <h4>Nous contacter</h4>
      <?php get_sidebar('footer-right'); ?>
    </div>

  </div><!-- .site-info -->

</footer><!-- #colophon -->
<div class="menu-pages-footer">
  <?php wp_nav_menu(array('theme_location' => 'Pages')); ?>  
</div>
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
