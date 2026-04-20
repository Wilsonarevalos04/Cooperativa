<?php
global $runnerTableSettings;
$runnerTableSettings['cuotas'] = array(
	'name' => 'cuotas',
	'shortName' => 'cuotas',
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
	'afterEditDetails' => 'cuotas',
	'afterAddDetail' => 'cuotas',
	'detailsBadgeColor' => 'e67349',
	'sql' => 'SELECT
	id,
	prestamo_id,
	numero_cuota,
	monto,
	fecha_vencimiento,
	estado
FROM
	cuotas',
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
			'tableName' => 'cuotas' 
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
			'tableName' => 'cuotas',
			'viewLinkTable' => 'prestamos',
			'viewLinkLookup' => true 
		),
		'numero_cuota' => array(
			'name' => 'numero_cuota',
			'goodName' => 'numero_cuota',
			'strField' => 'numero_cuota',
			'index' => 3,
			'type' => 3,
			'sqlExpression' => 'numero_cuota',
			'viewFormats' => array(
				'view' => array(
					 
				) 
			),
			'editFormats' => array(
				'edit' => array(
					 
				) 
			),
			'tableName' => 'cuotas' 
		),
		'monto' => array(
			'name' => 'monto',
			'goodName' => 'monto',
			'strField' => 'monto',
			'index' => 4,
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
			'tableName' => 'cuotas' 
		),
		'fecha_vencimiento' => array(
			'name' => 'fecha_vencimiento',
			'goodName' => 'fecha_vencimiento',
			'strField' => 'fecha_vencimiento',
			'index' => 5,
			'type' => 7,
			'sqlExpression' => 'fecha_vencimiento',
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
			'tableName' => 'cuotas' 
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
						'pendiente',
						'pagado',
						'atrasado' 
					) 
				) 
			),
			'tableName' => 'cuotas' 
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
	numero_cuota,
	monto,
	fecha_vencimiento,
	estado
FROM
	cuotas',
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
					'table' => 'cuotas',
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
					'table' => 'cuotas',
					'name' => 'prestamo_id' 
				),
				'encrypted' => false,
				'columnName' => 'prestamo_id' 
			),
			array(
				'sql' => 'numero_cuota',
				'parsed' => true,
				'type' => 'FieldListItem',
				'alias' => '',
				'expression' => array(
					'sql' => '',
					'parsed' => true,
					'type' => 'SQLField',
					'table' => 'cuotas',
					'name' => 'numero_cuota' 
				),
				'encrypted' => false,
				'columnName' => 'numero_cuota' 
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
					'table' => 'cuotas',
					'name' => 'monto' 
				),
				'encrypted' => false,
				'columnName' => 'monto' 
			),
			array(
				'sql' => 'fecha_vencimiento',
				'parsed' => true,
				'type' => 'FieldListItem',
				'alias' => '',
				'expression' => array(
					'sql' => '',
					'parsed' => true,
					'type' => 'SQLField',
					'table' => 'cuotas',
					'name' => 'fecha_vencimiento' 
				),
				'encrypted' => false,
				'columnName' => 'fecha_vencimiento' 
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
					'table' => 'cuotas',
					'name' => 'estado' 
				),
				'encrypted' => false,
				'columnName' => 'estado' 
			) 
		),
		'fromList' => array( 
			array(
				'sql' => 'cuotas',
				'parsed' => true,
				'type' => 'FromListItem',
				'table' => array(
					'sql' => 'cuotas',
					'parsed' => true,
					'type' => 'SQLTable',
					'columns' => array( 
						'id',
						'prestamo_id',
						'numero_cuota',
						'monto',
						'fecha_vencimiento',
						'estado' 
					),
					'name' => 'cuotas' 
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
	prestamo_id,
	numero_cuota,
	monto,
	fecha_vencimiento,
	estado',
		'fromListSql' => 'FROM
	cuotas',
		'orderBySql' => '',
		'tailSql' => '' 
	),
	'originalTable' => 'cuotas',
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
			'numero_cuota',
			'monto',
			'fecha_vencimiento',
			'estado' 
		),
		'searchSuggest' => true,
		'highlightSearchResults' => true,
		'hideDataUntilSearch' => false,
		'hideFilterUntilSearch' => false,
		'googleLikeSearchFields' => array( 
			'id',
			'prestamo_id',
			'numero_cuota',
			'monto',
			'fecha_vencimiento',
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
	$runnerTableLabels['cuotas'] = array(
	'tableCaption' => 'Cuotas',
	'fieldLabels' => array(
		'id' => 'Id',
		'prestamo_id' => 'Prestamo Id',
		'numero_cuota' => 'Numero Cuota',
		'monto' => 'Monto',
		'fecha_vencimiento' => 'Fecha Vencimiento',
		'estado' => 'Estado' 
	),
	'fieldTooltips' => array(
		'id' => '',
		'prestamo_id' => '',
		'numero_cuota' => '',
		'monto' => '',
		'fecha_vencimiento' => '',
		'estado' => '' 
	),
	'fieldPlaceholders' => array(
		'id' => '',
		'prestamo_id' => '',
		'numero_cuota' => '',
		'monto' => '',
		'fecha_vencimiento' => '',
		'estado' => '' 
	),
	'pageTitles' => array(
		 
	) 
);
}
?>