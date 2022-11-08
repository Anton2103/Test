<?php

$auto_cart = $args['auto'];
//$chefs_recipe = $args['chefs'];
if($auto_cart ){
$post_id = $auto_cart->ID;
}else{
$post_id = get_the_ID();
}
$brand = get_field('auto_brand',$post_id);
$model = get_field('auto_model',$post_id);
$img = get_field('auto_image',$post_id);
$year = get_field('auto_year_issue',$post_id);
$engine = get_field('auto_engine',$post_id);
$transmission = get_field('auto_transmission',$post_id);
$mileage = get_field('auto_mileage',$post_id);
$price = get_field('auto_price',$post_id);
$drive = get_field('auto_drive',$post_id);
$sales = get_field('auto_sales',$post_id);
$options = get_field('auto_options',$post_id);
?>

<div class="cart-auto">
    <div class="cart-auto-wrapper">
        <div class="cart-auto-image">
            <img class="auto-img" src="<?php echo esc_url($img['url']); ?>" alt="<?php echo esc_attr($img['alt']); ?>" />
        </div>
        <div class="cart-auto-content">
            <ul>
                <h3 class=""><span><?php echo $brand, $model; ?></span></h3>
                <?php
                if( get_field('auto_sales') ) {
                    ?><h3 class="">ПРОДАНО</h3><?php
                }?>
                <li class=""> Рік випуску: <span style="font-weight:bold"> <?php echo $year; ?> </span></li>
                <li class=""> Двигун: <span style="font-weight:bold"> <?php echo $engine; ?> </span></li>
                <li class=""> Коробка передач: <span style="font-weight:bold"> <?php echo $transmission; ?> </span></li>
                <li class=""> Привід: <span style="font-weight:bold"> <?php echo $drive; ?> </span></li>
                <li class=""> Пробіг: <span style="font-weight:bold"> <?php echo $mileage; ?> </span> км</li>
                <li class=""> Ціна: <span style="font-weight:bold"> <?php echo $price; ?> </span> $</li>
            </ul>
        </div>
        <div class="cart-auto-options">
            <h3>Комплектація авто</h3>
            <p><?php the_field('auto_options'); ?></p>
        </div>
    </div>
</div>
