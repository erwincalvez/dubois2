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

  <section class="left">
    <?php
    $cats_str = get_category_parents($cat, false, '%#%');
    $cats_array = explode('%#%', $cats_str);
    $current_cat_depth = sizeof($cats_array) - 2;
    // echo 'depth : '.$current_cat_depth.'<br/>';
    ?>


    <?php
    if (is_category()) {
      global $wp_query;
      $category_id = $wp_query->query_vars['cat'];
      //  echo 'cat ID : '.$category_id.'<br/>';
      /* if (get_category_children($category_id) != "") {
        // echo $category_id;
        echo "<ul class='ONE'>";
        wp_list_categories('hide_empty=0&orderby=id&show_count=0&title_li=&use_desc_for_title=1&child_of=' . $category_id);
        echo "</ul>";
        } */
      if ($current_cat_depth == 0) {
        // echo $category_id;
        echo "<ul class='ONE'>";
        wp_list_categories('hide_empty=0&orderby=id&show_count=0&title_li=&use_desc_for_title=1&child_of=' . $category_id);
        echo "</ul>";
      }
    }
    ?>

    <?php
    $max_depth_to_test = 2; //set this to highest depth you might have
    $last_depth = 0;
    $cat_to_test = $category_id;
    $category = get_category($cat_to_test);
    for ($counter = 1; $counter <= $max_depth_to_test; $counter++) {
      if ($category->category_parent) {
        $category = get_category($category->category_parent);
        $last_depth = $counter;
      }
    }
    $last_depth +=1;
    ?>
    <?php $category_id = get_query_var('cat'); ?>
    <?php //if ($last_depth == 3) : ?>

    <?php if ($current_cat_depth == 1) : ?>
      <?php
      $category = get_category($category_id);
      $parent_id = $category->category_parent;
      // echo 'parent ID'.$parent_id.'<br/>';
      //$parent_category = get_category($parent_id);
      //$new_parent_id = $parent_category->category_parent;
      // echo 'New parent ID'.$new_parent_id.'<br/>';
      echo "<ul class='TWO'>";
      wp_list_categories('hide_empty=0&orderby=id&show_count=0&title_li=&use_desc_for_title=1&child_of=' . $parent_id);
      echo '</ul>';
      ?>


    <?php elseif ($current_cat_depth == 2) : ?>
      <?php
      $category = get_category($category_id);

      $parent_id = $category->category_parent;

      //echo 'parent ID'.$parent_id.'<br/>';
      $parent_category = get_category($parent_id);
      $new_parent_id = $parent_category->category_parent;
      //echo 'New parent ID'.$new_parent_id.'<br/>';
      echo "<ul class='THREE'>";
      wp_list_categories('hide_empty=0&orderby=id&show_count=0&title_li=&use_desc_for_title=1&child_of=' . $new_parent_id);
      echo '</ul>';
      ?>
    <?php endif; ?>
  </section><!-- end section left -->





  <section class="right">
    <?php
    if (function_exists('yoast_breadcrumb')) {
      yoast_breadcrumb('<p id="breadcrumbs">', '</p>');
    }
    ?>
    <h1 class="cat-main-title"><?php single_cat_title(); ?></h1>
    <br/>
    <h2 class="cat-main-description"><?php echo category_description(); ?></h2>
    <?php ?>
    <?php
    $url1 = categoryCustomFields_GetCategoryCustomField($category_id, 'image');
    $url1 = explode('@', $url1[0]->field_value);
    $url1 = $url1[0];
//pas de display de l'image de category main  
    echo '<img class="category-image" src=' . $url1 . '>';
    ?>
    <br/>

    <?php
    if (is_category()) {
      echo "<div class='category-list'>";
      $categories = get_categories('hide_empty=0&orderby=id&show_count=0&depth=0&title_li=&use_desc_for_title=1&parent=' . $category_id);
      //$category_link = get_category_link( $category_id );
      echo "<ul>";
      foreach ($categories as $category) {
        echo '<li class="clearfix coucou">';
        // print_r($category);
        echo '<h3 class="subcategory-title">';
        $newcatid = $category->cat_ID;
        echo "<a href=" . get_category_link($newcatid) . ">";
        echo $category->name;

        //echo $currentcatid;
        //echo get_category_link( $currentcatid );  

        echo '</a>';
        echo '</h3>';
        echo '<h5 class="subcategory-description">';
        echo $category->description;
        echo '</h5>';
        echo '<br/>';
        $currentcatid = $category->cat_ID;
        $url = categoryCustomFields_GetCategoryCustomField($currentcatid, 'image');
        $url = explode('@', $url[0]->field_value);
        $url = $url[0];
        echo '<img class="subcategory-image" src=' . $url . '>';

        echo '<ul class="brands-list">';
        // echo '<p>Nos marque</p>';
        $brands = wp_list_categories('hide_empty=0&orderby=id&show_count=0&title_li=&use_desc_for_title=1&child_of=' . $currentcatid);
        //  wp_list_categories('hide_empty=0&orderby=id&show_count=0&title_li=&use_desc_for_title=1&child_of=' . $currentcatid);

        echo $brands;


        //on affiche les produits car profondeur de niveau 3
        if (($brands == 0)) :
          echo 'VIDE';
          while (have_posts()) : the_post();
            get_template_part('content', get_post_format());
          endwhile;
        endif;

        echo '</ul>';
        echo '</li>';
      }
      echo "</ul>";

      // print_r(get_categories('hide_empty=0&orderby=id&show_count=0&depth=1&title_li=&use_desc_for_title=1&child_of=' . $category_id));

      echo "</div>";
    }
    ?>


    <br/>

    <?php
    if (is_category()) {
      
    }
    ?>

    <br/>
    <?php
//test category 11 depth or level
    $max_depth_to_test = intval(2); //set this to highest depth you might have
    $last_depth = 0;
    $cat_to_test = $category_id;
    $category = get_category($cat_to_test);
    for ($counter = 1; $counter <= $max_depth_to_test; $counter += 1) {
      if ($category->category_parent) {
        $category = get_category($category->category_parent);
        $last_depth = $counter;
      }
    }
    $last_depth +=1;
    echo '<p style="color:red;">Category ' . $cat_to_test . ' it is at depth ' . $last_depth . '</p>';
    ?>

    <br/>


    <?php
//on affiche les produits car profondeur de niveau 3
    if ((have_posts()) && ($last_depth == 3)) :
      ?>

      <?php /* Start the Loop */ ?>
      <?php // query_posts( 'orderby=title' );  ?>
      <?php while (have_posts()) : the_post(); ?>
        <?php
        /* Include the Post-Format-specific template for the content.
         * If you want to override this in a child theme, then include a file
         * called content-___.php (where ___ is the Post Format name) and that will be used instead.
         */
        get_template_part('content', get_post_format());
        ?>
      <?php endwhile; ?>

      <?php //dubois_paging_nav(); ?>

      <?php //else :      ?>

      <?php //get_template_part('content', 'none');      ?>

    <?php endif; ?>
  </section>





</div><!-- #primary -->


<?php get_footer(); ?>
