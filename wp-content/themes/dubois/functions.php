<?php

/**
 * dubois functions and definitions
 *
 * @package dubois
 */
/**
 * Set the content width based on the theme's design and stylesheet.
 */
if (!isset($content_width)) {
  $content_width = 640; /* pixels */
}

if (!function_exists('dubois_setup')) :

  /**
   * Sets up theme defaults and registers support for various WordPress features.
   *
   * Note that this function is hooked into the after_setup_theme hook, which
   * runs before the init hook. The init hook is too late for some features, such
   * as indicating support for post thumbnails.
   */
  function dubois_setup() {

    /*
     * Make theme available for translation.
     * Translations can be filed in the /languages/ directory.
     * If you're building a theme based on dubois, use a find and replace
     * to change 'dubois' to the name of your theme in all the template files
     */
    load_theme_textdomain('dubois', get_template_directory() . '/languages');

    // Add default posts and comments RSS feed links to head.
    add_theme_support('automatic-feed-links');

    /*
     * Enable support for Post Thumbnails on posts and pages.
     *
     * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
     */
    //add_theme_support( 'post-thumbnails' );
    // This theme uses wp_nav_menu() in one location.
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'dubois'),
    ));

    /*
     * Switch default core markup for search form, comment form, and comments
     * to output valid HTML5.
     */
    add_theme_support('html5', array(
        'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
    ));

    /*
     * Enable support for Post Formats.
     * See http://codex.wordpress.org/Post_Formats
     */
    add_theme_support('post-formats', array(
        'aside', 'image', 'video', 'quote', 'link'
    ));

    // Setup the WordPress core custom background feature.
    add_theme_support('custom-background', apply_filters('dubois_custom_background_args', array(
        'default-color' => 'ffffff',
        'default-image' => '',
    )));
  }

endif; // dubois_setup
add_action('after_setup_theme', 'dubois_setup');

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function dubois_widgets_init() {
  register_sidebar(array(
      'name' => __('Sidebar', 'dubois'),
      'id' => 'sidebar-1',
      'description' => '',
      'before_widget' => '<aside id="%1$s" class="widget %2$s">',
      'after_widget' => '</aside>',
      'before_title' => '<h1 class="widget-title">',
      'after_title' => '</h1>',
  ));
}

add_action('widgets_init', 'dubois_widgets_init');

/**
 * Enqueue scripts and styles.
 */
function dubois_scripts() {
  wp_enqueue_script('jquerylibrary', get_template_directory_uri() . '/js/jquerylibrary.js', array(), '1.0.0', true);
  wp_enqueue_style('dubois-style', get_stylesheet_uri());
  wp_enqueue_style('dubois', get_template_directory_uri() . '/stylesheets/dubois.css');
  wp_enqueue_script('dubois-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true);
  wp_enqueue_script('duboisjs', get_template_directory_uri() . '/js/dubois.js', array(), '1.0.0', true);
  wp_enqueue_script('dubois-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true);

  if (is_singular() && comments_open() && get_option('thread_comments')) {
    wp_enqueue_script('comment-reply');
  }
}

add_action('wp_enqueue_scripts', 'dubois_scripts');

add_theme_support('post-thumbnails');

//Use the menu descritpion in our theme :

class Menu_With_Description extends Walker_Nav_Menu {

  function start_el(&$output, $item, $depth, $args) {
    global $wp_query;
    $indent = ( $depth ) ? str_repeat("\t", $depth) : '';

    $class_names = $value = '';

    $classes = empty($item->classes) ? array() : (array) $item->classes;

    $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item));
    $class_names = ' class="' . esc_attr($class_names) . '"';

    $output .= $indent . '<li id="menu-item-' . $item->ID . '"' . $value . $class_names . '>';

    $attributes = !empty($item->attr_title) ? ' title="' . esc_attr($item->attr_title) . '"' : '';
    $attributes .=!empty($item->target) ? ' target="' . esc_attr($item->target) . '"' : '';
    $attributes .=!empty($item->xfn) ? ' rel="' . esc_attr($item->xfn) . '"' : '';
    $attributes .=!empty($item->url) ? ' href="' . esc_attr($item->url) . '"' : '';

    $item_output = $args->before;
    $item_output .= '<a' . $attributes . '>';
    $item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;
    $item_output .= '<br/><span class="sub">' . $item->description . '</span>';
    $item_output .= '<span class="read-more">Lire plus</span>';
    $item_output .= '</a>';
    $item_output .= $args->after;

    $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
  }

}


if (function_exists('register_sidebar')) {
  register_sidebar(array(
      'name' => 'top',
      'id' => 'top',
      'description' => 'Appears as the sidebar on the top of pages',
      'before_widget' => '<li id="%1$s" class="widget %2$s">',
      'after_widget' => '</li>',
      'before_title' => '<h2 class="widgettitle">',
      'after_title' => '</h2>',
  ));
}
if (function_exists('register_sidebar')) {
  register_sidebar(array(
      'name' => 'middle',
      'id' => 'middle',
      'description' => 'Appears as the sidebar on the top of pages',
      'before_widget' => '<li id="%1$s" class="widget %2$s">',
      'after_widget' => '</li>',
      'before_title' => '<h2 class="widgettitle">',
      'after_title' => '</h2>',
  ));
}

if (function_exists('register_sidebar')) {
  register_sidebar(array(
      'name' => 'footer right',
      'id' => 'footer-right',
      'description' => 'Appears as the sidebar on the footer right of pages',
      'before_widget' => '<li id="%1$s" class="widget %2$s">',
      'after_widget' => '</li>',
      'before_title' => '<h2 class="widgettitle">',
      'after_title' => '</h2>',
  ));
}


register_nav_menus(array(
    'Pages' => 'les pages',
));

register_nav_menus(array(
    'Footer' => 'Menu du footer',
));


/**
 * Implement the Custom Header feature.
 */
//require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';
