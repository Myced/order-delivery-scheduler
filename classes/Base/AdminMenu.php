<?php
namespace TNC\Base;

use TNC\MenuControllers\PagesController;
use TNC\MenuControllers\DashboardController;

class AdminMenu
{
    public function register()
    {
        add_action('admin_menu', [$this, 'add_menu_page']);
    }

    public function add_menu_page()
    {
        $this->addMenu();
        $this->addSubMenu($this->getSubMenus());

    }

    private function addMenu()
    {
        $page_title = "Delivery Scheduler";
        $menu_title = "Deliveries";
        $capability = "manage_categories";
        $menu_slug = "gt-delivery";
        $function = [$this, 'mainMenuCallback'];
        $icon64 = $this->getBase64Icon();
        // $icon = "data:image/svg+xml;base64," . $icon64;
        $icon = "dashicons-buddicons-replies";
        $position = null;

        add_menu_page
            (
                $page_title, $menu_title, $capability,
                $menu_slug, $function, $icon, $position
            );
    }

    private function addSubMenu($pages)
    {
        foreach($pages as $page)
        {
            add_submenu_page(
                $page['parent_slug'], $page['title'],
                $page['menu_title'], $page['capability'],
                $page['menu_slug'], $page['function']
            );
        }
    }

    public function mainMenuCallback()
    {
        echo 'this is the mneu page';
        return ;
    }

    private function getSubMenus()
    {
        $parent_slug = "gt-delivery";
        $capability = "manage_categories";

        $pages = [
            [
                'parent_slug' => $parent_slug,
                'title' => "Deliveries Today",
                'menu_title' => 'Deliveries Today',
                'capability' => $capability,
                'menu_slug' => 'gt-delivery_today',
                'function' => [PagesController::class, 'deliveries_today']
            ],
            [
                'parent_slug' => $parent_slug,
                'title' => "Deliveries Tomorrow",
                'menu_title' => 'Deliveries Tomorrow',
                'capability' => $capability,
                'menu_slug' => 'gt-delivery_tomorrow',
                'function' => [PagesController::class, 'deliveries_tomorrow']
            ],
            [
                'parent_slug' => $parent_slug,
                'title' => "Other Deliveries",
                'menu_title' => 'Other Deliveries',
                'capability' => $capability,
                'menu_slug' => 'gt-delivery_others',
                'function' => [PagesController::class, 'other_deliveries']
            ],
            [
                'parent_slug' => $parent_slug,
                'title' => "Failed Yesterday",
                'menu_title' => 'Failed Yesterday',
                'capability' => $capability,
                'menu_slug' => 'gt-delivery_yesterday',
                'function' => [PagesController::class, 'failed_yesterday']
            ],
            [
                'parent_slug' => $parent_slug,
                'title' => "All Failed Deliveries",
                'menu_title' => 'Failed Deliveries',
                'capability' => $capability,
                'menu_slug' => 'gt-delivery_failed',
                'function' => [PagesController::class, 'failed_deliveries']
            ]

        ];

        return $pages;
    }

    private function getBase64Icon()
    {
        return "PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pg0KPCEtLSBHZW5lcmF0b3I6IEFkb2JlIElsbHVzdHJhdG9yIDE5LjAuMCwgU1ZHIEV4cG9ydCBQbHVnLUluIC4gU1ZHIFZlcnNpb246IDYuMDAgQnVpbGQgMCkgIC0tPg0KPHN2ZyB2ZXJzaW9uPSIxLjEiIGlkPSJMYXllcl8xIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIiB4PSIwcHgiIHk9IjBweCINCgkgdmlld0JveD0iMCAwIDUxMiA1MTIiIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDUxMiA1MTI7IiB4bWw6c3BhY2U9InByZXNlcnZlIj4NCjxnPg0KCTxnPg0KCQk8cGF0aCBkPSJNNTA5LjQ3MywyOTQuMzU4bC01OS4zOTEtNjcuODAyYy0xLjkzNy0yLjIxLTQuNzMzLTMuNDc5LTcuNjcyLTMuNDc5aC00OS40NTV2LTQxLjg3Mg0KCQkJYzAtNS42MzMtNC41NjctMTAuMTk5LTEwLjE5OS0xMC4xOTlIMjU0LjY4NmMtMy40MTktNDIuNDM1LTM5LjAxOS03NS45MjctODIuMzItNzUuOTI3Yy00NS41NTQsMC04Mi42MTQsMzcuMDYtODIuNjE0LDgyLjYxNA0KCQkJYzAsNDIuMDEsMzEuNTI2LDc2Ljc3LDcyLjE1Nyw4MS45Mjh2ODcuOTU1aC01OS4wNDVjLTUuNjMzLDAtMTAuMTk5LDQuNTY2LTEwLjE5OSwxMC4xOTljMCw1LjYzMyw0LjU2NiwxMC4xOTksMTAuMTk5LDEwLjE5OQ0KCQkJaDU5LjA0NXYxMC4zNjVjMCw1LjYzMyw0LjU2NiwxMC4xOTksMTAuMTk5LDEwLjE5OWgyMS4yODljNC40ODUsMTYuMzM5LDE5LjQ1OSwyOC4zODIsMzcuMjAzLDI4LjM4Mg0KCQkJYzE3Ljc0NCwwLDMyLjcxOC0xMi4wNDMsMzcuMjA0LTI4LjM4MmgxMzYuMDg4djBjNC40ODUsMTYuMzM5LDE5LjQ1OSwyOC4zODIsMzcuMjAzLDI4LjM4MmMxNy43NDQsMCwzMi43MTgtMTIuMDQzLDM3LjIwNC0yOC4zODINCgkJCWgyMy41MDJjNS42MzIsMCwxMC4xOTktNC41NjYsMTAuMTk5LTEwLjE5OXYtNzcuMjYxQzUxMiwyOTguNjA2LDUxMS4xMDEsMjk2LjIxOCw1MDkuNDczLDI5NC4zNTh6IE0xMTAuMTUxLDE3Ny42OTMNCgkJCWMwLTM0LjMwNiwyNy45MDktNjIuMjE1LDYyLjIxNS02Mi4yMTVjMzQuMzA2LDAsNjIuMjE1LDI3LjkwOSw2Mi4yMTUsNjIuMjE1cy0yNy45MDksNjIuMjE1LTYyLjIxNSw2Mi4yMTUNCgkJCUMxMzguMDYsMjM5LjkwOCwxMTAuMTUxLDIxMS45OTksMTEwLjE1MSwxNzcuNjkzeiBNMjMwLjYsMzk2LjUyM2MtMTAuMDI2LDAtMTguMTgyLTguMTU3LTE4LjE4Mi0xOC4xODMNCgkJCXM4LjE1Ni0xOC4xODMsMTguMTgyLTE4LjE4M2MxMC4wMjcsMCwxOC4xODMsOC4xNTcsMTguMTgzLDE4LjE4M1MyNDAuNjI2LDM5Ni41MjMsMjMwLjYsMzk2LjUyM3ogTTI2Ny44MDIsMzY4LjE0DQoJCQljLTQuNDg1LTE2LjMzOS0xOS40Ni0yOC4zODItMzcuMjA0LTI4LjM4MmMtMTcuNzQzLDAtMzIuNzE3LDEyLjA0My0zNy4yMDMsMjguMzgyaC0xMS4wOVYyNTkuNjg3DQoJCQljMzYuMzUyLTQuMzgzLDY1LjQ5OS0zMi40NSw3MS41MTMtNjguMjgyaDExOC43MzVWMzY4LjE0SDI2Ny44MDJ6IE00NDEuMDk0LDM5Ni41MjNjLTEwLjAyNiwwLTE4LjE4Mi04LjE1Ny0xOC4xODItMTguMTgzDQoJCQlzOC4xNTYtMTguMTgzLDE4LjE4Mi0xOC4xODNjMTAuMDI2LDAsMTguMTgzLDguMTU3LDE4LjE4MywxOC4xODNTNDUxLjEyMSwzOTYuNTIzLDQ0MS4wOTQsMzk2LjUyM3ogTTQ5MS42MDIsMzY4LjE0aC0xMy4zMDQNCgkJCWMtNC40ODUtMTYuMzM5LTE5LjQ2LTI4LjM4Mi0zNy4yMDQtMjguMzgyYy0xNy43NDQsMC0zMi43MTcsMTIuMDQzLTM3LjIwMywyOC4zODJoLTEwLjkzOVYyNDMuNDc1aDQ0LjgzMWw1My44MTgsNjEuNDM4VjM2OC4xNHoiDQoJCQkvPg0KCTwvZz4NCjwvZz4NCjxnPg0KCTxnPg0KCQk8cGF0aCBkPSJNNjkuMjYxLDM0Ny41NzZoLTUuNDQyYy01LjYzMywwLTEwLjE5OSw0LjU2Ni0xMC4xOTksMTAuMTk5YzAsNS42MzMsNC41NjYsMTAuMTk5LDEwLjE5OSwxMC4xOTloNS40NDINCgkJCWM1LjYzMywwLDEwLjE5OS00LjU2NiwxMC4xOTktMTAuMTk5Qzc5LjQ2LDM1Mi4xNDIsNzQuODk0LDM0Ny41NzYsNjkuMjYxLDM0Ny41NzZ6Ii8+DQoJPC9nPg0KPC9nPg0KPGc+DQoJPGc+DQoJCTxwYXRoIGQ9Ik02My44MTgsMTk0Ljk2N0gyMy4xNDZjLTUuNjMzLDAtMTAuMTk5LDQuNTY2LTEwLjE5OSwxMC4xOTljMCw1LjYzMyw0LjU2NiwxMC4xOTksMTAuMTk5LDEwLjE5OWg0MC42NzINCgkJCWM1LjYzMywwLDEwLjE5OS00LjU2NiwxMC4xOTktMTAuMTk5Qzc0LjAxOCwxOTkuNTMzLDY5LjQ1MSwxOTQuOTY3LDYzLjgxOCwxOTQuOTY3eiIvPg0KCTwvZz4NCjwvZz4NCjxnPg0KCTxnPg0KCQk8cGF0aCBkPSJNMTE5LjUsMjcwLjI0SDEwLjE5OUM0LjU2NiwyNzAuMjQsMCwyNzQuODA2LDAsMjgwLjQzOWMwLDUuNjMzLDQuNTY2LDEwLjE5OSwxMC4xOTksMTAuMTk5SDExOS41DQoJCQljNS42MzMsMCwxMC4xOTktNC41NjYsMTAuMTk5LTEwLjE5OVMxMjUuMTMzLDI3MC4yNCwxMTkuNSwyNzAuMjR6Ii8+DQoJPC9nPg0KPC9nPg0KPGc+DQoJPGc+DQoJCTxwYXRoIGQ9Ik0xOTcuMDg1LDE4Ny45ODdsLTE0LjUyLTE0LjUxOXYtNDMuNTIxYzAtNS42MzMtNC41NjYtMTAuMTk5LTEwLjE5OS0xMC4xOTljLTUuNjMzLDAtMTAuMTk5LDQuNTY2LTEwLjE5OSwxMC4xOTl2NDcuNzQ2DQoJCQljMCwyLjcwNSwxLjA3NSw1LjI5OSwyLjk4Nyw3LjIxMmwxNy41MDcsMTcuNTA3YzEuOTkxLDEuOTkyLDQuNjAyLDIuOTg3LDcuMjEyLDIuOTg3czUuMjIxLTAuOTk2LDcuMjEyLTIuOTg3DQoJCQlDMjAxLjA2OCwxOTguNDI5LDIwMS4wNjgsMTkxLjk3LDE5Ny4wODUsMTg3Ljk4N3oiLz4NCgk8L2c+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8L3N2Zz4NCg==";
    }
}

 ?>
