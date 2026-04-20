<?php
global $runnerTableSettings;
$runnerTableSettings['socios'] = array(
	'name' => 'socios',
	'shortName' => 'socios',
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
	'afterEditDetails' => 'socios',
	'afterAddDetail' => 'socios',
	'detailsBadgeColor' => 'db7093',
	'sql' => 'SELECT
	id,
	cedula,
	nombre,
	apellido,
	direccion,
	telefono,
	email,
	fecha_ingreso,
	estado
FROM
	socios',
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
			'tableName' => 'socios' 
		),
		'cedula' => array(
			'name' => 'cedula',
			'goodName' => 'cedula',
			'strField' => 'cedula',
			'index' => 2,
			'sqlExpression' => 'cedula',
			'viewFormats' => array(
				'view' => array(
					 
				) 
			),
			'editFormats' => array(
				'edit' => array(
					 
				) 
			),
			'tableName' => 'socios' 
		),
		'nombre' => array(
			'name' => 'nombre',
			'goodName' => 'nombre',
			'strField' => 'nombre',
			'index' => 3,
			'sqlExpression' => 'nombre',
			'viewFormats' => array(
				'view' => array(
					 
				) 
			),
			'editFormats' => array(
				'edit' => array(
					 
				) 
			),
			'tableName' => 'socios' 
		),
		'apellido' => array(
			'name' => 'apellido',
			'goodName' => 'apellido',
			'strField' => 'apellido',
			'index' => 4,
			'sqlExpression' => 'apellido',
			'viewFormats' => array(
				'view' => array(
					 
				) 
			),
			'editFormats' => array(
				'edit' => array(
					 
				) 
			),
			'tableName' => 'socios' 
		),
		'direccion' => array(
			'name' => 'direccion',
			'goodName' => 'direccion',
			'strField' => 'direccion',
			'index' => 5,
			'type' => 201,
			'sqlExpression' => 'direccion',
			'viewFormats' => array(
				'view' => array(
					 
				) 
			),
			'editFormats' => array(
				'edit' => array(
					'format' => 'Text area' 
				) 
			),
			'tableName' => 'socios' 
		),
		'telefono' => array(
			'name' => 'telefono',
			'goodName' => 'telefono',
			'strField' => 'telefono',
			'index' => 6,
			'sqlExpression' => 'telefono',
			'viewFormats' => array(
				'view' => array(
					 
				) 
			),
			'editFormats' => array(
				'edit' => array(
					 
				) 
			),
			'tableName' => 'socios' 
		),
		'email' => array(
			'name' => 'email',
			'goodName' => 'email',
			'strField' => 'email',
			'index' => 7,
			'sqlExpression' => 'email',
			'viewFormats' => array(
				'view' => array(
					 
				) 
			),
			'editFormats' => array(
				'edit' => array(
					 
				) 
			),
			'tableName' => 'socios' 
		),
		'fecha_ingreso' => array(
			'name' => 'fecha_ingreso',
			'goodName' => 'fecha_ingreso',
			'strField' => 'fecha_ingreso',
			'index' => 8,
			'type' => 7,
			'sqlExpression' => 'fecha_ingreso',
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
			'tableName' => 'socios' 
		),
		'estado' => array(
			'name' => 'estado',
			'goodName' => 'estado',
			'strField' => 'estado',
			'index' => 9,
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
						'inactivo' 
					) 
				) 
			),
			'tableName' => 'socios' 
		) 
	),
	'detailsTables' => array( 
		'ahorros_programados',
		'cuentas',
		'prestamos',
		'scoring_crediticio' 
	),
	'query' => array(
		'sql' => 'SELECT
	id,
	cedula,
	nombre,
	apellido,
	direccion,
	telefono,
	email,
	fecha_ingreso,
	estado
FROM
	socios',
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
					'table' => 'socios',
					'name' => 'id' 
				),
				'encrypted' => false,
				'columnName' => 'id' 
			),
			array(
				'sql' => 'cedula',
				'parsed' => true,
				'type' => 'FieldListItem',
				'alias' => '',
				'expression' => array(
					'sql' => '',
					'parsed' => true,
					'type' => 'SQLField',
					'table' => 'socios',
					'name' => 'cedula' 
				),
				'encrypted' => false,
				'columnName' => 'cedula' 
			),
			array(
				'sql' => 'nombre',
				'parsed' => true,
				'type' => 'FieldListItem',
				'alias' => '',
				'expression' => array(
					'sql' => '',
					'parsed' => true,
					'type' => 'SQLField',
					'table' => 'socios',
					'name' => 'nombre' 
				),
				'encrypted' => false,
				'columnName' => 'nombre' 
			),
			array(
				'sql' => 'apellido',
				'parsed' => true,
				'type' => 'FieldListItem',
				'alias' => '',
				'expression' => array(
					'sql' => '',
					'parsed' => true,
					'type' => 'SQLField',
					'table' => 'socios',
					'name' => 'apellido' 
				),
				'encrypted' => false,
				'columnName' => 'apellido' 
			),
			array(
				'sql' => 'direccion',
				'parsed' => true,
				'type' => 'FieldListItem',
				'alias' => '',
				'expression' => array(
					'sql' => '',
					'parsed' => true,
					'type' => 'SQLField',
					'table' => 'socios',
					'name' => 'direccion' 
				),
				'encrypted' => false,
				'columnName' => 'direccion' 
			),
			array(
				'sql' => 'telefono',
				'parsed' => true,
				'type' => 'FieldListItem',
				'alias' => '',
				'expression' => array(
					'sql' => '',
					'parsed' => true,
					'type' => 'SQLField',
					'table' => 'socios',
					'name' => 'telefono' 
				),
				'encrypted' => false,
				'columnName' => 'telefono' 
			),
			array(
				'sql' => 'email',
				'parsed' => true,
				'type' => 'FieldListItem',
				'alias' => '',
				'expression' => array(
					'sql' => '',
					'parsed' => true,
					'type' => 'SQLField',
					'table' => 'socios',
					'name' => 'email' 
				),
				'encrypted' => false,
				'columnName' => 'email' 
			),
			array(
				'sql' => 'fecha_ingreso',
				'parsed' => true,
				'type' => 'FieldListItem',
				'alias' => '',
				'expression' => array(
					'sql' => '',
					'parsed' => true,
					'type' => 'SQLField',
					'table' => 'socios',
					'name' => 'fecha_ingreso' 
				),
				'encrypted' => false,
				'columnName' => 'fecha_ingreso' 
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
					'table' => 'socios',
					'name' => 'estado' 
				),
				'encrypted' => false,
				'columnName' => 'estado' 
			) 
		),
		'fromList' => array( 
			array(
				'sql' => 'socios',
				'parsed' => true,
				'type' => 'FromListItem',
				'table' => array(
					'sql' => 'socios',
					'parsed' => true,
					'type' => 'SQLTable',
					'columns' => array( 
						'id',
						'cedula',
						'nombre',
						'apellido',
						'direccion',
						'telefono',
						'email',
						'fecha_ingreso',
						'estado' 
					),
					'name' => 'socios' 
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
			),
			array(
				'fieldIndex' => 7,
				'orderByIndex' => -1,
				'groupByIndex' => -1,
				'whereIndex' => -1,
				'havingIndex' => -1 
			),
			array(
				'fieldIndex' => 8,
				'orderByIndex' => -1,
				'groupByIndex' => -1,
				'whereIndex' => -1,
				'havingIndex' => -1 
			) 
		),
		'headSql' => 'SELECT',
		'fieldListSql' => 'id,
	cedula,
	nombre,
	apellido,
	direccion,
	telefono,
	email,
	fecha_ingreso,
	estado',
		'fromListSql' => 'FROM
	socios',
		'orderBySql' => '',
		'tailSql' => '' 
	),
	'originalTable' => 'socios',
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
			'cedula',
			'nombre',
			'apellido',
			'direccion',
			'telefono',
			'email',
			'fecha_ingreso',
			'estado' 
		),
		'searchSuggest' => true,
		'highlightSearchResults' => true,
		'hideDataUntilSearch' => false,
		'hideFilterUntilSearch' => false,
		'googleLikeSearchFields' => array( 
			'id',
			'cedula',
			'nombre',
			'apellido',
			'direccion',
			'telefono',
			'email',
			'fecha_ingreso',
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
	$runnerTableLabels['socios'] = array(
	'tableCaption' => 'Socios',
	'fieldLabels' => array(
		'id' => 'Id',
		'cedula' => 'Cedula',
		'nombre' => 'Nombre',
		'apellido' => 'Apellido',
		'direccion' => 'Direccion',
		'telefono' => 'Telefono',
		'email' => 'Email',
		'fecha_ingreso' => 'Fecha Ingreso',
		'estado' => 'Estado' 
	),
	'fieldTooltips' => array(
		'id' => '',
		'cedula' => '',
		'nombre' => '',
		'apellido' => '',
		'direccion' => '',
		'telefono' => '',
		'email' => '',
		'fecha_ingreso' => '',
		'estado' => '' 
	),
	'fieldPlaceholders' => array(
		'id' => '',
		'cedula' => '',
		'nombre' => '',
		'apellido' => '',
		'direccion' => '',
		'telefono' => '',
		'email' => '',
		'fecha_ingreso' => '',
		'estado' => '' 
	),
	'pageTitles' => array(
		 
	) 
);
}
?>