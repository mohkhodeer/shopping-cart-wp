<?php
/* Template Name: productCategories Template */

get_header(); ?>
<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/style_cat.css"/>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/jquery.js"></script>
<!-- Start WOWSlider.com BODY section --> <!-- add to the <body> of your page -->
<div id="wowslider-container1">
    <div class="ws_images">
        <ul>
            <li>
                <a href="#">
                    <img src="<?php echo get_template_directory_uri(); ?>/img/slide-1.png" alt="cssslider" title="Special Offer 1" id="wows1_0"/></a>
                <a href="#" class="shop_now_btn"><i class="fa fa-shopping-cart red" aria-hidden="true"></i>  <label class="verticalLine"></label> Shop now</a>
            </li>
            <li>
                <a href="#">
                    <img src="<?php echo get_template_directory_uri(); ?>/img/slide-2.jpg" alt="cssslider" title="Special Offer 2" id="wows1_1"/></a>
                <a href="#" class="shop_now_btn"><i class="fa fa-shopping-cart red" aria-hidden="true"></i> <label class="verticalLine"></label>Shop now</a>
            </li>
            <li>
                <a href="#">
                    <img src="<?php echo get_template_directory_uri(); ?>/img/slide-3.jpg" alt="5" title="Special Offer 3" id="wows1_2"/>
                </a>
                <a href="#" class="shop_now_btn"><i class="fa fa-shopping-cart red" aria-hidden="true"></i>  <label class="verticalLine"></label>Shop now</a>
            </li>
            <li>
                <a href="#">
                    <img src="<?php echo get_template_directory_uri(); ?>/img/slide-4.jpg" alt="5" title="Special Offer 4" id="wows1_2"/>
                </a>
                <a href="#" class="shop_now_btn"><i class="fa fa-shopping-cart red" aria-hidden="true"></i>  <label class="verticalLine"></label>Shop now</a>
            </li>

        </ul>
    </div>
    <div class="ws_shadow"></div>
</div>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/wowslider.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/script.js"></script>
<!-- End WOWSlider.com BODY section -->
<div id="content" class="site-content">
<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">
        <?php
        // Start the loop.
        while (have_posts()) : the_post();

        endwhile;

        $i = 0;
        $cats = get_categories(array(
            'child_of' => 2,
            'hide_empty' => 0,
        ));?>
        <div class="cat_grid">
            <?php
            foreach ($cats as $cat) {
                ?>
                <div class="item">
                    <div class="box">
                        <?php
                        echo do_shortcode(sprintf('[wp_custom_image_category term_id="%s"]', $cat->term_id));
                        ?>
                        <div>
                            <div class="title"><?php echo $cat->name; ?></div>
                            <div class="btn"><i class="fa fa-caret-right" aria-hidden="true"></i>&nbsp;&nbsp;<?php echo __('View Collection');?></div>
                        </div>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
    </main>
    <!-- .site-main -->

</div><!-- .content-area -->
</div>
<?php get_sidebar('content-bottom'); ?>
<?php get_footer(); ?>
