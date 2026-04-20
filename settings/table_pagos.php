<?php
global $runnerTableSettings;
$runnerTableSettings['pagos'] = array(
	'name' => 'pagos',
	'shortName' => 'pagos',
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
	'afterEditDetails' => 'pagos',
	'afterAddDetail' => 'pagos',
	'detailsBadgeColor' => 'edca00',
	'sql' => 'SELECT
	id,
	prestamo_id,
	monto,
	fecha_pago,
	metodo
FROM
	pagos',
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
			'tableName' => 'pagos' 
		),
		'prestamo_id' => array(
			'name' => 'prestamo_id',
			'goodName' => 'prestamo_id',
			'strField' => 'prestamo_id',
			'index' => 2,
			'type' => 3,
			'sqlExpression' => 'prestamo_id',
			'viewFormats' => array(
				'view' => array(
					'viewLink' => true 
				) 
			),
			'editFormats' => array(
				'edit' => array(
					'format' => 'Lookup wizard',
					'lookupType' => 2,
					'lookupTable' => 'prestamos',
					'lookupTableConnection' => 'conn',
					'lookupLinkField' => 'id',
					'lookupDisplayField' => 'estado' 
				) 
			),
			'tableName' => 'pagos',
			'viewLinkTable' => 'prestamos',
			'viewLinkLookup' => true 
		),
		'monto' => array(
			'name' => 'monto',
			'goodName' => 'monto',
			'strField' => 'monto',
			'index' => 3,
			'type' => 14,
			'sqlExpression' => 'monto',
			'viewFormats' => array(
				'view' => array(
					'format' => 'Number' 
				) 
			),
			'editFormats' => array(
				'edit' => array(
					 
				) 
			),
			'tableName' => 'pagos' 
		),
		'fecha_pago' => array(
			'name' => 'fecha_pago',
			'goodName' => 'fecha_pago',
			'strField' => 'fecha_pago',
			'index' => 4,
			'type' => 135,
			'sqlExpression' => 'fecha_pago',
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
			'tableName' => 'pagos' 
		),
		'metodo' => array(
			'name' => 'metodo',
			'goodName' => 'metodo',
			'strField' => 'metodo',
			'index' => 5,
			'type' => 129,
			'sqlExpression' => 'metodo',
			'viewFormats' => array(
				'view' => array(
					 
				) 
			),
			'editFormats' => array(
				'edit' => array(
					'format' => 'Lookup wizard',
					'lookupType' => 0,
					'lookupValues' => array( 
						'efectivo',
						'transferencia' 
					) 
				) 
			),
			'tableName' => 'pagos' 
		) 
	),
	'masterTables' => array( 
		array(
			'table' => 'prestamos',
			'detailsKeys' => array( 
				'prestamo_id' 
			),
			'masterKeys' => array( 
				'id' 
			) 
		) 
	),
	'query' => array(
		'sql' => 'SELECT
	id,
	prestamo_id,
	monto,
	fecha_pago,
	metodo
FROM
	pagos',
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
					'table' => 'pagos',
					'name' => 'id' 
				),
				'encrypted' => false,
				'columnName' => 'id' 
			),
			array(
				'sql' => 'prestamo_id',
				'parsed' => true,
				'type' => 'FieldListItem',
				'alias' => '',
				'expression' => array(
					'sql' => '',
					'parsed' => true,
					'type' => 'SQLField',
					'table' => 'pagos',
					'name' => 'prestamo_id' 
				),
				'encrypted' => false,
				'columnName' => 'prestamo_id' 
			),
			array(
				'sql' => 'monto',
				'parsed' => true,
				'type' => 'FieldListItem',
				'alias' => '',
				'expression' => array(
					'sql' => '',
					'parsed' => true,
					'type' => 'SQLField',
					'table' => 'pagos',
					'name' => 'monto' 
				),
				'encrypted' => false,
				'columnName' => 'monto' 
			),
			array(
				'sql' => 'fecha_pago',
				'parsed' => true,
				'type' => 'FieldListItem',
				'alias' => '',
				'expression' => array(
					'sql' => '',
					'parsed' => true,
					'type' => 'SQLField',
					'table' => 'pagos',
					'name' => 'fecha_pago' 
				),
				'encrypted' => false,
				'columnName' => 'fecha_pago' 
			),
			array(
				'sql' => 'metodo',
				'parsed' => true,
				'type' => 'FieldListItem',
				'alias' => '',
				'expression' => array(
					'sql' => '',
					'parsed' => true,
					'type' => 'SQLField',
					'table' => 'pagos',
					'name' => 'metodo' 
				),
				'encrypted' => false,
				'columnName' => 'metodo' 
			) 
		),
		'fromList' => array( 
			array(
				'sql' => 'pagos',
				'parsed' => true,
				'type' => 'FromListItem',
				'table' => array(
					'sql' => 'pagos',
					'parsed' => true,
					'type' => 'SQLTable',
					'columns' => array( 
						'id',
						'prestamo_id',
						'monto',
						'fecha_pago',
						'metodo' 
					),
					'name' => 'pagos' 
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
			) 
		),
		'headSql' => 'SELECT',
		'fieldListSql' => 'id,
	prestamo_id,
	monto,
	fecha_pago,
	metodo',
		'fromListSql' => 'FROM
	pagos',
		'orderBySql' => '',
		'tailSql' => '' 
	),
	'originalTable' => 'pagos',
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
			'prestamo_id',
			'monto',
			'fecha_pago',
			'metodo' 
		),
		'searchSuggest' => true,
		'highlightSearchResults' => true,
		'hideDataUntilSearch' => false,
		'hideFilterUntilSearch' => false,
		'googleLikeSearchFields' => array( 
			'id',
			'prestamo_id',
			'monto',
			'fecha_pago',
			'metodo' 
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
	$runnerTableLabels['pagos'] = array(
	'tableCaption' => 'Pagos',
	'fieldLabels' => array(
		'id' => 'Id',
		'prestamo_id' => 'Prestamo Id',
		'monto' => 'Monto',
		'fecha_pago' => 'Fecha Pago',
		'metodo' => 'Metodo' 
	),
	'fieldTooltips' => array(
		'id' => '',
		'prestamo_id' => '',
		'monto' => '',
		'fecha_pago' => '',
		'metodo' => '' 
	),
	'fieldPlaceholders' => array(
		'id' => '',
		'prestamo_id' => '',
		'monto' => '',
		'fecha_pago' => '',
		'metodo' => '' 
	),
	'pageTitles' => array(
		 
	) 
);
}
?>