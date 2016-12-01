<?php
session_start();
/*** include wordpress ***/
require('../../../../wp-blog-header.php');
get_header();
/*** include wordpress! ***/

//add product to session or create new one


if (isset($_POST) && is_array($_POST)){
    $user_email = filter_var($_POST['user_email'], FILTER_SANITIZE_EMAIL);
    $invoice_no = time();
    $invoice_total = $_SESSION["cart_products"]['total_old'];
    $invoice_net = $_SESSION["cart_products"]['total'];
    $invoice_discount = (integer)$_SESSION["cart_products"]['total_old']-(integer)$_SESSION["cart_products"]['total'];

    /*** insert invoice into DB ***/
    global $wpdb;
    $wpdb->insert('invoices', array(
        'user_email' => $user_email,
        'invoice_no' => $invoice_no,
        'invoice_total' => $invoice_total,
        'invoice_discount' => $invoice_discount,
        'invoice_net' => $invoice_net,
        'invoice_date' => date('Y-m-d'),
    ));
    /*** insert invoice into DB# ***/
    ?>

    <div id="content" class="site-content">
        <h3>Checkout Invoice</h3>
        <table id="invoice_table">
            <tr>
                <th>Invoice #</th>
                <th>Invoice Total</th>
                <th>Invoice Discount</th>
                <th>Invoice Net</th>
                <th>Invoice Date</th>
            </tr>
            <tr>
                <td><?php echo $invoice_no;?></td>
                <td><?php echo $_SESSION["cart_products"]['total_old']?></td>
                <td><?php echo $invoice_discount.'%';?></td>
                <td><?php echo $_SESSION["cart_products"]['total']?></td>
                <td><?php echo date('d-m-Y');?></td>
            </tr>
        </table>

    </div>
    <?php


    $product_codes_unique = array_values(array_unique($_SESSION["product_codes"]));
    foreach($product_codes_unique as $prod_code){
        $qty_sum =0;
        $prod_id =0;
        $prod_list = array_keys(($_SESSION["cart_products"][$prod_code]));
        foreach($prod_list as $prod){
            $qty_sum += (integer)$_SESSION["cart_products"][$prod_code][$prod]['product_qty'];
            $prod_id = $_SESSION["cart_products"][$prod_code][$prod]['product_id'];
        }
        if($prod_id!=0 && $prod_id!='' && $qty_sum!=''){
            $stock_qty = get_field('quantity',$prod_id);
            if(($stock_qty-$qty_sum)>=0){
                //Checkout Done Successfully
                update_field( 'quantity', ($stock_qty-$qty_sum), $prod_id );
                /*unset($_SESSION["cart_products"]);*/
                echo '<script type="text/javascript">';
                echo 'alert("Checkout Done Successfully");';
                echo '</script>';
            }
            else {
                //Invalid quantity
                echo '<script type="text/javascript">';
                echo 'alert("Quantity should be less than or equal stock quantity");';
                echo '</script>';
                die('<div style="color:red;font-size:18px;">To complete checkout, Please enter a valid quantity!</div>');
            }
        }

    }

}

?>
<?php get_footer();?>