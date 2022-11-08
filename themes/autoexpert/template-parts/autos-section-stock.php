<?php
$args = array(
    'post_type'      => 'auto',
    'posts_per_page' => 10,
    'meta_query' => array(
        array(
            'key'     => 'auto_sales',
            'value'   => 0,
        ),
    ),
);
$loop = new WP_Query($args);
?>

<div class="wrapper-container-cars">

    <?php
    if ($loop->have_posts()):
        while ($loop->have_posts()) :$loop->the_post();
            get_template_part('template-parts/auto-cart', null, ['auto' => get_post()]);
        endwhile;
    endif;

    ?>
</div>
