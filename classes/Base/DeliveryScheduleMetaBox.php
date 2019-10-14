<?php
namespace TNC\Base;


class DeliveryScheduleMetaBox
{
    public function register()
    {
        add_action( 'add_meta_boxes', [$this, 'add_delivery_meta_box'] );
        add_action( 'save_post', [$this, 'save_delivery_meta_box']);
    }

    public function add_delivery_meta_box()
    {
        add_meta_box( 'tnc_delivery_date', __('Delivery Date','woocommerce'),
            [$this,'add_delivery_box_fields'], 'shop_order', 'side', 'core' );
    }

    public function add_delivery_box_fields()
    {
        //get the current order
        global $post;

        echo '<input type="hidden" name="tnc_order_delivery_nonce" value="' . wp_create_nonce() . '">';

        ?>

        <p>
			<label class="meta-label" for="tnc_delivery_date_field">Delivery Date:</label>

            <input type="text" name="tnc_delivery_value" class="datepicker"
                id="id="tnc_delivery_date_field"" value=""
                placeholder="Enter delivery date">

		</p>

        <?php

    }
}


 ?>
