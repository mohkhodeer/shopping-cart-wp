<?php
/**
 * The template part for displaying single posts
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */
?>

<?php
$current_url = get_permalink();
if (get_post_type() == 'store_product') $is_product = 1;
else $is_product = 0;
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <?php if ($is_product): ?>
    <form id="form_product" method="post" action="<?php echo get_template_directory_uri();?>/cart/cart_update.php">
        <input type="hidden" name="product_id" value="<?php echo get_the_ID();?>" />
        <input type="hidden" name="product_code" value="<?php echo get_field('reference');?>" />
        <input type="hidden" name="type" value="add" />
        <input type="hidden" name="return_url" value="<?php echo $current_url;?>" />
        <div class="left_small">
            <?php
            $str_img_editor = (get_field('images_editor'));
            preg_match_all('/<img[^>]+>/i',$str_img_editor, $str_imgs);

            ?>
            <?php $main_img =wp_get_attachment_image(get_field('main_image')['id'],'large');?>
            <div class="main_img"><?php echo $main_img;?></div>
            <?php if($str_imgs[0][0]!=''){ ?><div class="small_img"><?php echo $str_imgs[0][0]?></div><?php } ?>
            <?php if($str_imgs[0][1]!=''){ ?><div class="small_img"><?php echo $str_imgs[0][1]?></div><?php } ?>
            <?php if($str_imgs[0][2]!=''){ ?><div class="small_img"><?php echo $str_imgs[0][2]?></div><?php } ?>
            <?php if($str_imgs[0][3]!=''){ ?><div class="small_img"><?php echo $str_imgs[0][3]?></div><?php } ?>
        </div>
        <div class="right_large">
            <header class="entry-header">
                <?php the_title('<h3>', '</h3>'); ?>
            </header>
            <!-- .entry-header -->
            <div class="basic_info">
                <div class="label"><?php echo __('Availability'); ?>:</div>
                <div class="value"><span
                        style="color:red;font-weight: bold">
                        <?php
                        $quantity = get_field('quantity');
                        echo ($quantity > 0) ? __('YES') : __('NO'); ?></span>
                    (<?php echo $quantity . ' ';
                    echo __('Items in stock') ?>)
                </div>
                <div class="clear"></div>
                <div class="label"><?php echo __('Reference'); ?>:</div>
                <div class="value"><?php echo get_field('reference') ?></div>
                <div class="clear"></div>
                <div class="label"><?php echo __('Manufacturer'); ?>:</div>
                <div class="value"><?php echo get_field('manufacturer') ?></div>
            </div>

            <div class="tabular_info">
                <ul class="navbar">
                    <li class="more_info"><a href="javascript:void(0)" onclick="openTab(this)">More info</a></li>
                    <li class="data_sheet"><a href="javascript:void(0)" onclick="openTab(this)">Data sheet</a></li>
                    <li class="accessories"><a href="javascript:void(0)" onclick="openTab(this)">Accessories</a></li>
                    <li class="comments"><a href="javascript:void(0)" onclick="openTab(this)">Comments</a></li>
                </ul>

                <div id="more_info" class="tab">
                    <?php the_content(); ?>
                </div>

                <div id="data_sheet" class="tab">

                </div>

                <div id="accessories" class="tab">

                </div>

                <div id="comments" class="tab">

                </div>

                <script>
                    openTab('')
                    function openTab(me) {
                        if (me != '')
                            var TabName = me.parentNode.className;
                        var i;
                        var x = document.getElementsByClassName("tab");
                        for (i = 0; i < x.length; i++) {
                            x[i].style.display = "none";
                            if (me != '') me.parentNode.parentNode.children[i].style.backgroundColor = "#ABACAE"
                            if (me != '') me.parentNode.parentNode.children[i].children[0].style.color = "#fff"
                        }
                        if (me != '') document.getElementById(TabName).style.display = "block";
                        else document.getElementById('more_info').style.display = "block";
                        if (me != '') me.parentNode.style.backgroundColor = "#E6E6E6";
                        else document.getElementsByClassName('more_info')[0].style.backgroundColor = "#E6E6E6";
                        if (me != '') me.style.color = "#FF7B5D";
                        else document.getElementsByClassName('more_info')[0].children[0].style.color = "#FF7B5D";
                    }
                </script>

            </div>
            <div class="row">
                <?php if (get_field('size')) {
                    $sizes = get_field('size');
                    echo "<div class='cell'>";
                    echo __('Size') . ': ';
                    echo "<select name='size_req_key' id='size_req_key'>";
                    for ($i = 0; $i < count($sizes); $i++) {
                        echo "<option value='" . $sizes[$i] . "'>" . $sizes[$i] . "</option>";
                    }
                    echo "</select>";

                    echo '</div>';
                }?>

                <?php if (get_field('color')) {
                    $colors = get_field('color');
                    echo "<div class='cell'>";
                    echo __('Color') . ': ';
                    echo "<select style='color:".$colors[0]."' name='color_req_key' id='color_req_key'>";
                    for ($i = 0; $i < count($colors); $i++) {
                        echo "<option style='color:".$colors[$i]."' value='" . ucfirst($colors[$i]) . "'>" . ucfirst($colors[$i]) . "</option>";
                    }
                    echo "</select>";

                    echo '</div>';
                }?>

                <?php if ($quantity) {
                    echo "<div class='cell'>";
                    echo __('Quantity') . ': ';
                    echo '<input  name="product_qty" id="product_qty" value="1" size="10" style="padding: 2px;" type="text">';
                    echo '</div>';
                }?>
            </div>

            <div class="row">
                <?php
                $cat = get_the_category();
                $price = get_field('price');
                $discount_price = get_field('discount_percentage');
                $price_after_discount =0;
                if($discount_price!='' && $discount_price!=0)
                {
                    $price_after_discount = $price-($price*$discount_price/100);
                }
                ?>
                <div class="big_price"><?php if($price_after_discount>0){
                        echo "<span style='color:#555;font-size:20px;text-decoration: line-through;'>$".$price."</span> ";
                        echo '$'.$price_after_discount;
                    }
                    else echo '$'.$price;
                ?></div>
                <button type="submit" class="buy_btn add_to_cart"><i style="font-size: 20px;margin-right: 10px;" class="fa fa-shopping-cart red"
                                        aria-hidden="true"></i> <?php echo __('Buy this ') . $cat[0]->name; ?></button>
            </div>
        </div>
        </form>
        
        <?php
        $tags = get_the_terms(get_the_ID(),'store_product_tag');
        $tag_ids = $tags[0]->term_id;
        $args = [
    'post__not_in'        => array( get_queried_object_id() ),
    'posts_per_page'      => 4,
    'orderby'             => 'rand',
    'tax_query' => [
        [
            'taxonomy' => 'store_product_tag',
            'terms'    => $tag_ids
        ]
    ]
];

        $my_query = new wp_query( $args );
        $related_products = $my_query->posts; ?>    
        <div id="related_products">
        <div class="title"><?php echo __('Related products');?></div>
        <ul>
        <?php foreach($related_products as $rel_pro){     
            $main_img =wp_get_attachment_image(get_field('main_image', $rel_pro->ID)['id'],'large');
            echo "<li>";
            echo $main_img;
            echo "<div>
            <div class='title_left'><a href='".get_permalink($rel_pro->ID)."'>{$rel_pro->post_title}</a> </div><div class='price_right'> $".get_field('price', $rel_pro->ID)."</div>
            </div>";
            echo "</li>";                                                
        }?>
        </ul>
        </div>                    
    <?php else: ?>
        <header class="entry-header">
            <?php the_title('<h1 class="entry-title">', '</h1>'); ?>
        </header><!-- .entry-header -->
        <?php code95_excerpt(); ?>

        <?php code95_post_thumbnail(); ?>

    <?php endif; ?>

    <footer class="entry-footer">
        <?php code95_entry_meta(); ?>
        <?php
        edit_post_link(
            sprintf(
            /* translators: %s: Name of current post */
                __('Edit<span class="screen-reader-text"> "%s"</span>', 'code95'),
                get_the_title()
            ),
            '<span class="edit-link">',
            '</span>'
        );
        ?>
    </footer>
    <!-- .entry-footer -->
</article><!-- #post-## -->

<script type="text/javascript">
    jQuery(document).ready(function(){
        var stock_qty = parseInt("<?php echo $quantity; ?>");
        jQuery('.add_to_cart').click(function(e){
            e.preventDefault();
            var user_qty = parseInt(jQuery('#product_qty').val());
            if(user_qty>stock_qty) alert('Please enter quantity less than or equal stock quantity');
            else if(user_qty==0 || !(Math.floor(user_qty) == user_qty && jQuery.isNumeric(user_qty)) ) alert('Please enter a valid quantity');
            else jQuery('#form_product').submit();
        });
    });
</script>