<?php
namespace App\Base;

class EMEIMetaBox
{
    protected $emei_key_1 = "_gt_emei_number_1";
    protected $emei_key_2 = "_gt_emei_number_2";

    protected $products = [];

    protected $cat_id;

    public function __construct()
    {
        //set up the category id that the products that have emei
        //belong to

        //set this to be static for now..
        // TODO: Make this setting configurable.
        if($_SERVER['HTTP_HOST'] == 'localhost')
        {
            $this->cat_id = 31;
        }
        else {
            $this->cat_id = 1387; //the id for telephone et tablet online.
        }

    }

    private function set_product_ids()
    {
            $term_ids  = get_term_children( $this->cat_id, 'product_cat' );

            $term_ids[]  = $this->cat_id;
            $product_ids = get_objects_in_term( $term_ids, 'product_cat' );


            //make the array unique
            $this->products = $product_ids;

    }

    public function register()
    {
        add_action( 'add_meta_boxes', [$this, 'add_emei_box'] );
        add_action( 'save_post', [$this, 'save_emei_meta_box']);

        add_action('wpo_wcpdf_before_item_meta', [$this, 'show_item_emei_number'], 9, 1);
    }

    public function add_emei_box()
    {
        $this->set_product_ids();

        global $post;
        $box_id = "gt_order_emei";
        $title = "EMEI for Telephones";
        $callback = [$this, 'show_emei_meta_box'];
        $screen = "shop_order";
        $context = "normal";
        $callback_args = null;
        $priority = "high";

        if($post->post_type == "shop_order")
        {
            add_meta_box(
                $box_id, $title, $callback, $screen,
                $context, $priority, $callback_args
            );
        }

    }

    public function show_emei_meta_box()
    {
        global $post;
        $order = wc_get_order($post->ID);

        wp_nonce_field( 'gt_emei_meta', 'gt_emei_nonce' );

        //foreach of order items, show the cost price box.
        foreach ($order->get_items() as $key => $item)
        {
            //if the product is not in product ids, then
            // don't show space for emei
            if(!in_array($item->get_product_id(), $this->products))
            {
                continue;
            }

            $emei1 = wc_get_order_item_meta( $key, $this->emei_key_1, true );
            $emei2 = wc_get_order_item_meta( $key, $this->emei_key_2, true );
            
            ?>
            <p>
    			<label class="meta-label" for="gt_plugin_zone_price">
                    EMEI Number 1
                    (<?php echo $item->get_name(); ?>)
                </label>
                <input type="hidden" name="gt_product_id[]"
                    value="<?php echo $item->get_product_id(); ?>">
                <input type="hidden" name="gt_meta_id[]"
                    value="<?php echo $key; ?>">

    			<input type="text" placeholder="Product EMEI Number"
                    name="gt_emei_number_1[]" class="widefat"
                    value="<?php echo $emei1; ?>">
    		</p>

            <p>
    			<label class="meta-label" for="gt_plugin_zone_price">
                    EMEI Number 2
                    (<?php echo $item->get_name(); ?>)
                </label>

    			<input type="text" placeholder="Product EMEI Number"
                    name="gt_emei_number_2[]" class="widefat"
                    value="<?php echo $emei2; ?>">
    		</p>

            <br><br>
            <?php
        }
    }

    public function save_emei_meta_box($post_id)
    {
        if (! isset($_POST['gt_emei_nonce'])) {

			return $post_id;
		}

		$nonce = $_POST['gt_emei_nonce'];
		if (! wp_verify_nonce( $nonce, 'gt_emei_meta' )) {

			return $post_id;
		}

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return $post_id;
		}

		if (! current_user_can( 'edit_post', $post_id ) ) {
			return $post_id;
		}

        if(isset($_POST['gt_emei_number_1']))
        {
            $limit = count($_POST['gt_emei_number_1']);
        }
        else {
            $limit = 0;
        }




        for($i = 0; $i < $limit; $i++)
        {
            $product_id = $_POST['gt_product_id'][$i];

            $term_id = $_POST['gt_meta_id'][$i];

            $emei_number_1 = $_POST['gt_emei_number_1'][$i];
            $emei_number_2 = $_POST['gt_emei_number_2'][$i];


            if($emei_number_1 == "" || $emei_number_1 == " ")
            {
                $emei_number_1 = "";
            }

            //only save the EMEI If it is not empty
            if(!empty($emei_number_1))
            {
                //check if the item has emei number meta.
                //save the first emei number;
                if(wc_get_order_item_meta($term_id, $this->emei_key_1, true) == "")
                {
                    //the meta does not exist. so insert itn
                    wc_add_order_item_meta($term_id, $this->emei_key_1, $emei_number_1);
                }
                else {
                    wc_update_order_item_meta($term_id, $this->emei_key_1, $emei_number_1);
                }
            }


            if(!empty($emei_number_2))
            {
                ///save the second emei number
                if(wc_get_order_item_meta($term_id, $this->emei_key_2, true) == "")
                {
                    //the meta does not exist. so insert itn
                    wc_add_order_item_meta($term_id, $this->emei_key_2, $emei_number_2);
                }
                else {
                    wc_update_order_item_meta($term_id, $this->emei_key_2, $emei_number_2);
                }
            }

        }

    }

    private function get_money($money)
    {
        $regex = '/[\s\,\.\-]/';
        if(preg_match($regex, $money))
        {
            $filter = preg_filter($regex, '', $money);
        }
        else
        {
            $filter = $money;
        }

        return $filter;
    }
}

?>
