<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Automotive Centre
 */
?>

<footer role="contentinfo">
    <div id="footer" class="copyright-wrapper">
        <div class="container">
            <?php
                $count = 0;
                
                if ( is_active_sidebar( 'footer-1' ) ) {
                    $count++;
                }
                if ( is_active_sidebar( 'footer-2' ) ) {
                    $count++;
                }
                if ( is_active_sidebar( 'footer-3' ) ) {
                    $count++;
                }
                if ( is_active_sidebar( 'footer-4' ) ) {
                    $count++;
                }
                // $count == 0 none
                if ( $count == 1 ) {
                    $colmd = 'col-md-12 col-sm-12';
                } elseif ( $count == 2 ) {
                    $colmd = 'col-md-6 col-sm-6';
                } elseif ( $count == 3 ) {
                    $colmd = 'col-md-4 col-sm-4';
                } else {
                    $colmd = 'col-md-3 col-sm-3';
                }
            ?>
            <div class="row">
                <div class="<?php if ( !is_active_sidebar( 'footer-1' ) ){ echo "footer_hide"; }else{ echo "$colmd"; } ?> col-xs-12 footer-block">
                  <?php dynamic_sidebar('footer-1'); ?>
                </div>
                <div class="<?php if ( is_active_sidebar( 'footer-2' ) ){ echo "$colmd"; }else{ echo "footer_hide"; } ?> col-xs-12 footer-block">
                    <?php dynamic_sidebar('footer-2'); ?>
                </div>
                <div class="<?php if ( is_active_sidebar( 'footer-3' ) ){ echo "$colmd"; }else{ echo "footer_hide"; } ?> col-xs-12 col-xs-12 footer-block">
                    <?php dynamic_sidebar('footer-3'); ?>
                </div>
                <div class="<?php if ( !is_active_sidebar( 'footer-4' ) ){ echo "footer_hide"; }else{ echo "$colmd"; } ?> col-xs-12 footer-block">
                    <?php dynamic_sidebar('footer-4'); ?>
                </div>
            </div>
        </div>
    </div>
    <div id="footer-2">
      	<div class="copyright container">
            <p><?php automotive_centre_credit(); ?> <?php echo esc_html(get_theme_mod('automotive_centre_footer_text',__('By VWThemes','automotive-centre'))); ?></p>
            <?php if( get_theme_mod( 'automotive_centre_hide_show_scroll',true) != '' || get_theme_mod( 'automotive_centre_resp_scroll_top_hide_show',true) != '') { ?>
                <?php $automotive_centre_theme_lay = get_theme_mod( 'automotive_centre_scroll_top_alignment','Right');
                if($automotive_centre_theme_lay == 'Left'){ ?>
                    <a href="#" class="scrollup left"><i class="<?php echo esc_attr(get_theme_mod('automotive_centre_scroll_to_top_icon','fas fa-long-arrow-alt-up')); ?>"></i><span class="screen-reader-text"><?php esc_html_e( 'Scroll Up', 'automotive-centre' ); ?></span></a>
                <?php }else if($automotive_centre_theme_lay == 'Center'){ ?>
                    <a href="#" class="scrollup center"><i class="<?php echo esc_attr(get_theme_mod('automotive_centre_scroll_to_top_icon','fas fa-long-arrow-alt-up')); ?>"></i><span class="screen-reader-text"><?php esc_html_e( 'Scroll Up', 'automotive-centre' ); ?></span></a>
                <?php }else{ ?>
                    <a href="#" class="scrollup"><i class="<?php echo esc_attr(get_theme_mod('automotive_centre_scroll_to_top_icon','fas fa-long-arrow-alt-up')); ?>"></i><span class="screen-reader-text"><?php esc_html_e( 'Scroll Up', 'automotive-centre' ); ?></span></a>
                <?php }?>
            <?php }?>
      	</div>
      	<div class="clear"></div>
    </div>
</footer>

    <?php wp_footer(); ?>

    </body>
</html>