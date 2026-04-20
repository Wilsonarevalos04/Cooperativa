<?php
global $runnerTableSettings;
$runnerTableSettings['ahorros_programados'] = array(
	'name' => 'ahorros_programados',
	'shortName' => 'ahorros_programados',
	'pagesByType' => array(
		'add' => array( 
			'add' 
		),
		'export' => array( 
			'export' 
		),
		'import' => array( 
			'import' 
		),
		'edit' => array( 
			'edit' 
		),
		'view' => array( 
			'view' 
		),
		'list' => array( 
			'list' 
		),
		'print' => array( 
			'print' 
		),
		'search' => array( 
			'search' 
		) 
	),
	'pageTypes' => array(
		'add' => 'add',
		'export' => 'export',
		'import' => 'import',
		'edit' => 'edit',
		'view' => 'view',
		'list' => 'list',
		'print' => 'print',
		'search' => 'search' 
	),
	'defaultPages' => array(
		'add' => 'add',
		'export' => 'export',
		'import' => 'import',
		'edit' => 'edit',
		'view' => 'view',
		'list' => 'list',
		'print' => 'print',
		'search' => 'search' 
	),
	'afterEditDetails' => 'ahorros_programados',
	'afterAddDetail' => 'ahorros_programados',
	'detailsBadgeColor' => '3cb371',
	'sql' => 'SELECT
	id,
	socio_id,
	monto_mensual,
	plazo_meses,
	fecha_inicio,
	estado
FROM
	ahorros_programados',
	'keyFields' => array( 
		'id' 
	),
	'deviceHideFields' => array(
		'1' => array( 
			 
		),
		'5' => array( 
			 
		) 
	),
	'fields' => array(
		'id' => array(
			'name' => 'id',
			'goodName' => 'id',
			'strField' => 'id',
			'index' => 1,
			'type' => 3,
			'autoinc' => true,
			'sqlExpression' => 'id',
			'viewFormats' => array(
				'view' => array(
					 
				) 
			),
			'editFormats' => array(
				'edit' => array(
					 
				) 
			),
			'tableName' => 'ahorros_programados' 
		),
		'socio_id' => array(
			'name' => 'socio_id',
			'goodName' => 'socio_id',
			'strField' => 'socio_id',
			'index' => 2,
			'type' => 3,
			'sqlExpression' => 'socio_id',
			'viewFormats' => array(
				'view' => array(
					'viewLink' => true 
				) 
			),
			'editFormats' => array(
				'edit' => array(
					'format' => 'Lookup wizard',
					'lookupType' => 2,
					'lookupTable' => 'socios',
					'lookupTableConnection' => 'conn',
					'lookupLinkField' => 'id',
					'lookupDisplayField' => 'cedula' 
				) 
			),
			'tableName' => 'ahorros_programados',
			'viewLinkTable' => 'socios',
			'viewLinkLookup' => true 
		),
		'monto_mensual' => array(
			'name' => 'monto_mensual',
			'goodName' => 'monto_mensual',
			'strField' => 'monto_mensual',
			'index' => 3,
			'type' => 14,
			'sqlExpression' => 'monto_mensual',
			'viewFormats' => array(
				'view' => array(
					'format' => 'Number' 
				) 
			),
			'editFormats' => array(
				'edit' => array(
					 
				) 
			),
			'tableName' => 'ahorros_programados' 
		),
		'plazo_meses' => array(
			'name' => 'plazo_meses',
			'goodName' => 'plazo_meses',
			'strField' => 'plazo_meses',
			'index' => 4,
			'type' => 3,
			'sqlExpression' => 'plazo_meses',
			'viewFormats' => array(
				'view' => array(
					 
				) 
			),
			'editFormats' => array(
				'edit' => array(
					 
				) 
			),
			'tableName' => 'ahorros_programados' 
		),
		'fecha_inicio' => array(
			'name' => 'fecha_inicio',
			'goodName' => 'fecha_inicio',
			'strField' => 'fecha_inicio',
			'index' => 5,
			'type' => 7,
			'sqlExpression' => 'fecha_inicio',
			'viewFormats' => array(
				'view' => array(
					'format' => 'Short Date' 
				) 
			),
			'editFormats' => array(
				'edit' => array(
					'format' => 'Date',
					'dateEditType' => 11 
				) 
			),
			'tableName' => 'ahorros_programados' 
		),
		'estado' => array(
			'name' => 'estado',
			'goodName' => 'estado',
			'strField' => 'estado',
			'index' => 6,
			'type' => 129,
			'sqlExpression' => 'estado',
			'viewFormats' => array(
				'view' => array(
					 
				) 
			),
			'editFormats' => array(
				'edit' => array(
					'format' => 'Lookup wizard',
					'lookupType' => 0,
					'lookupValues' => array( 
						'activo',
						'finalizado',
						'cancelado' 
					) 
				) 
			),
			'tableName' => 'ahorros_programados' 
		) 
	),
	'masterTables' => array( 
		array(
			'table' => 'socios',
			'detailsKeys' => array( 
				'socio_id' 
			),
			'masterKeys' => array( 
				'id' 
			) 
		) 
	),
	'query' => array(
		'sql' => 'SELECT
	id,
	socio_id,
	monto_mensual,
	plazo_meses,
	fecha_inicio,
	estado
FROM
	ahorros_programados',
		'parsed' => true,
		'type' => 'SQLQuery',
		'fieldList' => array( 
			array(
				'sql' => 'id',
				'parsed' => true,
				'type' => 'FieldListItem',
				'alias' => '',
				'expression' => array(
					'sql' => '',
					'parsed' => true,
					'type' => 'SQLField',
					'table' => 'ahorros_programados',
					'name' => 'id' 
				),
				'encrypted' => false,
				'columnName' => 'id' 
			),
			array(
				'sql' => 'socio_id',
				'parsed' => true,
				'type' => 'FieldListItem',
				'alias' => '',
				'expression' => array(
					'sql' => '',
					'parsed' => true,
					'type' => 'SQLField',
					'table' => 'ahorros_programados',
					'name' => 'socio_id' 
				),
				'encrypted' => false,
				'columnName' => 'socio_id' 
			),
			array(
				'sql' => 'monto_mensual',
				'parsed' => true,
				'type' => 'FieldListItem',
				'alias' => '',
				'expression' => array(
					'sql' => '',
					'parsed' => true,
					'type' => 'SQLField',
					'table' => 'ahorros_programados',
					'name' => 'monto_mensual' 
				),
				'encrypted' => false,
				'columnName' => 'monto_mensual' 
			),
			array(
				'sql' => 'plazo_meses',
				'parsed' => true,
				'type' => 'FieldListItem',
				'alias' => '',
				'expression' => array(
					'sql' => '',
					'parsed' => true,
					'type' => 'SQLField',
					'table' => 'ahorros_programados',
					'name' => 'plazo_meses' 
				),
				'encrypted' => false,
				'columnName' => 'plazo_meses' 
			),
			array(
				'sql' => 'fecha_inicio',
				'parsed' => true,
				'type' => 'FieldListItem',
				'alias' => '',
				'expression' => array(
					'sql' => '',
					'parsed' => true,
					'type' => 'SQLField',
					'table' => 'ahorros_programados',
					'name' => 'fecha_inicio' 
				),
				'encrypted' => false,
				'columnName' => 'fecha_inicio' 
			),
			array(
				'sql' => 'estado',
				'parsed' => true,
				'type' => 'FieldListItem',
				'alias' => '',
				'expression' => array(
					'sql' => '',
					'parsed' => true,
					'type' => 'SQLField',
					'table' => 'ahorros_programados',
					'name' => 'estado' 
				),
				'encrypted' => false,
				'columnName' => 'estado' 
			) 
		),
		'fromList' => array( 
			array(
				'sql' => 'ahorros_programados',
				'parsed' => true,
				'type' => 'FromListItem',
				'table' => array(
					'sql' => 'ahorros_programados',
					'parsed' => true,
					'type' => 'SQLTable',
					'columns' => array( 
						'id',
						'socio_id',
						'monto_mensual',
						'plazo_meses',
						'fecha_inicio',
						'estado' 
					),
					'name' => 'ahorros_programados' 
				),
				'joinOn' => array(
					'sql' => '',
					'parsed' => false,
					'type' => 'LogicalExpression',
					'contained' => array( 
						 
					),
					'unionType' => 0,
					'column' => null 
				),
				'joinList' => array(
					'sql' => '',
					'parsed' => true,
					'type' => 'JoinOn',
					'field1' => array( 
						 
					),
					'field2' => array( 
						 
					) 
				),
				'link' => 0 
			) 
		),
		'where' => array(
			'sql' => '',
			'parsed' => false,
			'type' => 'LogicalExpression',
			'contained' => array( 
				 
			),
			'unionType' => 0,
			'column' => null 
		),
		'groupBy' => array( 
			 
		),
		'having' => array(
			'sql' => '',
			'parsed' => false,
			'type' => 'LogicalExpression',
			'contained' => array( 
				 
			),
			'unionType' => 0,
			'column' => null 
		),
		'orderBy' => array( 
			 
		),
		'colsIndex' => array( 
			array(
				'fieldIndex' => 0,
				'orderByIndex' => -1,
				'groupByIndex' => -1,
				'whereIndex' => -1,
				'havingIndex' => -1 
			),
			array(
				'fieldIndex' => 1,
				'orderByIndex' => -1,
				'groupByIndex' => -1,
				'whereIndex' => -1,
				'havingIndex' => -1 
			),
			array(
				'fieldIndex' => 2,
				'orderByIndex' => -1,
				'groupByIndex' => -1,
				'whereIndex' => -1,
				'havingIndex' => -1 
			),
			array(
				'fieldIndex' => 3,
				'orderByIndex' => -1,
				'groupByIndex' => -1,
				'whereIndex' => -1,
				'havingIndex' => -1 
			),
			array(
				'fieldIndex' => 4,
				'orderByIndex' => -1,
				'groupByIndex' => -1,
				'whereIndex' => -1,
				'havingIndex' => -1 
			),
			array(
				'fieldIndex' => 5,
				'orderByIndex' => -1,
				'groupByIndex' => -1,
				'whereIndex' => -1,
				'havingIndex' => -1 
			) 
		),
		'headSql' => 'SELECT',
		'fieldListSql' => 'id,
	socio_id,
	monto_mensual,
	plazo_meses,
	fecha_inicio,
	estado',
		'fromListSql' => 'FROM
	ahorros_programados',
		'orderBySql' => '',
		'tailSql' => '' 
	),
	'originalTable' => 'ahorros_programados',
	'originalPagesByType' => array(
		'add' => array( 
			'add' 
		),
		'export' => array( 
			'export' 
		),
		'import' => array( 
			'import' 
		),
		'edit' => array( 
			'edit' 
		),
		'view' => array( 
			'view' 
		),
		'list' => array( 
			'list' 
		),
		'print' => array( 
			'print' 
		),
		'search' => array( 
			'search' 
		) 
	),
	'originalPageTypes' => array(
		'add' => 'add',
		'export' => 'export',
		'import' => 'import',
		'edit' => 'edit',
		'view' => 'view',
		'list' => 'list',
		'print' => 'print',
		'search' => 'search' 
	),
	'originalDefaultPages' => array(
		'add' => 'add',
		'export' => 'export',
		'import' => 'import',
		'edit' => 'edit',
		'view' => 'view',
		'list' => 'list',
		'print' => 'print',
		'search' => 'search' 
	),
	'searchSettings' => array(
		'caseSensitiveSearch' => false,
		'searchableFields' => array( 
			'id',
			'socio_id',
			'monto_mensual',
			'plazo_meses',
			'fecha_inicio',
			'estado' 
		),
		'searchSuggest' => true,
		'highlightSearchResults' => true,
		'hideDataUntilSearch' => false,
		'hideFilterUntilSearch' => false,
		'googleLikeSearchFields' => array( 
			'id',
			'socio_id',
			'monto_mensual',
			'plazo_meses',
			'fecha_inicio',
			'estado' 
		) 
	),
	'connId' => 'conn',
	'clickActions' => array(
		'row' => array(
			'action' => 'noaction' 
		),
		'fields' => array(
			 
		) 
	),
	'geoCoding' => array(
		'enabled' => false,
		'latField' => '',
		'lonField' => '',
		'addressFields' => array( 
			 
		) 
	),
	'whereTabs' => array( 
		 
	),
	'labels' => array(
		 
	),
	'chartSettings' => array(
		 
	),
	'dataSourceOperations' => array(
		 
	),
	'calendarSettings' => array(
		'categoryColors' => array( 
			 
		) 
	),
	'ganttSettings' => array(
		'categoryColors' => array( 
			 
		) 
	) 
);

global $runnerTableLabels;
if( mlang_getcurrentlang() === 'English' ) {
	$runnerTableLabels['ahorros_programados'] = array(
	'tableCaption' => 'Ahorros Programados',
	'fieldLabels' => array(
		'id' => 'Id',
		'socio_id' => 'Socio Id',
		'monto_mensual' => 'Monto Mensual',
		'plazo_meses' => 'Plazo Meses',
		'fecha_inicio' => 'Fecha Inicio',
		'estado' => 'Estado' 
	),
	'fieldTooltips' => array(
		'id' => '',
		'socio_id' => '',
		'monto_mensual' => '',
		'plazo_meses' => '',
		'fecha_inicio' => '',
		'estado' => '' 
	),
	'fieldPlaceholders' => array(
		'id' => '',
		'socio_id' => '',
		'monto_mensual' => '',
		'plazo_meses' => '',
		'fecha_inicio' => '',
		'estado' => '' 
	),
	'pageTitles' => array(
		 
	) 
);
}
?>