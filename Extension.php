<?php

namespace Thoughtco\CustomersWhoOrdered;

use Event;
use Igniter\Flame\Exception\ApplicationException;
use System\Classes\BaseExtension;

/**
 * CustomersWhoOrdered Extension Information File
 */
class Extension extends BaseExtension
{
    public function boot()
    {
        $this->extendListingViews();
    }

    protected function extendListingViews()
    {
		Event::listen('admin.toolbar.extendButtons', function (&$widget) {
			if ($widget->getController() instanceof \Admin\Controllers\Customers){
                $widget->getController()->widgets['toolbar']->addButtons([
    		        'dockets' => [
    		            'label' => 'lang:thoughtco.customerswhoordered::default.btn_orders',
    		            'class' => 'btn btn-default',
    		            'href' => 'thoughtco/customerswhoordered/orders',
    		        ],
                ]);
            }
        });
    }

}
