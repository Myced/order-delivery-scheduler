<?php
namespace TNC\Base;


class Enqueue
{

    public function register()
    {
        add_action('admin_enqueue_scripts', [$this, 'load_scripts']);
    }

    public function load_scripts()
    {
        //load this script on the order edit page.
        global $post;

        //load the datepicker only on the order details page.
        if(!is_null($post))
        {
            if($post->post_type == "shop_order")
            {
                //only load it on the edit page
                if(isset($_GET['action']) && $_GET['action'] == 'edit')
                {
                    wp_enqueue_style("TNC_PLUGIN" . 'BootstrapCss', TNC_SCHEDULE_ASSETS_URL . 'bootstrap.css' );
                    wp_enqueue_style("TNC_PLUGIN" . 'DatepickerCss', TNC_SCHEDULE_ASSETS_URL . 'datepicker/bootstrap-datepicker.css' );

                    wp_enqueue_script("TNC_PLUGIN" . 'DatepickerJs', TNC_SCHEDULE_ASSETS_URL . 'datepicker/bootstrap-datepicker.js' );

                    wp_enqueue_script("TNC_PLUGIN" . 'yscript', TNC_SCHEDULE_ASSETS_URL . 'myscript.js' );
                }
            }
        }

        //set of pages where the styles will be loaded.
        $pages  = [
            "gt-delivery",
            "gt-delivery_today",
            "gt-delivery_tomorrow",
            "gt-delivery_others",
            "gt-delivery_yesterday",
            "gt-delivery_failed"
        ];

        //enqueue styles now for the admin menu pages
        if(isset($_GET['page']))
        {
            $page = $_GET['page'];

            if(in_array($page, $pages))
            {
                wp_enqueue_style(TNC_SCHEDULE_PLUGIN_BASENAME . 'Bootstrap', TNC_SCHEDULE_ASSETS_URL . 'bootstrap.css' );
                wp_enqueue_style(TNC_SCHEDULE_PLUGIN_BASENAME . 'DataTableCss', TNC_SCHEDULE_ASSETS_URL . 'datatables/dataTables.bootstrap.css' );
                wp_enqueue_style(TNC_SCHEDULE_PLUGIN_BASENAME . 'AdminLTE', TNC_SCHEDULE_ASSETS_URL . 'AdminLTE.css' );

                //load javascripts
                wp_enqueue_script(TNC_SCHEDULE_PLUGIN_BASENAME . 'DataTableJs', TNC_SCHEDULE_ASSETS_URL . 'datatables/jquery.dataTables.js' );
                wp_enqueue_script(TNC_SCHEDULE_PLUGIN_BASENAME . 'DatepickerBsJs', TNC_SCHEDULE_ASSETS_URL . 'datatables/dataTables.bootstrap.js' );
                wp_enqueue_script("TNC_PLUGIN" . 'yscript', TNC_SCHEDULE_ASSETS_URL . 'myscript.js' );
            }
        }


    }
}


 ?>
