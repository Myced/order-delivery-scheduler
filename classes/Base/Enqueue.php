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
                    wp_enqueue_style("TNC_PLUGIN" . 'DatepickerCss', TNC_SCHEDULE_ASSETS_URL . 'datepicker/bootstrap-datepicker.css' );

                    wp_enqueue_script("TNC_PLUGIN" . 'DatepickerJs', TNC_SCHEDULE_ASSETS_URL . 'datepicker/bootstrap-datepicker.js' );

                    wp_enqueue_script("TNC_PLUGIN" . 'yscript', TNC_SCHEDULE_ASSETS_URL . 'myscript.js' );
                }
            }
        }


    }
}


 ?>
