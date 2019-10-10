<?php
namespace App\Base;


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

        if(!is_null($post))
        {
            if($post->post_type == "shop_order")
            {
                //only load it on the edit page
                if(isset($_GET['action']) && $_GET['action'] == 'edit')
                {
                    wp_enqueue_script("GT_EMEI" . '-myscript', GT_EMEI_ASSETS_URL . 'gt-emei.js' );
                }
            }
        }


    }
}


 ?>
