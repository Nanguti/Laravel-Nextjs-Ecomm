<?php

namespace App\Nova\Dashboards;

use App\Nova\Metrics\Customers;
use App\Nova\Metrics\Orders;
use Laravel\Nova\Dashboards\Main as Dashboard;

class Main extends Dashboard
{
    /**
     * Get the cards for the dashboard.
     *
     * @return array
     */
    public function cards()
    {
        return [
            new Orders,
            new Customers
        ];
    }
}
