<?php
/* Template Name: Homepage Template */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main site-content" role="main">

		<?php if ( have_posts() ) : ?>

				<header>
					<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
				</header>

            <div class="home_grid">
			<?php
			// Start the loop.
            $args = array( 'post_type' => 'store_product', 'posts_per_page' => 12 );
            $loop = new WP_Query( $args );
            while ( $loop->have_posts() ) : $loop->the_post();?>
                <div class="item">
                <?php $prod_img = get_field('main_image') ?>
                    <?php echo wp_get_attachment_image($prod_img['id'],'medium');?>
                    <h2 style="padding-top: 20px"><a style="color:#333" href="<?php echo get_permalink()?>"><?php the_title();?></a></h2>
                    <?php echo get_field('manufacturer');?>
                    <p class="price" >$<?php echo get_field('price');?></p>
                    <p class="toolbar">
                        <i class="fa fa-shopping-cart red" aria-hidden="true"> <?php echo __('Shop'); ?></i>
                        <i class="fa fa-heart" aria-hidden="true"></i>
                        <i class="fa fa-comments" aria-hidden="true"></i>
                    </p>
                </div>
            <?php endwhile; ?>
            </div>
            <a class="load_btn" href="javascript:void()"><?php echo __('Load more products +');?></a>
        <?php

		// If no content, include the "No posts found" template.
		else :
			get_template_part( 'template-parts/content', 'none' );

		endif;
		?>

		</main><!-- .site-main -->
	</div><!-- .content-area -->
</div>
<?php get_sidebar('content-bottom'); ?>
<?php get_footer(); ?>
