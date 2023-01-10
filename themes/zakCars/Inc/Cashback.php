<?php

namespace Inc;

use Automattic\Jetpack\VideoPress\AJAX;

class Cashback
{
    /**
     * Holds class single instance
     * @var null
     */
    private static ?Cashback $_instance = null;

    /**
     * Get instance
     * @return Cashback|null
     */
    public static function getInstance(): ?Cashback
    {
        if (null == static::$_instance) {
            static::$_instance = new self();
        }

        return static::$_instance;
    }

    /**
     * General constructor. Theme default options
     */
    private function __construct()
    {
        add_filter('woocommerce_account_menu_items', [$this, 'walletLink'], 40);
        add_action('init', [$this, 'addEndpoint']);
        add_action('woocommerce_account_my-wallet_endpoint', [$this, 'walletEndpointContent']);
        add_action('woocommerce_order_status_changed', [$this, 'updateMetaCashback'], 10, 3);
        add_action('wp_ajax_apply_cashback', [$this, 'applyCashback']);
        add_action('wp_ajax_nopriv_apply_cashback', [$this, 'applyCashback']);
        add_action('woocommerce_cart_calculate_fees', [$this, 'wooDiscountTotal'], 25);
        add_action('woocommerce_cart_totals_after_order_total', [$this, 'displaysCashback'], 10);
        add_action('woocommerce_after_cart_table', [$this, 'displayApplyDiscount'], 10);
        add_action('woocommerce_new_order', [$this, 'reserveFee'], 10);
        add_action('woocommerce_after_calculate_totals', [$this, 'calculateDiscount'], 10);
    }

    // create new menu item 'wallet' in my account
    public function walletLink($menu_links)
    {
        $menu_links = array_slice($menu_links, 0, 5, true)
            + array('my-wallet' => 'wallet')
            + array_slice($menu_links, 5, null, true);

        return $menu_links;
    }

    public function addEndpoint()
    {
        add_rewrite_endpoint('my-wallet', EP_PAGES);
    }

    public function walletEndpointContent()
    {
        $user_id = get_current_user_id();
        ?>
        <h3>ГАМАНЕЦЬ</h3>
        <p> Cashback: <?php
            echo wc_price(get_user_meta($user_id, 'wallet', true)); ?></p>
        <?php
    }

    //create and update user meta 'wallet'
    public function updateMetaCashback($order_id, $old_status, $new_status)
    {
        $order = wc_get_order($order_id);
        $total = $order->get_total();
        $sum_cashback = $this->getCashback($total);
        $user_id = $order->get_user_id();
        $wallet = get_user_meta($user_id, 'wallet', true);


        foreach ($order->get_items('fee') as $item_id => $item_fee) {
            $discount = abs($item_fee->get_total());
        }

        if ($new_status == 'completed') {
            if ($sum_cashback['cashback'] != 0) {
                if (empty($wallet)) {
                    $wallet = 0;
                }
                $wallet += $sum_cashback['cashback'];
            }
        }

        if ($new_status == 'cancelled' || $new_status == 'failed') {
            $wallet += $discount;
        }

        update_user_meta($user_id, 'wallet', $wallet);
    }

    public function reserveFee($order_id)
    {
        $order = wc_get_order($order_id);
        $user_id = $order->get_user_id();
        $discount = 0;

        if (WC()->session) {
            $discount = WC()->session->get('use_cashback', 0);
        }

        $wallet = get_user_meta($user_id, 'wallet', true);
        $wallet -= $discount;
        update_user_meta($user_id, 'wallet', $wallet);
    }

    //calculates cashback
    public function getCashback($total)
    {
        $cashback_percent = get_field('cashback_percent', 'option');
        $min_amount = get_field('min_total_cashback', 'option');
        if ($total < $min_amount) {
            $cashback = 0;
        } else {
            $cashback = $total * $cashback_percent / 100;
        }

        return ['cashback' => $cashback, 'min_amount' => $min_amount];
    }

    //is the total enough to get cashback?
    public function willBeCashback()
    {
        $totals = WC()->cart->get_totals();
        $sum_cashback = $this->getCashback($totals['total']);
        if ($sum_cashback['cashback'] == 0) {
            echo __('minimum order amount is ', 'zakCars'), wc_price($sum_cashback['min_amount']), __(
                ' to get cashback',
                'zakCars'
            );
        } else {
            $value = '<strong>' . wc_price($sum_cashback['cashback']) . '</strong> ';
            echo apply_filters('woocommerce_cart_totals_order_total_html', $value);
        }
    }

    // displays Cashback on the page cart
    public function displaysCashback()
    {
        $data = WC()->cart->get_fee_total();
        if ($data == 0) {
            ?>
            <tr class="cashback">
                <th><?php
                    esc_html_e('Сashback', 'woocommerce'); ?></th>
                <td data-title="
                <?php
                esc_attr_e('Сashback', 'woocommerce'); ?>">
                    <?php
                    $this->willBeCashback(); ?>
                </td>
            </tr>
            <?php
        }
    }

    public function calculateDiscount()
    {
        $checked = isset($_POST['discount']);
        $current_discount = WC()->session->get('use_cashback', 0);

        if ($checked) {
            $totals = WC()->cart->get_totals()['cart_contents_total'];
            $half_totals = $totals * 0.5;
            $user_id = get_current_user_id();
            $cashback = get_user_meta($user_id, 'wallet', true);

            if ($cashback > $half_totals) {
                $discount = $half_totals;
            };
            if ($cashback <= $half_totals) {
                $discount = $cashback;
            };

            if ($discount !== $current_discount) {
                WC()->session->set('use_cashback', $discount);
                WC()->cart->calculate_totals();
            }
        }
    }

    public function wooDiscountTotal()
    {
        $checked = isset($_POST['discount']);
        $discount = WC()->session->get('use_cashback', 0);
        if (!empty($_POST['update_cart']) && !$checked) {
            $discount = 0;
            WC()->session->set('use_cashback', null);
        }

        if (!empty($discount)) {
            WC()->cart->add_fee('З Ваших накопичень', -$discount, true, '');
        }
    }

    public function displayApplyDiscount()
    {
        $discount = WC()->session->get('use_cashback', 0);
        $user_id = get_current_user_id();
        $cashback = get_user_meta($user_id, 'wallet', true);

        if ($cashback > 0) {
            ?>
            <p>Ви можете використати свої накопичення</p>
            <div>
                <label>Використати </label>
                <input type="checkbox" name="discount" class="in-cb" id="add-cb" <?php checked($discount > 0); ?>>
                <div class="out-block out-cb"></div>
            </div>
            <?php
        }
    }
}





