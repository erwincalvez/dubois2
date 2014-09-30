<?php
/**
 * @package dubois
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		

	
	</header><!-- .entry-header -->

	<div class="entry-content">
    <div class="entry-content-left">
    <?php if ( has_post_thumbnail() ) { // dans la boucle
the_post_thumbnail();
}
    ?>
    </div><!-- .entry-content-left -->
    <div class="entry-content-right">
    <?php the_title( sprintf( '<h1 class="entry-title">', esc_url( get_permalink() ) ), '</h1>' ); ?>
      <?php //the_title( sprintf( '<h1 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h1>' ); ?>
      
      <div class="dubois-content">
		<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'dubois' ) ); ?>
      </div>
		 </div><!-- .entry-content-right -->
	</div><!-- .entry-content -->

	
</article><!-- #post-## -->