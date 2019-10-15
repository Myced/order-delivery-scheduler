<?php
namespace TNC\Base;

//import carbon
use Carbon\Carbon;
use TNC\Base\OrderStatus;

class DeliveryScheduleMetaBox
{
    //the key to save the order scheduled delivery date into the database
    private $date_key = "_tnc_delivery_date";

    private $order;

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
        $this->post = $post;

        wp_nonce_field( 'tnc_order_delivery_nonce', 'tnc_delivery_nonce' );

        //now get the delivery date for this order
        $delivery_date = get_post_meta( $post->ID, $this->date_key, true );

        if($delivery_date != false)
        {
            if($delivery_date != '-1')
            {
                //prepare the date difference
                $carbon_start_date = $delivery_date ;

                //show the number of days left for the order to be delivered.
                $now = Carbon::now();
                $end_date = Carbon::createFromFormat('Y-m-d', $carbon_start_date);

                //get the difference in the dates by days
                $difference = $now->diffInDays($end_date, false);

                $this->showMessage($difference);
            }
        }

        ?>

        <br>
        <p>
			<label class="meta-label" for="tnc_delivery_date_field">Delivery Date:</label>

            <input type="text" name="tnc_delivery_value" class="cdatepicker"
                id="id="tnc_delivery_date_field""
                value="<?php if(!empty($delivery_date)) { echo $delivery_date; } ?>"
                placeholder="Enter Date YYYY-mm-dd">

		</p>

        <?php

    }

    public function save_delivery_meta_box($post_id)
    {

        if (! isset($_POST['tnc_delivery_value'])) {
			return $post_id;
		}

		$nonce = $_POST['tnc_delivery_nonce'];
		if (! wp_verify_nonce( $nonce, 'tnc_order_delivery_nonce' )) {
			return $post_id;
		}


		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return $post_id;
		}

		if (! current_user_can( 'edit_post', $post_id ) ) {
			return $post_id;
		}


        //grab the set date and validate it
        if(!isset($_POST['tnc_delivery_value']))
        {
            return $post_id;
        }
        else {
            $scheduled_date = trim(sanitize_text_field( $_POST['tnc_delivery_value'] ));
        }

        //now validate the date
        if(empty($scheduled_date))
        {
            $scheduled_date = '-1'; //this will be easy to mark those without dates.
        }

        //now actualy save the date
        update_post_meta( $post_id, $this->date_key, $scheduled_date );
    }

    private function showMessage($difference)
    {
        if($difference == 0)
        {
            $this->showToday();
        }
        else {
            if($difference > 0)
            {
                //the day is still ahead
                if($difference == 1)
                {
                    $this->showTomorrow();
                }
                else {
                    $this->showInDays($difference);
                }
            }
            else {
                //the scheduled delivery date has alredy passed
                if($difference == -1)
                {
                    $this->showYesterday();
                }
                else {
                    $this->showDaysAgo($difference);
                }
            }
        }

    }

    private function showToday()
    {
        $this->printText("Today");
    }

    private function showTomorrow()
    {
        $this->printText("Tomorrow");
    }

    private function showYesterday()
    {
        $this->printText("Yesterday", true);
    }

    private function showInDays($difference)
    {
        $text = ' in ' . abs($difference) . ' days';

        $this->printText($text);
    }

    private function showDaysAgo($difference)
    {
        $text = abs($difference) . " days ago";

        $this->printText($text, true);
    }

    private function printText($text, $showDeliveryFaild = false)
    {
        ?>
        <p>

            To be delivered
            <strong style="font-size: 17px;"> <?php echo $text; ?> </strong>
            <?php
            if ($this->post->post_status == OrderStatus::COMPLETED) {
                $this->showDelivered();
            }
            else {
                //only show this part if $showDeliveryFaild is true
                if($showDeliveryFaild == true)
                {
                    $this->showFailedDelivery();
                }
            }
             ?>
        </p>
        <?php
    }

    private function showDelivered()
    {
        ?>
        <br>
        <br>
        <strong style="color: #0bb417;">
            <i class="fa fa-check"></i>
            <i class="fa fa-check"></i>

            DELIVERED
        </strong>
        <?php
    }

    private function showFailedDelivery()
    {
        ?>
        <br>
        <br>
        <strong style="color: #f24213;">
            <i class="fa fa-times"></i>
            <i class="fa fa-times"></i>

            DELIVERY FAILED
        </strong>
        <?php
    }
}


 ?>
