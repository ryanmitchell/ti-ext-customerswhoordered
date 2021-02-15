<?php

namespace Thoughtco\CustomersWhoOrdered\Controllers;

use AdminMenu;
use Admin\Facades\AdminLocation;
use ApplicationException;
use DB;
use Response;

/**
 * Orders Admin Controller
 */
class Orders extends \Admin\Classes\AdminController
{
    public $implement = [
        'Admin\Actions\ListController',
    ];

    public $listConfig = [
        'list' => [
            'model' => 'Admin\Models\Orders_model',
            'title' => 'lang:thoughtco.customerswhoordered::default.text_title',
            'emptyMessage' => 'lang:thoughtco.customerswhoordered::default.text_empty',
            'defaultSort' => ['order_date', 'DESC'],
            'configFile' => 'orders',
            'showCheckboxes' => false,
        ],
    ];

    protected $requiredPermissions = 'Thoughtco.CustomersWhoOrdered.*';

    public function __construct()
    {
        parent::__construct();
        AdminMenu::setContext('tools', 'users');
    }

    public function listExtendQueryBefore($query, $alias)
    {
        $query
            ->join('order_menus', 'order_menus.order_id', '=', 'orders.order_id')
            ->orderBy('order_date', 'desc')
            ->groupBy('email');
    }

    public function export()
    {
        parent::index();

        $widget = $this->getListWidget();
        $widget->prepareVars();

        $records = $widget->vars['records'];

        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=customers.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $columns = array('customer_name', 'customer_email', 'last_order', 'order_count');

        $callback = function() use ($records, $columns)
        {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($records as $record) {
                fputcsv($file, [$record->full_name, $record->email, $record->order_date_time, $record->order_count,]);
            }
            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }

}
