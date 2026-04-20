<?php
global $runnerTableSettings;
$runnerTableSettings['cuentas'] = array(
	'name' => 'cuentas',
	'shortName' => 'cuentas',
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
		'masterlist' => array( 
			'masterlist' 
		),
		'masterprint' => array( 
			'masterprint' 
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
		'masterlist' => 'masterlist',
		'masterprint' => 'masterprint',
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
		'masterlist' => 'masterlist',
		'masterprint' => 'masterprint',
		'search' => 'search' 
	),
	'afterEditDetails' => 'cuentas',
	'afterAddDetail' => 'cuentas',
	'detailsBadgeColor' => 'd2af80',
	'sql' => 'SELECT
	id,
	socio_id,
	numero_cuenta,
	tipo,
	saldo,
	estado,
	created_at
FROM
	cuentas',
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
			'tableName' => 'cuentas' 
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
			'tableName' => 'cuentas',
			'viewLinkTable' => 'socios',
			'viewLinkLookup' => true 
		),
		'numero_cuenta' => array(
			'name' => 'numero_cuenta',
			'goodName' => 'numero_cuenta',
			'strField' => 'numero_cuenta',
			'index' => 3,
			'sqlExpression' => 'numero_cuenta',
			'viewFormats' => array(
				'view' => array(
					 
				) 
			),
			'editFormats' => array(
				'edit' => array(
					 
				) 
			),
			'tableName' => 'cuentas' 
		),
		'tipo' => array(
			'name' => 'tipo',
			'goodName' => 'tipo',
			'strField' => 'tipo',
			'index' => 4,
			'type' => 129,
			'sqlExpression' => 'tipo',
			'viewFormats' => array(
				'view' => array(
					 
				) 
			),
			'editFormats' => array(
				'edit' => array(
					'format' => 'Lookup wizard',
					'lookupType' => 0,
					'lookupValues' => array( 
						'ahorro',
						'corriente' 
					) 
				) 
			),
			'tableName' => 'cuentas' 
		),
		'saldo' => array(
			'name' => 'saldo',
			'goodName' => 'saldo',
			'strField' => 'saldo',
			'index' => 5,
			'type' => 14,
			'sqlExpression' => 'saldo',
			'viewFormats' => array(
				'view' => array(
					'format' => 'Number' 
				) 
			),
			'editFormats' => array(
				'edit' => array(
					 
				) 
			),
			'tableName' => 'cuentas' 
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
						'activa',
						'bloqueada',
						'cerrada' 
					) 
				) 
			),
			'tableName' => 'cuentas' 
		),
		'created_at' => array(
			'name' => 'created_at',
			'goodName' => 'created_at',
			'strField' => 'created_at',
			'index' => 7,
			'type' => 135,
			'sqlExpression' => 'created_at',
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
			'tableName' => 'cuentas' 
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
	'detailsTables' => array( 
		'transacciones' 
	),
	'query' => array(
		'sql' => 'SELECT
	id,
	socio_id,
	numero_cuenta,
	tipo,
	saldo,
	estado,
	created_at
FROM
	cuentas',
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
					'table' => 'cuentas',
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
					'table' => 'cuentas',
					'name' => 'socio_id' 
				),
				'encrypted' => false,
				'columnName' => 'socio_id' 
			),
			array(
				'sql' => 'numero_cuenta',
				'parsed' => true,
				'type' => 'FieldListItem',
				'alias' => '',
				'expression' => array(
					'sql' => '',
					'parsed' => true,
					'type' => 'SQLField',
					'table' => 'cuentas',
					'name' => 'numero_cuenta' 
				),
				'encrypted' => false,
				'columnName' => 'numero_cuenta' 
			),
			array(
				'sql' => 'tipo',
				'parsed' => true,
				'type' => 'FieldListItem',
				'alias' => '',
				'expression' => array(
					'sql' => '',
					'parsed' => true,
					'type' => 'SQLField',
					'table' => 'cuentas',
					'name' => 'tipo' 
				),
				'encrypted' => false,
				'columnName' => 'tipo' 
			),
			array(
				'sql' => 'saldo',
				'parsed' => true,
				'type' => 'FieldListItem',
				'alias' => '',
				'expression' => array(
					'sql' => '',
					'parsed' => true,
					'type' => 'SQLField',
					'table' => 'cuentas',
					'name' => 'saldo' 
				),
				'encrypted' => false,
				'columnName' => 'saldo' 
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
					'table' => 'cuentas',
					'name' => 'estado' 
				),
				'encrypted' => false,
				'columnName' => 'estado' 
			),
			array(
				'sql' => 'created_at',
				'parsed' => true,
				'type' => 'FieldListItem',
				'alias' => '',
				'expression' => array(
					'sql' => '',
					'parsed' => true,
					'type' => 'SQLField',
					'table' => 'cuentas',
					'name' => 'created_at' 
				),
				'encrypted' => false,
				'columnName' => 'created_at' 
			) 
		),
		'fromList' => array( 
			array(
				'sql' => 'cuentas',
				'parsed' => true,
				'type' => 'FromListItem',
				'table' => array(
					'sql' => 'cuentas',
					'parsed' => true,
					'type' => 'SQLTable',
					'columns' => array( 
						'id',
						'socio_id',
						'numero_cuenta',
						'tipo',
						'saldo',
						'estado',
						'created_at' 
					),
					'name' => 'cuentas' 
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
			),
			array(
				'fieldIndex' => 6,
				'orderByIndex' => -1,
				'groupByIndex' => -1,
				'whereIndex' => -1,
				'havingIndex' => -1 
			) 
		),
		'headSql' => 'SELECT',
		'fieldListSql' => 'id,
	socio_id,
	numero_cuenta,
	tipo,
	saldo,
	estado,
	created_at',
		'fromListSql' => 'FROM
	cuentas',
		'orderBySql' => '',
		'tailSql' => '' 
	),
	'originalTable' => 'cuentas',
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
		'masterlist' => array( 
			'masterlist' 
		),
		'masterprint' => array( 
			'masterprint' 
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
		'masterlist' => 'masterlist',
		'masterprint' => 'masterprint',
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
		'masterlist' => 'masterlist',
		'masterprint' => 'masterprint',
		'search' => 'search' 
	),
	'searchSettings' => array(
		'caseSensitiveSearch' => false,
		'searchableFields' => array( 
			'id',
			'socio_id',
			'numero_cuenta',
			'tipo',
			'saldo',
			'estado',
			'created_at' 
		),
		'searchSuggest' => true,
		'highlightSearchResults' => true,
		'hideDataUntilSearch' => false,
		'hideFilterUntilSearch' => false,
		'googleLikeSearchFields' => array( 
			'id',
			'socio_id',
			'numero_cuenta',
			'tipo',
			'saldo',
			'estado',
			'created_at' 
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
	$runnerTableLabels['cuentas'] = array(
	'tableCaption' => 'Cuentas',
	'fieldLabels' => array(
		'id' => 'Id',
		'socio_id' => 'Socio Id',
		'numero_cuenta' => 'Numero Cuenta',
		'tipo' => 'Tipo',
		'saldo' => 'Saldo',
		'estado' => 'Estado',
		'created_at' => 'Created At' 
	),
	'fieldTooltips' => array(
		'id' => '',
		'socio_id' => '',
		'numero_cuenta' => '',
		'tipo' => '',
		'saldo' => '',
		'estado' => '',
		'created_at' => '' 
	),
	'fieldPlaceholders' => array(
		'id' => '',
		'socio_id' => '',
		'numero_cuenta' => '',
		'tipo' => '',
		'saldo' => '',
		'estado' => '',
		'created_at' => '' 
	),
	'pageTitles' => array(
		 
	) 
);
}
?>