<?php
namespace TNC\MenuControllers;

use Carbon\Carbon;

class OrderDBManager
{

    public $wpdb;

    private $date_format = "Y-m-d";

    private $date_key = "_tnc_delivery_date";

    private $conditional_sign = '=';
    private $delivery_date;

    private $post_date_field;



    function __construct()
    {
        //initialise the application
        global $wpdb;

        $this->wpdb = $wpdb;

        $this->init_post_date_field();
        $this->set_order_statuses();
    }


    public function init_post_date_field()
    {
        //irrelevant. we don't need this at all.
        $this->post_date_field = "post_date";
    }

    public function set_deliveries_today()
    {
        $now = Carbon::now();

        $this->delivery_date = $now->format($this->date_format);

    }

    public function set_deliveries_tomorrow()
    {
        $now = Carbon::tomorrow();

        $this->delivery_date = $now->format($this->date_format);

    }

    public function set_other_deliveries()
    {
        $now = Carbon::tomorrow();
        $this->conditional_sign = '>';

        $this->delivery_date = $now->format($this->date_format);

    }

    public function set_deliveries_yesterday()
    {
        $now = Carbon::yesterday();

        $this->delivery_date = $now->format($this->date_format);

    }

    public function set_failed_deliveries()
    {
        $now = Carbon::yesterday();
        $this->conditional_sign = '<';

        $this->delivery_date = $now->format($this->date_format);

    }

    public function get_orders()
    {
        return $this->wpdb->get_results($this->getOrdersQuery());
    }

    private function getOrdersQuery()
    {
        $sql = "SELECT
                    *
                FROM
                (
                    SELECT
                                wp_posts.ID,
                                wp_posts.post_title,
                                wp_posts.post_status,
                                wp_posts.post_date,
                            MAX(CASE WHEN (wp_postmeta.meta_key = '_order_total')
                                THEN wp_postmeta.meta_value ELSE NULL END) AS total,
                            MAX(CASE WHEN (wp_postmeta.meta_key = '_order_shipping')
                                THEN wp_postmeta.meta_value ELSE NULL END) AS shipping,
                            MAX(CASE WHEN (wp_postmeta.meta_key = '_billing_first_name')
                                THEN wp_postmeta.meta_value ELSE NULL END) AS first_name,
                            MAX(CASE WHEN (wp_postmeta.meta_key = '_billing_last_name')
                                THEN wp_postmeta.meta_value ELSE NULL END) AS last_name,
                            MAX(CASE WHEN (wp_postmeta.meta_key = '_billing_phone')
                                THEN wp_postmeta.meta_value ELSE NULL END) AS tel,
                            MAX(CASE WHEN (wp_postmeta.meta_key = '_gt_order_data')
                                THEN wp_postmeta.meta_value ELSE NULL END) AS order_data,
                            MAX(CASE WHEN (wp_postmeta.meta_key = '$this->date_key')
                                THEN wp_postmeta.meta_value ELSE NULL END) AS delivery_date

                            FROM `wp_posts`

                            LEFT JOIN wp_postmeta
                                    ON
                                        (
                                            wp_posts.ID = wp_postmeta.post_id
                                        )
                            WHERE
                                wp_posts.post_type = 'shop_order'
                                AND wp_posts.post_status NOT IN ('auto-draft', 'trash', 'wc-cancelled', 'wc-failed')

                            GROUP BY wp_posts.ID
                            ORDER BY wp_posts.ID DESC
                )
                orders
                WHERE
                    delivery_date $this->conditional_sign '$this->delivery_date'
                    AND delivery_date <> '-1'

                ORDER BY
                    delivery_date ASC


        ";

        return $sql;
    }

    private function set_order_statuses()
    {
        if(isset($_GET['statuses']))
        {
            $statuses = $_GET['statuses'];
            $in = '(';

            //put in all the statuses here.
            $i = 0;
            foreach($statuses as $status)
            {
                $in .= " '$status'";

                if($i < count($statuses) -1 )
                {
                    $in .= ', ';
                }

                $i++;
            }

            $in .= ')';

            $this->order_statuses = $in;
        }
    }
}

 ?>
