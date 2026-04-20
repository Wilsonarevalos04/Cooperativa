<?php
global $runnerTableSettings;
$runnerTableSettings['auditoria'] = array(
	'name' => 'auditoria',
	'shortName' => 'auditoria',
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
	'afterEditDetails' => 'auditoria',
	'afterAddDetail' => 'auditoria',
	'detailsBadgeColor' => '4169e1',
	'sql' => 'SELECT
	id,
	usuario_id,
	accion,
	tabla_afectada,
	fecha
FROM
	auditoria',
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
			'tableName' => 'auditoria' 
		),
		'usuario_id' => array(
			'name' => 'usuario_id',
			'goodName' => 'usuario_id',
			'strField' => 'usuario_id',
			'index' => 2,
			'type' => 3,
			'sqlExpression' => 'usuario_id',
			'viewFormats' => array(
				'view' => array(
					'viewLink' => true 
				) 
			),
			'editFormats' => array(
				'edit' => array(
					'format' => 'Lookup wizard',
					'lookupType' => 2,
					'lookupTable' => 'usuarios',
					'lookupTableConnection' => 'conn',
					'lookupLinkField' => 'id',
					'lookupDisplayField' => 'nombre' 
				) 
			),
			'tableName' => 'auditoria',
			'viewLinkTable' => 'usuarios',
			'viewLinkLookup' => true 
		),
		'accion' => array(
			'name' => 'accion',
			'goodName' => 'accion',
			'strField' => 'accion',
			'index' => 3,
			'type' => 201,
			'sqlExpression' => 'accion',
			'viewFormats' => array(
				'view' => array(
					 
				) 
			),
			'editFormats' => array(
				'edit' => array(
					'format' => 'Text area' 
				) 
			),
			'tableName' => 'auditoria' 
		),
		'tabla_afectada' => array(
			'name' => 'tabla_afectada',
			'goodName' => 'tabla_afectada',
			'strField' => 'tabla_afectada',
			'index' => 4,
			'sqlExpression' => 'tabla_afectada',
			'viewFormats' => array(
				'view' => array(
					 
				) 
			),
			'editFormats' => array(
				'edit' => array(
					 
				) 
			),
			'tableName' => 'auditoria' 
		),
		'fecha' => array(
			'name' => 'fecha',
			'goodName' => 'fecha',
			'strField' => 'fecha',
			'index' => 5,
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
			'tableName' => 'auditoria' 
		) 
	),
	'masterTables' => array( 
		array(
			'table' => 'usuarios',
			'detailsKeys' => array( 
				'usuario_id' 
			),
			'masterKeys' => array( 
				'id' 
			) 
		) 
	),
	'query' => array(
		'sql' => 'SELECT
	id,
	usuario_id,
	accion,
	tabla_afectada,
	fecha
FROM
	auditoria',
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
					'table' => 'auditoria',
					'name' => 'id' 
				),
				'encrypted' => false,
				'columnName' => 'id' 
			),
			array(
				'sql' => 'usuario_id',
				'parsed' => true,
				'type' => 'FieldListItem',
				'alias' => '',
				'expression' => array(
					'sql' => '',
					'parsed' => true,
					'type' => 'SQLField',
					'table' => 'auditoria',
					'name' => 'usuario_id' 
				),
				'encrypted' => false,
				'columnName' => 'usuario_id' 
			),
			array(
				'sql' => 'accion',
				'parsed' => true,
				'type' => 'FieldListItem',
				'alias' => '',
				'expression' => array(
					'sql' => '',
					'parsed' => true,
					'type' => 'SQLField',
					'table' => 'auditoria',
					'name' => 'accion' 
				),
				'encrypted' => false,
				'columnName' => 'accion' 
			),
			array(
				'sql' => 'tabla_afectada',
				'parsed' => true,
				'type' => 'FieldListItem',
				'alias' => '',
				'expression' => array(
					'sql' => '',
					'parsed' => true,
					'type' => 'SQLField',
					'table' => 'auditoria',
					'name' => 'tabla_afectada' 
				),
				'encrypted' => false,
				'columnName' => 'tabla_afectada' 
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
					'table' => 'auditoria',
					'name' => 'fecha' 
				),
				'encrypted' => false,
				'columnName' => 'fecha' 
			) 
		),
		'fromList' => array( 
			array(
				'sql' => 'auditoria',
				'parsed' => true,
				'type' => 'FromListItem',
				'table' => array(
					'sql' => 'auditoria',
					'parsed' => true,
					'type' => 'SQLTable',
					'columns' => array( 
						'id',
						'usuario_id',
						'accion',
						'tabla_afectada',
						'fecha' 
					),
					'name' => 'auditoria' 
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
	usuario_id,
	accion,
	tabla_afectada,
	fecha',
		'fromListSql' => 'FROM
	auditoria',
		'orderBySql' => '',
		'tailSql' => '' 
	),
	'originalTable' => 'auditoria',
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
			'usuario_id',
			'accion',
			'tabla_afectada',
			'fecha' 
		),
		'searchSuggest' => true,
		'highlightSearchResults' => true,
		'hideDataUntilSearch' => false,
		'hideFilterUntilSearch' => false,
		'googleLikeSearchFields' => array( 
			'id',
			'usuario_id',
			'accion',
			'tabla_afectada',
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
	$runnerTableLabels['auditoria'] = array(
	'tableCaption' => 'Auditoria',
	'fieldLabels' => array(
		'id' => 'Id',
		'usuario_id' => 'Usuario Id',
		'accion' => 'Accion',
		'tabla_afectada' => 'Tabla Afectada',
		'fecha' => 'Fecha' 
	),
	'fieldTooltips' => array(
		'id' => '',
		'usuario_id' => '',
		'accion' => '',
		'tabla_afectada' => '',
		'fecha' => '' 
	),
	'fieldPlaceholders' => array(
		'id' => '',
		'usuario_id' => '',
		'accion' => '',
		'tabla_afectada' => '',
		'fecha' => '' 
	),
	'pageTitles' => array(
		 
	) 
);
}
?>