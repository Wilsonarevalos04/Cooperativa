<?php
global $runnerTableSettings;
$runnerTableSettings['transacciones'] = array(
	'name' => 'transacciones',
	'shortName' => 'transacciones',
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
	'afterEditDetails' => 'transacciones',
	'afterAddDetail' => 'transacciones',
	'detailsBadgeColor' => '6493ea',
	'sql' => 'SELECT
	id,
	cuenta_id,
	tipo,
	monto,
	descripcion,
	fecha
FROM
	transacciones',
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
			'tableName' => 'transacciones' 
		),
		'cuenta_id' => array(
			'name' => 'cuenta_id',
			'goodName' => 'cuenta_id',
			'strField' => 'cuenta_id',
			'index' => 2,
			'type' => 3,
			'sqlExpression' => 'cuenta_id',
			'viewFormats' => array(
				'view' => array(
					'viewLink' => true 
				) 
			),
			'editFormats' => array(
				'edit' => array(
					'format' => 'Lookup wizard',
					'lookupType' => 2,
					'lookupTable' => 'cuentas',
					'lookupTableConnection' => 'conn',
					'lookupLinkField' => 'id',
					'lookupDisplayField' => 'numero_cuenta' 
				) 
			),
			'tableName' => 'transacciones',
			'viewLinkTable' => 'cuentas',
			'viewLinkLookup' => true 
		),
		'tipo' => array(
			'name' => 'tipo',
			'goodName' => 'tipo',
			'strField' => 'tipo',
			'index' => 3,
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
						'deposito',
						'retiro',
						'transferencia' 
					) 
				) 
			),
			'tableName' => 'transacciones' 
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
			'tableName' => 'transacciones' 
		),
		'descripcion' => array(
			'name' => 'descripcion',
			'goodName' => 'descripcion',
			'strField' => 'descripcion',
			'index' => 5,
			'type' => 201,
			'sqlExpression' => 'descripcion',
			'viewFormats' => array(
				'view' => array(
					 
				) 
			),
			'editFormats' => array(
				'edit' => array(
					'format' => 'Text area' 
				) 
			),
			'tableName' => 'transacciones' 
		),
		'fecha' => array(
			'name' => 'fecha',
			'goodName' => 'fecha',
			'strField' => 'fecha',
			'index' => 6,
			'type' => 135,
			'sqlExpression' => 'fecha',
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
			'tableName' => 'transacciones' 
		) 
	),
	'masterTables' => array( 
		array(
			'table' => 'cuentas',
			'detailsKeys' => array( 
				'cuenta_id' 
			),
			'masterKeys' => array( 
				'id' 
			) 
		) 
	),
	'query' => array(
		'sql' => 'SELECT
	id,
	cuenta_id,
	tipo,
	monto,
	descripcion,
	fecha
FROM
	transacciones',
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
					'table' => 'transacciones',
					'name' => 'id' 
				),
				'encrypted' => false,
				'columnName' => 'id' 
			),
			array(
				'sql' => 'cuenta_id',
				'parsed' => true,
				'type' => 'FieldListItem',
				'alias' => '',
				'expression' => array(
					'sql' => '',
					'parsed' => true,
					'type' => 'SQLField',
					'table' => 'transacciones',
					'name' => 'cuenta_id' 
				),
				'encrypted' => false,
				'columnName' => 'cuenta_id' 
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
					'table' => 'transacciones',
					'name' => 'tipo' 
				),
				'encrypted' => false,
				'columnName' => 'tipo' 
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
					'table' => 'transacciones',
					'name' => 'monto' 
				),
				'encrypted' => false,
				'columnName' => 'monto' 
			),
			array(
				'sql' => 'descripcion',
				'parsed' => true,
				'type' => 'FieldListItem',
				'alias' => '',
				'expression' => array(
					'sql' => '',
					'parsed' => true,
					'type' => 'SQLField',
					'table' => 'transacciones',
					'name' => 'descripcion' 
				),
				'encrypted' => false,
				'columnName' => 'descripcion' 
			),
			array(
				'sql' => 'fecha',
				'parsed' => true,
				'type' => 'FieldListItem',
				'alias' => '',
				'expression' => array(
					'sql' => '',
					'parsed' => true,
					'type' => 'SQLField',
					'table' => 'transacciones',
					'name' => 'fecha' 
				),
				'encrypted' => false,
				'columnName' => 'fecha' 
			) 
		),
		'fromList' => array( 
			array(
				'sql' => 'transacciones',
				'parsed' => true,
				'type' => 'FromListItem',
				'table' => array(
					'sql' => 'transacciones',
					'parsed' => true,
					'type' => 'SQLTable',
					'columns' => array( 
						'id',
						'cuenta_id',
						'tipo',
						'monto',
						'descripcion',
						'fecha' 
					),
					'name' => 'transacciones' 
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
	cuenta_id,
	tipo,
	monto,
	descripcion,
	fecha',
		'fromListSql' => 'FROM
	transacciones',
		'orderBySql' => '',
		'tailSql' => '' 
	),
	'originalTable' => 'transacciones',
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
			'cuenta_id',
			'tipo',
			'monto',
			'descripcion',
			'fecha' 
		),
		'searchSuggest' => true,
		'highlightSearchResults' => true,
		'hideDataUntilSearch' => false,
		'hideFilterUntilSearch' => false,
		'googleLikeSearchFields' => array( 
			'id',
			'cuenta_id',
			'tipo',
			'monto',
			'descripcion',
			'fecha' 
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
	$runnerTableLabels['transacciones'] = array(
	'tableCaption' => 'Transacciones',
	'fieldLabels' => array(
		'id' => 'Id',
		'cuenta_id' => 'Cuenta Id',
		'tipo' => 'Tipo',
		'monto' => 'Monto',
		'descripcion' => 'Descripcion',
		'fecha' => 'Fecha' 
	),
	'fieldTooltips' => array(
		'id' => '',
		'cuenta_id' => '',
		'tipo' => '',
		'monto' => '',
		'descripcion' => '',
		'fecha' => '' 
	),
	'fieldPlaceholders' => array(
		'id' => '',
		'cuenta_id' => '',
		'tipo' => '',
		'monto' => '',
		'descripcion' => '',
		'fecha' => '' 
	),
	'pageTitles' => array(
		 
	) 
);
}
?>