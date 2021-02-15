<?php

return [
    'list' => [
        'toolbar' => [
            'buttons' => [
		        'back' => [
		            'label' => 'lang:admin::lang.button_icon_back',
		            'class' => 'btn btn-default',
		            'href' => 'customers',
		        ],
		        'export' => [
		            'label' => 'lang:thoughtco.customerswhoordered::default.btn_export',
		            'class' => 'btn btn-primary',
					'href' => 'thoughtco/customerswhoordered/orders/export',
		        ],
			],
        ],
	    'filter' => [
		    'scopes' => [
		        'location' => [
		            'label' => 'lang:admin::lang.text_filter_location',
		            'type' => 'select',
		            'conditions' => 'location_id = :filtered',
		            'modelClass' => 'Admin\Models\Locations_model',
		            'nameFrom' => 'location_name',
		            'locationAware' => 'hide',
		        ],
		        'status' => [
		            'label' => 'lang:admin::lang.text_filter_status',
		            'type' => 'select',
		            'conditions' => 'status_id = :filtered',
		            'modelClass' => 'Admin\Models\Statuses_model',
		            'options' => 'getDropdownOptionsForOrder',
		        ],
		        'type' => [
		            'label' => 'lang:admin::lang.orders.text_filter_order_type',
		            'type' => 'select',
		            'conditions' => 'order_type = :filtered',
		            'options' => [
		                '1' => 'lang:admin::lang.orders.text_delivery',
		                '2' => 'lang:admin::lang.orders.text_collection',
		            ],
		        ],
		        'date' => [
		            'label' => 'lang:admin::lang.text_filter_date',
		            'type' => 'daterange',
		            'conditions' => 'order_date >= CAST(:filtered_start AS DATE) AND order_date <= CAST(:filtered_end AS DATE)',
		        ],
		        'menus' => [
		            'label' => 'lang:thoughtco.customerswhoordered::default.text_filter_menus',
		            'type' => 'select',
		            'modelClass' => 'Admin\Models\Menus_model',
		            'nameFrom' => 'menu_name',
		            'conditions' => \DB::getTablePrefix().'order_menus.menu_id = :filtered',
		        ],
		    ],
		],
		'columns' => [
		    'full_name' => [
		        'label' => 'lang:admin::lang.customers.column_full_name',
		        'type' => 'text',
		        'select' => 'concat(first_name, " ", last_name)',
		        'searchable' => TRUE,
		    ],
            'email' => [
        		'label' => 'lang:admin::lang.label_email',
                'type' => 'text',
                'sortable' => TRUE,
            ],
            'order_date_time' => [
                'label' => 'lang:thoughtco.customerswhoordered::default.column_last_order',
                'type' => 'datetime',
                'sortable' => TRUE,
		        'select' => 'concat(order_date, " ", order_time)',
            ],
            'order_count' => [
                'label' => 'lang:thoughtco.customerswhoordered::default.column_order_count',
                'type' => 'integer',
                'sortable' => TRUE,
				'select' => 'count(email)',
			],
			'order_menus_id' => [
				'label' => 'Menu id',
                'type' => 'integer',
				'select' => \DB::getTablePrefix().'order_menus.menu_id',
				'invisible' => TRUE,
			],
		],
    ],
];
