<?php
session_start();
/*** include wordpress ***/
require('../../../../wp-blog-header.php');
get_header();
/*** include wordpress! ***/

//add product to session or create new one


if (isset($_POST["action"]) && $_POST["action"] == 'checkout'){
    $product_codes_unique = array_values(array_unique($_SESSION["product_codes"]));
    foreach($product_codes_unique as $prod_code){
        $qty_sum =0;
        $prod_id =0;
        $prod_list = array_keys(($_SESSION["cart_products"][$prod_code]));
        foreach($prod_list as $prod){
            $qty_sum += (integer)$_SESSION["cart_products"][$prod_code][$prod]['product_qty'];
            $prod_id = $_SESSION["cart_products"][$prod_code][$prod]['product_id'];
        }
        $stock_qty = get_field('quantity',$prod_id);
        if($prod_id!=0 && $prod_id!='' && $qty_sum!=''){
            if(($stock_qty-$qty_sum)>=0){
                update_field( 'quantity', ($stock_qty-$qty_sum), $prod_id );
                //Checkout Done Successfully
            }
            else {
                //Invalid quantity
            }
        }

    }
    die;
}
elseif (isset($_POST["type"]) && $_POST["type"] == 'add' && $_POST["product_qty"] > 0) {
    $i = 0;
    foreach ($_POST as $key => $value) { //add all post vars to new_product array
        $new_product[$key] = filter_var($value, FILTER_SANITIZE_STRING);
        if (strpos($key, '_req_key')) {
            $new_product['attributes'][$i] = $value;
            $i++;
        }
    }
    //remove unecessary vars
    unset($new_product['type']);
    unset($new_product['return_url']);

    $product = get_post($new_product['product_id']);

    //fetch product name, price from db and add to new_product array
    $new_product["product_name"] = $product->post_name;
    $new_product["product_price"] = get_field('price', $product->ID);
    //get product attributes and use them as an index
    $attr_index = implode(',', $new_product['attributes']);


    if (isset($_SESSION["cart_products"])) {  //if session var already exist
        if (isset($_SESSION["cart_products"][$new_product['product_code']][$attr_index])) //check item exist in products array
        {
            unset($_SESSION["cart_products"][$new_product['product_code']][$attr_index]); //unset old array item
        }
    }
    if($new_product!='' && isset($new_product) && is_array($new_product))
        $_SESSION["cart_products"][$new_product['product_code']][$attr_index] = $new_product; //update or create product session with new item}


    /*** create one array containing cart products codes and another one containing the corresponding attributes***/
    //these arrays are used when removing products from cart and get the items count
    $x = 0;
    $tmp_internal_keys =array();
    $tmp_arr_keys = array_keys($_SESSION["cart_products"]);
    unset($_SESSION["product_codes"]);
    unset($_SESSION["product_attrs"]);
    foreach($tmp_arr_keys as $tmp){
        $tmp_inside_keys = array_keys($_SESSION["cart_products"][$tmp]);
        foreach($tmp_inside_keys as $tmp_inside){
            $_SESSION["product_codes"][] = $tmp;
            $_SESSION["product_attrs"][] = $tmp_inside;
            $x++;
        }
    }
    /*** create one array containing cart products codes and another one containing the corresponding attributes#***/

}

//update or remove items 
if (isset($_POST["product_qty"]) || isset($_POST["remove_code"])) {
    //update item quantity in product session
    if (isset($_POST["product_qty"]) && is_array($_POST["product_qty"])) {
        for($j=0;$j<count($_SESSION["product_codes"]);$j++){
            $_SESSION["cart_products"][$_SESSION["product_codes"][$j]][$_SESSION["product_attrs"][$j]]["product_qty"] = $_POST["product_qty"][$_SESSION["product_codes"][$j]][$_SESSION["product_attrs"][$j]];
        }
    }
    //remove an item from product session
    if (isset($_POST["remove_code"]) && is_array($_POST["remove_code"])) {
        $cart_row_idx = explode(',',$_POST["cart_row_idx"]);
        $k=0;
        foreach ($_POST["remove_code"] as $key => $value) {
            $tmp = explode('*',$value);
            $product_code = $tmp[0];
            $product_attr = $tmp[1];
            unset($_SESSION["cart_products"][$product_code][$product_attr]);
            unset($_SESSION["product_codes"][$cart_row_idx[$k]]);
            unset($_SESSION["product_attrs"][$cart_row_idx[$k]]);
            $k++;
        }
    }
}
//remove empty cart session array items
unset($_SESSION["cart_products"]['']);
//reindex removed session array items
$product_codes_tmp = ($_SESSION["product_codes"]);
$_SESSION["product_codes"] = array_values($product_codes_tmp);
$product_attrs_tmp = array_unique($_SESSION["product_attrs"]);
$_SESSION["product_attrs"] = array_values($product_attrs_tmp);
die;
//back to return url
$return_url = (isset($_POST["return_url"])) ? urldecode($_POST["return_url"]) : ''; //return url
echo '<script type="text/javascript">';
echo 'window.location = "' . $return_url . '"';
echo '</script>';
?>