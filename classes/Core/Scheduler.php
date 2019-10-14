<?php
namespace TNC\Core;


class Scheduler
{
    public static function instantiate($class)
    {
        return new $class;
    }

    public static function get_services()
    {
        return [
            \TNC\Base\Enqueue::class,
            \TNC\Base\AdminMenu::class,
            \TNC\Base\DeliveryScheduleMetaBox::class
        ];
    }


    public static function register_services()
    {

        foreach(self::get_services() as $class)
        {
            $instance = self::instantiate($class); //make an instance of the class

            if(method_exists($instance, 'register'))
            {
                $instance->register();
            }
        }
    }
}


?>
