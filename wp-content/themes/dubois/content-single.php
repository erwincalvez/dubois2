<?php
/**
 * @package dubois
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
<?php if ( has_post_thumbnail() ) { // dans la boucle
echo '<div class="single-image">';  
the_post_thumbnail();
echo '</div>'; 


}
		?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_content(); ?>
		
	</div><!-- .entry-content -->

	
</article><!-- #post-## -->
