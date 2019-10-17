<?php
namespace TNC\MenuControllers;


class DashboardController
{

    public function show_report()
    {
        return require_once TNC_SCHEDULE_BASE_DIRECTORY . '/templates/dashbord.php';
    }
}


 ?>
