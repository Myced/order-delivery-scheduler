<?php

namespace App\Base;


class Activation
{
    public static function activate()
    {
        flush_rewrite_rules();
    }

    public static function deactivate()
    {
        flush_rewrite_rules();
    }
}

?>
