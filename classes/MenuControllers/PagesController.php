<?php
namespace TNC\MenuControllers;

use Carbon\Carbon;
use TNC\Base\OrderStatus;

class PagesController
{
    public static function showStatus($status)
    {
        $statuses = OrderStatus::allClasses();
        $class = $statuses[$status];
        $name = OrderStatus::allNames()[$status];

        $status = "<label class=\"$class\">$name </label>";
        return $status;
    }

    public static function deliveries_today()
    {
        $manager = new OrderDBManager();
        $manager->set_deliveries_today();
        $orders = $manager->get_orders();

        return require_once TNC_SCHEDULE_BASE_DIRECTORY . '/templates/deliveries_today.php';
    }

    public static function deliveries_tomorrow()
    {
        $manager = new OrderDBManager();
        $manager->set_deliveries_tomorrow();
        $orders = $manager->get_orders();

        return require_once TNC_SCHEDULE_BASE_DIRECTORY . '/templates/deliveries_tomorrow.php';
    }

    public static function other_deliveries()
    {
        $manager = new OrderDBManager();
        $manager->set_other_deliveries();
        $orders = $manager->get_orders();

        return require_once TNC_SCHEDULE_BASE_DIRECTORY . '/templates/other_deliveries.php';
    }

    public static function failed_yesterday()
    {
        $manager = new OrderDBManager();
        $manager->set_deliveries_yesterday();
        $orders = $manager->get_orders();

        return require_once TNC_SCHEDULE_BASE_DIRECTORY . '/templates/deliveries_yesterday.php';

    }

    public static function failed_deliveries()
    {
        $manager = new OrderDBManager();
        $manager->set_failed_deliveries();
        $orders = $manager->get_orders();

        return require_once TNC_SCHEDULE_BASE_DIRECTORY . '/templates/failed_deliveries.php';
    }
}

?>
