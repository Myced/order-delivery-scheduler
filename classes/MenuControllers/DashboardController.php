<?php
namespace TNC\MenuControllers;


use TNC\MenuControllers\OrderDBManager;

class DashboardController
{

    public static function show_report()
    {
        $manager = new OrderDBManager();
        $manager->set_deliveries_today();
        $orders = $manager->get_orders();

        return require_once TNC_SCHEDULE_BASE_DIRECTORY . '/templates/dashboard.php';
    }
}


 ?>
