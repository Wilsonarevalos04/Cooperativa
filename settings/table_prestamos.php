<?php
global $runnerTableSettings;
$runnerTableSettings['prestamos'] = array(
	'name' => 'prestamos',
	'shortName' => 'prestamos',
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
	'afterEditDetails' => 'prestamos',
	'afterAddDetail' => 'prestamos',
	'detailsBadgeColor' => 'dc143c',
	'sql' => 'SELECT
	id,
	socio_id,
	monto,
	interes,
	plazo_meses,
	estado,
	fecha_solicitud
FROM
	prestamos',
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
			'tableName' => 'prestamos' 
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
			'tableName' => 'prestamos',
			'viewLinkTable' => 'socios',
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
			'tableName' => 'prestamos' 
		),
		'interes' => array(
			'name' => 'interes',
			'goodName' => 'interes',
			'strField' => 'interes',
			'index' => 4,
			'type' => 14,
			'sqlExpression' => 'interes',
			'viewFormats' => array(
				'view' => array(
					'format' => 'Number' 
				) 
			),
			'editFormats' => array(
				'edit' => array(
					 
				) 
			),
			'tableName' => 'prestamos' 
		),
		'plazo_meses' => array(
			'name' => 'plazo_meses',
			'goodName' => 'plazo_meses',
			'strField' => 'plazo_meses',
			'index' => 5,
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
			'tableName' => 'prestamos' 
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
						'aprobado',
						'rechazado',
						'pagado' 
					) 
				) 
			),
			'tableName' => 'prestamos' 
		),
		'fecha_solicitud' => array(
			'name' => 'fecha_solicitud',
			'goodName' => 'fecha_solicitud',
			'strField' => 'fecha_solicitud',
			'index' => 7,
			'type' => 7,
			'sqlExpression' => 'fecha_solicitud',
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
			'tableName' => 'prestamos' 
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
		'cuotas',
		'pagos' 
	),
	'query' => array(
		'sql' => 'SELECT
	id,
	socio_id,
	monto,
	interes,
	plazo_meses,
	estado,
	fecha_solicitud
FROM
	prestamos',
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
					'table' => 'prestamos',
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
					'table' => 'prestamos',
					'name' => 'socio_id' 
				),
				'encrypted' => false,
				'columnName' => 'socio_id' 
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
					'table' => 'prestamos',
					'name' => 'monto' 
				),
				'encrypted' => false,
				'columnName' => 'monto' 
			),
			array(
				'sql' => 'interes',
				'parsed' => true,
				'type' => 'FieldListItem',
				'alias' => '',
				'expression' => array(
					'sql' => '',
					'parsed' => true,
					'type' => 'SQLField',
					'table' => 'prestamos',
					'name' => 'interes' 
				),
				'encrypted' => false,
				'columnName' => 'interes' 
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
					'table' => 'prestamos',
					'name' => 'plazo_meses' 
				),
				'encrypted' => false,
				'columnName' => 'plazo_meses' 
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
					'table' => 'prestamos',
					'name' => 'estado' 
				),
				'encrypted' => false,
				'columnName' => 'estado' 
			),
			array(
				'sql' => 'fecha_solicitud',
				'parsed' => true,
				'type' => 'FieldListItem',
				'alias' => '',
				'expression' => array(
					'sql' => '',
					'parsed' => true,
					'type' => 'SQLField',
					'table' => 'prestamos',
					'name' => 'fecha_solicitud' 
				),
				'encrypted' => false,
				'columnName' => 'fecha_solicitud' 
			) 
		),
		'fromList' => array( 
			array(
				'sql' => 'prestamos',
				'parsed' => true,
				'type' => 'FromListItem',
				'table' => array(
					'sql' => 'prestamos',
					'parsed' => true,
					'type' => 'SQLTable',
					'columns' => array( 
						'id',
						'socio_id',
						'monto',
						'interes',
						'plazo_meses',
						'estado',
						'fecha_solicitud' 
					),
					'name' => 'prestamos' 
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
	monto,
	interes,
	plazo_meses,
	estado,
	fecha_solicitud',
		'fromListSql' => 'FROM
	prestamos',
		'orderBySql' => '',
		'tailSql' => '' 
	),
	'originalTable' => 'prestamos',
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
			'monto',
			'interes',
			'plazo_meses',
			'estado',
			'fecha_solicitud' 
		),
		'searchSuggest' => true,
		'highlightSearchResults' => true,
		'hideDataUntilSearch' => false,
		'hideFilterUntilSearch' => false,
		'googleLikeSearchFields' => array( 
			'id',
			'socio_id',
			'monto',
			'interes',
			'plazo_meses',
			'estado',
			'fecha_solicitud' 
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
	$runnerTableLabels['prestamos'] = array(
	'tableCaption' => 'Prestamos',
	'fieldLabels' => array(
		'id' => 'Id',
		'socio_id' => 'Socio Id',
		'monto' => 'Monto',
		'interes' => 'Interes',
		'plazo_meses' => 'Plazo Meses',
		'estado' => 'Estado',
		'fecha_solicitud' => 'Fecha Solicitud' 
	),
	'fieldTooltips' => array(
		'id' => '',
		'socio_id' => '',
		'monto' => '',
		'interes' => '',
		'plazo_meses' => '',
		'estado' => '',
		'fecha_solicitud' => '' 
	),
	'fieldPlaceholders' => array(
		'id' => '',
		'socio_id' => '',
		'monto' => '',
		'interes' => '',
		'plazo_meses' => '',
		'estado' => '',
		'fecha_solicitud' => '' 
	),
	'pageTitles' => array(
		 
	) 
);
}
?>