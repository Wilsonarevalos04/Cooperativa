<?php
			$optionsArray = array(
	'welcome' => array(
		'welcomePageSkip' => false,
		'welcomeItems' => array(
			'logo' => array(
				'menutItem' => false 
			),
			'menu' => array(
				'menutItem' => false 
			),
			'welcome_item' => array(
				'menutItem' => true,
				'group' => false,
				'linkType' => 0,
				'items' => null,
				'table' => 'ahorros_programados',
				'page' => 'list' 
			),
			'welcome_item1' => array(
				'menutItem' => true,
				'group' => false,
				'linkType' => 0,
				'items' => null,
				'table' => 'auditoria',
				'page' => 'list' 
			),
			'welcome_item2' => array(
				'menutItem' => true,
				'group' => false,
				'linkType' => 0,
				'items' => null,
				'table' => 'cuentas',
				'page' => 'list' 
			),
			'welcome_item3' => array(
				'menutItem' => true,
				'group' => false,
				'linkType' => 0,
				'items' => null,
				'table' => 'cuotas',
				'page' => 'list' 
			),
			'welcome_item4' => array(
				'menutItem' => true,
				'group' => false,
				'linkType' => 0,
				'items' => null,
				'table' => 'pagos',
				'page' => 'list' 
			),
			'welcome_item5' => array(
				'menutItem' => true,
				'group' => false,
				'linkType' => 0,
				'items' => null,
				'table' => 'prestamos',
				'page' => 'list' 
			),
			'welcome_item6' => array(
				'menutItem' => true,
				'group' => false,
				'linkType' => 0,
				'items' => null,
				'table' => 'roles',
				'page' => 'list' 
			),
			'welcome_item7' => array(
				'menutItem' => true,
				'group' => false,
				'linkType' => 0,
				'items' => null,
				'table' => 'scoring_crediticio',
				'page' => 'list' 
			),
			'welcome_item8' => array(
				'menutItem' => true,
				'group' => false,
				'linkType' => 0,
				'items' => null,
				'table' => 'socios',
				'page' => 'list' 
			),
			'welcome_item9' => array(
				'menutItem' => true,
				'group' => false,
				'linkType' => 0,
				'items' => null,
				'table' => 'transacciones',
				'page' => 'list' 
			),
			'welcome_item10' => array(
				'menutItem' => true,
				'group' => false,
				'linkType' => 0,
				'items' => null,
				'table' => 'usuario_roles',
				'page' => 'list' 
			),
			'welcome_item11' => array(
				'menutItem' => true,
				'group' => false,
				'linkType' => 0,
				'items' => null,
				'table' => 'usuarios',
				'page' => 'list' 
			) 
		) 
	),
	'fields' => array(
		'gridFields' => array( 
			 
		),
		'searchRequiredFields' => array( 
			 
		),
		'searchPanelFields' => array( 
			 
		),
		'fieldItems' => array(
			 
		) 
	),
	'layoutHelper' => array(
		'formItems' => array(
			'formItems' => array(
				'above-grid' => array( 
					 
				),
				'supertop' => array( 
					'logo',
					'menu' 
				),
				'grid' => array( 
					'welcome_item',
					'welcome_item1',
					'welcome_item2',
					'welcome_item3',
					'welcome_item4',
					'welcome_item5',
					'welcome_item6',
					'welcome_item7',
					'welcome_item8',
					'welcome_item9',
					'welcome_item10',
					'welcome_item11' 
				) 
			),
			'formXtTags' => array(
				'above-grid' => array( 
					 
				) 
			),
			'itemForms' => array(
				'logo' => 'supertop',
				'menu' => 'supertop',
				'welcome_item' => 'grid',
				'welcome_item1' => 'grid',
				'welcome_item2' => 'grid',
				'welcome_item3' => 'grid',
				'welcome_item4' => 'grid',
				'welcome_item5' => 'grid',
				'welcome_item6' => 'grid',
				'welcome_item7' => 'grid',
				'welcome_item8' => 'grid',
				'welcome_item9' => 'grid',
				'welcome_item10' => 'grid',
				'welcome_item11' => 'grid' 
			),
			'itemLocations' => array(
				 
			),
			'itemVisiblity' => array(
				'menu' => 3 
			) 
		),
		'itemsByType' => array(
			'logo' => array( 
				'logo' 
			),
			'menu' => array( 
				'menu' 
			),
			'welcome_item' => array( 
				'welcome_item',
				'welcome_item1',
				'welcome_item2',
				'welcome_item3',
				'welcome_item4',
				'welcome_item5',
				'welcome_item6',
				'welcome_item7',
				'welcome_item8',
				'welcome_item9',
				'welcome_item10',
				'welcome_item11' 
			) 
		),
		'cellMaps' => array(
			 
		) 
	),
	'page' => array(
		'verticalBar' => false,
		'labeledButtons' => array(
			'update_records' => array(
				 
			),
			'print_pages' => array(
				 
			),
			'register_activate_message' => array(
				 
			),
			'details_found' => array(
				 
			) 
		),
		'hasCustomButtons' => false,
		'customButtons' => array( 
			 
		),
		'codeSnippets' => array( 
			 
		),
		'clickHandlerSnippets' => array( 
			 
		),
		'hasNotifications' => false,
		'menus' => array( 
			array(
				'id' => 'main',
				'horizontal' => true 
			) 
		),
		'calcTotalsFor' => 1,
		'hasCharts' => false 
	),
	'events' => array(
		'maps' => array( 
			 
		),
		'mapsData' => array(
			 
		),
		'buttons' => array( 
			 
		) 
	) 
);
			$pageArray = array(
	'id' => 'menu',
	'type' => 'menu',
	'layoutId' => 'topbar',
	'disabled' => false,
	'default' => 0,
	'forms' => array(
		'above-grid' => array(
			'modelId' => 'empty-above-grid',
			'grid' => array( 
				array(
					'cells' => array( 
						array(
							'cell' => 'c1' 
						) 
					),
					'section' => '' 
				) 
			),
			'cells' => array(
				'c1' => array(
					'model' => 'c1',
					'items' => array( 
						 
					) 
				) 
			),
			'deferredItems' => array( 
				 
			),
			'recsPerRow' => 1 
		),
		'supertop' => array(
			'modelId' => 'menu-topbar-menu',
			'grid' => array( 
				array(
					'cells' => array( 
						array(
							'cell' => 'c1' 
						),
						array(
							'cell' => 'c2' 
						) 
					),
					'section' => '' 
				) 
			),
			'cells' => array(
				'c1' => array(
					'model' => 'c1',
					'items' => array( 
						'logo',
						'menu' 
					) 
				),
				'c2' => array(
					'model' => 'c2',
					'items' => array( 
						 
					) 
				) 
			),
			'deferredItems' => array( 
				 
			),
			'recsPerRow' => 1 
		),
		'grid' => array(
			'modelId' => 'welcome',
			'grid' => array( 
				array(
					'cells' => array( 
						array(
							'cell' => 'c1' 
						) 
					),
					'section' => '' 
				) 
			),
			'cells' => array(
				'c1' => array(
					'model' => 'c1',
					'items' => array( 
						'welcome_item',
						'welcome_item1',
						'welcome_item2',
						'welcome_item3',
						'welcome_item4',
						'welcome_item5',
						'welcome_item6',
						'welcome_item7',
						'welcome_item8',
						'welcome_item9',
						'welcome_item10',
						'welcome_item11' 
					) 
				) 
			),
			'deferredItems' => array( 
				 
			),
			'recsPerRow' => 1 
		) 
	),
	'items' => array(
		'logo' => array(
			'type' => 'logo' 
		),
		'menu' => array(
			'type' => 'menu' 
		),
		'welcome_item' => array(
			'type' => 'welcome_item',
			'linkUrl' => '',
			'linkTable' => 'ahorros_programados',
			'linkPage' => 'list',
			'linkText' => array(
				'table' => 'ahorros_programados',
				'type' => 6 
			),
			'linkIcon' => array(
				'glyph' => 'star-empty' 
			),
			'linkComments' => array(
				'text' => 'Ahorros Programados description',
				'type' => 0 
			),
			'background' => '#3cb371',
			'linkType' => 0 
		),
		'welcome_item1' => array(
			'type' => 'welcome_item',
			'linkUrl' => '',
			'linkTable' => 'auditoria',
			'linkPage' => 'list',
			'linkText' => array(
				'table' => 'auditoria',
				'type' => 6 
			),
			'linkIcon' => array(
				'glyph' => 'star' 
			),
			'linkComments' => array(
				'text' => 'Auditoria description',
				'type' => 0 
			),
			'background' => '#4169e1',
			'linkType' => 0 
		),
		'welcome_item2' => array(
			'type' => 'welcome_item',
			'linkUrl' => '',
			'linkTable' => 'cuentas',
			'linkPage' => 'list',
			'linkText' => array(
				'table' => 'cuentas',
				'type' => 6 
			),
			'linkIcon' => array(
				'glyph' => 'camera' 
			),
			'linkComments' => array(
				'text' => 'Cuentas description',
				'type' => 0 
			),
			'background' => '#d2af80',
			'linkType' => 0 
		),
		'welcome_item3' => array(
			'type' => 'welcome_item',
			'linkUrl' => '',
			'linkTable' => 'cuotas',
			'linkPage' => 'list',
			'linkText' => array(
				'table' => 'cuotas',
				'type' => 6 
			),
			'linkIcon' => array(
				'glyph' => 'tree-conifer' 
			),
			'linkComments' => array(
				'text' => 'Cuotas description',
				'type' => 0 
			),
			'background' => '#e67349',
			'linkType' => 0 
		),
		'welcome_item4' => array(
			'type' => 'welcome_item',
			'linkUrl' => '',
			'linkTable' => 'pagos',
			'linkPage' => 'list',
			'linkText' => array(
				'table' => 'pagos',
				'type' => 6 
			),
			'linkIcon' => array(
				'glyph' => 'headphones' 
			),
			'linkComments' => array(
				'text' => 'Pagos description',
				'type' => 0 
			),
			'background' => '#edca00',
			'linkType' => 0 
		),
		'welcome_item5' => array(
			'type' => 'welcome_item',
			'linkUrl' => '',
			'linkTable' => 'prestamos',
			'linkPage' => 'list',
			'linkText' => array(
				'table' => 'prestamos',
				'type' => 6 
			),
			'linkIcon' => array(
				'glyph' => 'briefcase' 
			),
			'background' => '#dc143c',
			'linkType' => 0 
		),
		'welcome_item6' => array(
			'type' => 'welcome_item',
			'linkUrl' => '',
			'linkTable' => 'roles',
			'linkPage' => 'list',
			'linkText' => array(
				'table' => 'roles',
				'type' => 6 
			),
			'linkIcon' => array(
				'glyph' => 'calendar' 
			),
			'background' => '#6493ea',
			'linkType' => 0 
		),
		'welcome_item7' => array(
			'type' => 'welcome_item',
			'linkUrl' => '',
			'linkTable' => 'scoring_crediticio',
			'linkPage' => 'list',
			'linkText' => array(
				'table' => 'scoring_crediticio',
				'type' => 6 
			),
			'linkIcon' => array(
				'glyph' => 'star-empty' 
			),
			'background' => '#7b68ee',
			'linkType' => 0 
		),
		'welcome_item8' => array(
			'type' => 'welcome_item',
			'linkUrl' => '',
			'linkTable' => 'socios',
			'linkPage' => 'list',
			'linkText' => array(
				'table' => 'socios',
				'type' => 6 
			),
			'linkIcon' => array(
				'glyph' => 'tree-conifer' 
			),
			'background' => '#db7093',
			'linkType' => 0 
		),
		'welcome_item9' => array(
			'type' => 'welcome_item',
			'linkUrl' => '',
			'linkTable' => 'transacciones',
			'linkPage' => 'list',
			'linkText' => array(
				'table' => 'transacciones',
				'type' => 6 
			),
			'background' => '#6493ea',
			'linkType' => 0 
		),
		'welcome_item10' => array(
			'type' => 'welcome_item',
			'linkUrl' => '',
			'linkTable' => 'usuario_roles',
			'linkPage' => 'list',
			'linkText' => array(
				'table' => 'usuario_roles',
				'type' => 6 
			),
			'background' => '#e07878',
			'linkType' => 0 
		),
		'welcome_item11' => array(
			'type' => 'welcome_item',
			'linkUrl' => '',
			'linkTable' => 'usuarios',
			'linkPage' => 'list',
			'linkText' => array(
				'table' => 'usuarios',
				'type' => 6 
			),
			'background' => '#d2af80',
			'linkType' => 0 
		) 
	),
	'version' => 13,
	'pageWidth' => 'full',
	'imageItem' => array(
		'type' => 'page_image' 
	),
	'imageBgColor' => '#f2f2f2',
	'controlsBgColor' => 'transparent',
	'imagePosition' => 'right',
	'welcomePageStay' => true,
	'listTotals' => 1,
	'title' => array(
		 
	),
	'cardStyle' => array(
		 
	),
	'welcomeStyle' => 3 
);
		?>