<?php
/**
 * @package Category_Images
 * @author Scott Reilly
 * @version 1.7.3
 */
/*
Plugin Name: Category Images
Version: 1.7.3
Plugin URI: http://coffee2code.com/wp-plugins/category-images/
Author: Scott Reilly
Author URI: http://coffee2code.com/
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Description: Display an image for each category associated with a post.

Compatible with WordPress 2.5 through 3.4+.

=>> Read the accompanying readme.txt file for instructions and documentation.
=>> Also, visit the plugin's homepage for additional information and updates.
=>> Or visit: http://wordpress.org/extend/plugins/category-images/

TODO:
	* Add widget
	* $image_dir arg should assume images subdirectory relative to possible custom content directory
	* Assume .png as image_extension (forcing user to specify other extension if so desired) (for v2.0)
	* Add UI (ideally integrated with category section) for uploading image(s) for category
	* Support default image for use when no image exists for category
	* Add c2c_category_images( $args = array() ) that is more robust
		* Suggested config options:
			image_extensions (array), image_dir (string), cat_include (array), cat_exclude (array), cat_parents (array),
			multiple_images_per_cat (bool), order (string: id, name), show_if_no_image (bool), default_image (string)
	* Support using closest ancestral category's image if cat doesn't have its own image (perhaps controlled by flag)
	* Perhaps deprecate in favor of Customizable Categories Listing?
*/

/*
	Copyright (c) 2004-2012 by Scott Reilly (aka coffee2code)

	This program is free software; you can redistribute it and/or
	modify it under the terms of the GNU General Public License
	as published by the Free Software Foundation; either version 2
	of the License, or (at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

if ( ! function_exists( 'c2c_get_category_image' ) ) :
/**
 *
 * Finds the URL for a valid image for the category given provided criteria.
 *
 * @param object $category Category object for the category whose image is desired
 * @param array|string $image_extensions (optional) Array or space-separated list of image extensions (case insensitive) to search for (in order of preference).  Default is 'png gif jpg'.
 * @param string $image_dir (optional) The directory to search for the image; default is wp-content/images
 * @return string The URL for the chosen category image
 */
function c2c_get_category_image( $category, $image_extensions = 'png gif jpg', $image_dir = 'wp-content/images' ) {
	if ( ! $image_extensions )
		$image_extensions = array( 'png', 'gif', 'jpg' );
	elseif ( ! is_array( $image_extensions ) )
		$image_extensions = explode( ' ', $image_extensions );

	$url = '';
	$image_dir = '/' . trim( $image_dir, '/' ) . '/';

	foreach ( $image_extensions as $image_extension ) {
		$sub_path = $image_dir . $category->category_nicename . '.' . $image_extension;
		if ( file_exists( ABSPATH . $sub_path ) ) {
			$url = get_option( 'siteurl' ) . $sub_path;
			break;
		}
	}

	return $url;
}
add_filter( 'c2c_get_category_image', 'c2c_get_category_image', 10, 3 );
endif;


if ( ! function_exists( 'c2c_get_the_category_image_list' ) ) :
/**
 * Returns a formatted list of category images for the categories related to the specified post.
 *
 * @since 1.5
 *
 * @param string $separator (optional) The text and/or HTML to appear between each of a post's category images
 * @param string $parents (optional) Allows you to specify if you want ancestor categories of a post's category to be imaged and linked as well.  Valid options are 'multiple', 'single', and ''. Default is ''.
 * @param array|string $image_extensions (optional) Array or space-separated list of image extensions (case insensitive) to search for (in order of preference).  If defined as '' then no image is retrieved and the category name is displayed instead (a la `the_category()`).  Default is 'png gif jpg'.
 * @param string $image_dir (optional) The directory to search for the image; default is wp-content/images
 * @param bool $use_name_if_no_image (optional) Boolean value (true or false) indicating if the name of the category should be displayed for each category that does not have an associated image.  Default is false.
 * @param string $start_from (optional) How to traverse the list of post's categories; either 'begin' or 'end'.  Default is 'begin'
 * @param int $limit (optional) The maximum number of category images to be displayed.  Default is 999 (basically, no limit)
 * @param false|int $post_id (optional) Post ID. If false, then use the current post (i.e. while in the loop).  Default is false.
 * @return string The formatting listing of category images
 */
function c2c_get_the_category_image_list( $separator = '', $parents = '', $image_extensions = 'png gif jpg', $image_dir = 'wp-content/images', $use_name_if_no_image = false, $start_from = 'begin', $limit = 999, $post_id = false ) {
	global $wp_rewrite;
	$categories = get_the_category( $post_id );

	// This only factors in for WP 3.0+ installations
	if ( function_exists( 'is_object_in_taxonomy' ) ) :
		if ( ! is_object_in_taxonomy( get_post_type( $post_id ), 'category' ) )
			return apply_filters( 'the_category', '', $separator, $parents );
	endif;

	if ( empty( $categories ) )
		return ( $use_name_if_no_image ? apply_filters( 'the_category', __( 'Uncategorized' ), $separator, $parents ) : '' );

	$rel = ( is_object( $wp_rewrite ) && $wp_rewrite->using_permalinks() ) ? 'rel="category tag"' : 'rel="category"';

	$thelist = '';
	$count = 1; // the limit counter
	if ( 'end' == $start_from )
		$categories = array_reverse( $categories );
	if ( '' == $separator ) {
		$thelist .= '<ul class="post-categories">';
		foreach ( $categories as $category ) {
			if ( $count > $limit )
				break;
			if ( empty( $image_extensions ) ) {
				$category_display = $category->name;
			} else {
				$image_url = c2c_get_category_image( $category, $image_extensions, $image_dir );
				if ( empty( $image_url ) ) {
					if ( !$use_name_if_no_image )
						continue;
					$category_display = $category->name;
				} else {
					$category_display = '<img class="catimage" alt="' . $category->name . '" src="' . $image_url . '" />';
				}
			}

			$thelist .= "\n\t<li>";
			switch ( strtolower( $parents ) ) {
				case 'multiple':
					if ( $category->parent )
						$thelist .= get_category_parents( $category->parent, true, $separator );
					$thelist .= '<a href="' . get_category_link( $category->term_id ) . '" title="' . sprintf( __( 'View all posts in %s' ), $category->name ) . '" ' . $rel . '>' . $category_display . '</a></li>';
					break;
				case 'single':
					$thelist .= '<a href="' . get_category_link( $category->term_id ) . '" title="' . sprintf( __( 'View all posts in %s' ), $category->name ) . '" ' . $rel . '>';
					if ( $category->parent )
						$thelist .= get_category_parents( $category->parent, false, $separator );
					$thelist .= $category_display . '</a></li>';
					break;
				case '':
				default:
					$thelist .= '<a href="' . get_category_link( $category->term_id ) . '" title="' . sprintf( __( 'View all posts in %s' ), $category->name ) . '" ' . $rel . '>' . $category_display . '</a></li>';
			}
			++$count;
		}
		$thelist .= '</ul>';
	} else {
		$i = 0;
		foreach ( $categories as $category ) {
			if ( $count > $limit )
				break;
			$category->cat_name = stripslashes( $category->cat_name );
			if ( empty( $image_extensions ) ) {
				$category_display = $category->name;
			} else {
				$image_url = c2c_get_category_image( $category, $image_extensions, $image_dir );
				if ( empty( $image_url ) ) {
					if ( $use_name_if_no_image )
						$category_display = $category->name;
					else
						continue;
				} else {
					$category_display = '<img class="catimage" alt="' . $category->name . '" src="' . $image_url . '" />';
				}
			}
			if ( 0 < $i )
				$thelist .= $separator;
			switch ( strtolower( $parents ) ) {
				case 'multiple':
					if ( $category->parent )
						$thelist .= get_category_parents( $category->parent, TRUE );
					$thelist .= '<a href="' . get_category_link( $category->term_id ) . '" title="' . sprintf( __( 'View all posts in %s' ), $category->name ) . '" ' . $rel . '>' . $category_display . '</a>';
					break;
				case 'single':
					$thelist .= '<a href="' . get_category_link( $category->term_id ) . '" title="' . sprintf( __( 'View all posts in %s' ), $category->name ) . '" ' . $rel . '>';
					if ( $category->parent )
						$thelist .= get_category_parents( $category->parent, FALSE );
					$thelist .= "$category_display</a>";
					break;
				case '':
				default:
					$thelist .= '<a href="' . get_category_link( $category->term_id ) . '" title="' . sprintf( __( 'View all posts in %s' ), $category->name ) . '" ' . $rel . '>' . $category_display . '</a>';
			}
			++$i;
			++$count;
		}
	}
	return apply_filters( 'c2c_category_image_list', apply_filters( 'the_category', $thelist, $separator, $parents ) );
}
add_filter( 'c2c_get_the_category_image_list', 'c2c_get_the_category_image_list', 10, 8 );
endif;


if ( ! function_exists( 'c2c_the_category_image' ) ) :
/**
 * Echoes a formatted list of category images for the categories related to the current post.
 *
 * @param string $separator (optional) The text and/or HTML to appear between each of a post's category images
 * @param string $parents (optional) Allows you to specify if you want ancestor categories of a post's category to be imaged and linked as well.  Valid options are 'multiple', 'single', and ''. Default is ''.
 * @param array|string $image_extensions (optional) Array or space-separated list of image extensions (case insensitive) to search for (in order of preference).  If defined as '' then no image is retrieved and the category name is displayed instead (a la `the_category()`).  Default is 'png gif jpg'.
 * @param string $image_dir (optional) The directory to search for the image; default is wp-content/images
 * @param bool $use_name_if_no_image (optional) Boolean value (true or false) indicating if the name of the category should be displayed for each category that does not have an associated image.  Default is false.
 * @param string $start_from (optional) How to traverse the list of post's categories; either 'begin' or 'end'.  Default is 'begin'
 * @param int $limit (optional) The maximum number of category images to be displayed.  Default is 999 (basically, no limit)
 * @return void (Text is echoed.)
 */
function c2c_the_category_image( $separator = '', $parents = '', $image_extensions = 'png gif jpg', $image_dir = 'wp-content/images', $use_name_if_no_image = false, $start_from = 'begin', $limit = 999 ) {
	echo c2c_get_the_category_image_list( $separator, $parents, $image_extensions, $image_dir, $use_name_if_no_image, $start_from, $limit );
}
add_action( 'c2c_the_category_image', 'c2c_the_category_image', 10, 7 );
endif;
