<?php

/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 */

get_header();

?>

<?php while ( have_posts() ): ?>
	<?php
		the_post();
	?>

	<section class="page-banner" aria-label="Page header">
		<div class="container container--text text-center animated">
			<h1 class="page-banner__title"><?= get_the_title(); ?></h1>
		</div>
	</section>

	<article id="post-<?php the_ID(); ?>" >
		<div class="section bg-white">

			<div class="container container--text flow animated">

				<?php the_content(); ?>

			</div> <!-- /.container -->
		</div>
	</article><!-- #post -->

<?php endwhile; ?>

<?php get_footer(); ?>
