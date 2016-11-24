<?php session_start(); ?>
<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "site-content" div.
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <?php if (is_singular() && pings_open(get_queried_object())) : ?>
        <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
    <?php endif; ?>
    <?php wp_head(); ?>
    <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
    <script type="text/javascript">
        jQuery(document).ready(function () {
            jQuery('#shopping_cart_btn').click(function () {
                jQuery(this).toggleClass('white');
                jQuery('.cart-view-table-front').slideToggle();
            });
            jQuery('#submit').click(function(){
                var row_indexes='';
                jQuery('.remove_cart_row:checked').each(function() {
                    row_indexes += jQuery(this).attr('id')+',';
                });
                row_indexes = row_indexes.slice(0, -1);
                jQuery('#cart_row_idx').val(row_indexes);
            });

            jQuery('#checkout').click(function(){
                jQuery('#action').val('checkout');
            });

        });
    </script>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
<div class="site-inner">
<a class="skip-link screen-reader-text" href="#content"><?php _e('Skip to content', 'code95'); ?></a>

<header id="masthead" class="site-header" role="banner">
    <div class="site-header-main">
        <div class="site-branding">
            <?php code95_the_custom_logo(); ?>

            <?php if (is_front_page() && is_home()) : ?>
                <h1 class="site-title"><a href="<?php echo esc_url(home_url('/')); ?>"
                                          rel="home"><?php bloginfo('name'); ?></a></h1>
            <?php else : ?>
                <p class="site-title"><a href="<?php echo esc_url(home_url('/')); ?>"
                                         rel="home"><?php bloginfo('name'); ?></a></p>
            <?php endif;

            $description = get_bloginfo('description', 'display');
            if ($description || is_customize_preview()) : ?>
                <p class="site-description"><?php echo $description; ?></p>
            <?php endif; ?>
        </div>
        <!-- .site-branding -->

        <?php if (has_nav_menu('primary') || has_nav_menu('social')) : ?>
            <button id="menu-toggle" class="menu-toggle"><?php _e('Menu', 'code95'); ?></button>

            <div id="site-header-menu" class="site-header-menu">
                <?php if (has_nav_menu('primary')) : ?>
                    <nav id="site-navigation" class="main-navigation" role="navigation"
                         aria-label="<?php esc_attr_e('Primary Menu', 'code95'); ?>">
                        <?php
                        wp_nav_menu(array(
                            'theme_location' => 'primary',
                            'menu_class' => 'primary-menu',
                        ));
                        ?>
                    </nav><!-- .main-navigation -->
                <?php endif; ?>

                <?php if (has_nav_menu('social')) : ?>
                    <nav id="social-navigation" class="social-navigation" role="navigation"
                         aria-label="<?php esc_attr_e('Social Links Menu', 'code95'); ?>">
                        <?php
                        wp_nav_menu(array(
                            'theme_location' => 'social',
                            'menu_class' => 'social-links-menu',
                            'depth' => 1,
                            'link_before' => '<span class="screen-reader-text">',
                            'link_after' => '</span>',
                        ));
                        ?>
                    </nav><!-- .social-navigation -->
                <?php endif; ?>
            </div><!-- .site-header-menu -->
            <div class="social_div">
                <a id="shopping_cart_btn" href="javascript:void(0);"><i class="fa fa-shopping-cart"
                                                                        aria-hidden="true"></i><b
                        style="color:#fff;font-size: 18px;"><?php echo count($_SESSION["product_codes"]) ?></b>
                    <span style="font-size:12px">Item(s)</span></a>
                <?php
                /*** shopping cart ***/
                global $wp;
                /*$_SESSION["product_codes"][1]='PR0000008';
                $_SESSION["product_codes"][2]='PR0000007';*/
                $current_url = home_url(add_query_arg(array(), $wp->request));
                if (isset($_SESSION["cart_products"]) && count($_SESSION["cart_products"]) > 0) {
                    echo '<div class="cart-view-table-front" id="view-cart">';
                    echo '<h3>Your Shopping Cart</h3>';
                    echo '<form id="cart_form" method="post" action="' . get_template_directory_uri() . '/cart/cart_update.php">';
                    echo '<table width="100%"  cellpadding="6" cellspacing="0">';
                    echo '<tbody>';

                    $total = 0;
                    $b = 0;
                    /*** remove duplicated products codes ***/

                    /*echo '<pre>';
                    print_r($_SESSION["cart_products"]);
                    print_r($_SESSION["product_codes"]);
                    print_r($_SESSION["product_attrs"]);
                    echo '</pre>';*/
                    /*** remove duplicated products codes# ***/

                    /*** listing cart items ***/
                    $j=0;
                    foreach(array_unique($_SESSION["product_codes"]) as $product_code){
                        foreach ($_SESSION["cart_products"][$product_code] as $cart_itm) {
                            $product_name = $cart_itm["product_name"];
                            $product_qty = $cart_itm["product_qty"];
                            $product_price = $cart_itm["product_price"];
                            $product_code = $cart_itm["product_code"];
                            $product_attributes = implode(',',$cart_itm["attributes"]);
                            $subtotal = ($product_price * $product_qty);
                            $total = ($total + $subtotal);
                            $bg_color = ($b++ % 2 == 1) ? 'odd' : 'even'; //zebra stripe
                            echo '<tr class="' . $bg_color . '">';
                            echo '<td>Qty <input type="text" size="4" maxlength="4" name="product_qty['.$product_code.']['.$product_attributes.']" value="' . $product_qty . '" /></td>';
                            echo '<td>' . $product_name .'<span style="color:#FF8067"> ( '.$product_attributes. ' )</span></td>';
                            echo '<td><input type="checkbox" class="remove_cart_row" id="'.$j.'" name="remove_code[]" value="' . $product_code . '*'.$product_attributes.'" /> Remove</td>';
                            echo '<td>Subtotal: $' . $subtotal . '</td>';
                            echo '</tr>';
                            $j++;
                        }
                    }

                    echo '<td colspan="3">';
                    echo '<input type="hidden" name="cart_row_idx" id="cart_row_idx" >';
                    echo '<button id="submit" type="submit">Update</button>
                    <button id="checkout" type="submit">Checkout</button>';
                    echo '</td>';
                    echo '<td>Total: $' . $total . '</td>';
                    echo '</tbody>';
                    echo '</table>';
                    echo '<input type="hidden" name="return_url" value="' . $current_url . '" />';
                    echo '<input type="hidden" name="action" id="action" />';
                    echo '</form>';
                    echo '</div>';

                }
                /*** listing cart items# ***/
                /*** shopping cart! ***/
                //unset($_SESSION['cart_products']['PR0000007']['XXXL,Green']);
                ?>
                <a style="color:#555;margin:0 10px" href="#"><?php echo __('Login') ?></a>
                <a class="fa fa-search" href="#" title="Twitter" target="_blank"></a>
                <a class="fa fa-twitter" href="#" title="Twitter" target="_blank"></a>
                <a class="fa fa-vimeo-square" href="#" title="Twitter" target="_blank"></a>
                <a class="fa fa-facebook" href="#" title="Twitter" target="_blank"></a>
            </div>
        <?php endif; ?>
    </div>

    <!-- .site-header-main -->

    <?php if (get_header_image()) : ?>
        <?php
        /**
         * Filter the default code95 custom header sizes attribute.
         *
         * @since Twenty Sixteen 1.0
         *
         * @param string $custom_header_sizes sizes attribute
         * for Custom Header. Default '(max-width: 709px) 85vw,
         * (max-width: 909px) 81vw, (max-width: 1362px) 88vw, 1200px'.
         */
        $custom_header_sizes = apply_filters('code95_custom_header_sizes', '(max-width: 709px) 85vw, (max-width: 909px) 81vw, (max-width: 1362px) 88vw, 1200px');
        ?>
        <div class="header-image">
            <a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                <img src="<?php header_image(); ?>"
                     srcset="<?php echo esc_attr(wp_get_attachment_image_srcset(get_custom_header()->attachment_id)); ?>"
                     sizes="<?php echo esc_attr($custom_header_sizes); ?>"
                     width="<?php echo esc_attr(get_custom_header()->width); ?>"
                     height="<?php echo esc_attr(get_custom_header()->height); ?>"
                     alt="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>">
            </a>
        </div><!-- .header-image -->
    <?php endif; // End header image check. ?>
</header>
<!-- .site-header -->

<!-- breadcrumb -->
<?php if (!is_home() && !is_front_page()) { ?>
    <div class="breadcrumb site-header">
        <?php custom_breadcrumbs(); ?>
    </div>
<?php } ?>
<!-- breadcrumb# -->
<?php if (is_home() || is_front_page()) { ?>
    <?php /*** slider ***/ ?>
    <?php   $products = get_posts(array('post_type' => 'store_product',
        'post_status' => 'publish',
        'meta_query' => array(
            array(
                'key' => 'home_slide',
                'value' => '1',
            )
        ))); ?>

    <!-- Start WOWSlider.com BODY section --> <!-- add to the <body> of your page -->
    <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/style.css"/>
    <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/jquery.js"></script>
    <div id="wowslider-container1">
        <div class="ws_images">
            <ul>
                <?php foreach ($products as $product) {
                    $i = 0; ?>
                    <?php $prod_img = get_field('home_slide_image', $product->ID); ?>
                    <li>
                        <h3 class="title_slide"><?php echo $product->post_title; ?></h3>
                        <a href="<?php the_permalink($product->ID); ?>">
                            <img src="<?php echo wp_get_attachment_image_src($prod_img['id'], 'full')[0]; ?>"
                                 alt="<?php echo $product->post_title; ?>"
                                 title="<?php echo substr(wp_strip_all_tags($product->post_content), 0, 150); ?>..."
                                 id="wows1_<?php echo $i; ?>"/></a>

                        <p class="price_area">Only
                            <strong>$<?php echo get_field('price', $product->ID) ?></strong></p>
                        <a href="<?php the_permalink($product->ID); ?>" class="shop_now_btn"><i
                                class="fa fa-shopping-cart" aria-hidden="true"></i> <label
                                class="verticalLine"></label> Shop now</a>
                    </li>
                    <?php $i++;
                } ?>
            </ul>

        </div>
        <div class="ws_shadow"></div>
    </div>
    <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/wowslider.js"></script>
    <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/script.js"></script>
    <!-- End WOWSlider.com BODY section -->

    <?php /*** slider! ***/ ?>
    <?php if (is_active_sidebar('sidebar-5')) : ?>
        <div id="home_slider_bottom" class="sidebar widget-area" role="complementary">
            <?php dynamic_sidebar('sidebar-5'); ?>
        </div><!-- .sidebar .widget-area -->
    <?php endif; ?>
<?php } ?>


