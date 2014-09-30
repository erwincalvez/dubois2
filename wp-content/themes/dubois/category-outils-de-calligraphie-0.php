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


CATEGORY COULEUR TECHNIQUE HUMIDE PHP
  <p>Category: <?php single_cat_title(); ?></p>

  <?php
  if (is_category()) {
    global $wp_query;
    $category_id = $wp_query->query_vars['cat'];

    if (get_category_children($category_id) != "") {
      echo "<h2>Subcategories</h2>";
      echo "<ul>";
      wp_list_categories('hide_empty=0&orderby=id&show_count=0&title_li=&use_desc_for_title=1&child_of=' . $category_id);
      echo "</ul>";
    }
  }
  ?>

</div><!-- #primary -->


<?php get_footer(); ?>
