<?php
global $runnerTableSettings;
$runnerTableSettings['usuario_roles'] = array(
	'name' => 'usuario_roles',
	'shortName' => 'usuario_roles',
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
	'afterEditDetails' => 'usuario_roles',
	'afterAddDetail' => 'usuario_roles',
	'detailsBadgeColor' => 'e07878',
	'sql' => 'SELECT
	id,
	usuario_id,
	rol_id
FROM
	usuario_roles',
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
			'tableName' => 'usuario_roles' 
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
			'tableName' => 'usuario_roles',
			'viewLinkTable' => 'usuarios',
			'viewLinkLookup' => true 
		),
		'rol_id' => array(
			'name' => 'rol_id',
			'goodName' => 'rol_id',
			'strField' => 'rol_id',
			'index' => 3,
			'type' => 3,
			'sqlExpression' => 'rol_id',
			'viewFormats' => array(
				'view' => array(
					'viewLink' => true 
				) 
			),
			'editFormats' => array(
				'edit' => array(
					'format' => 'Lookup wizard',
					'lookupType' => 2,
					'lookupTable' => 'roles',
					'lookupTableConnection' => 'conn',
					'lookupLinkField' => 'id',
					'lookupDisplayField' => 'nombre' 
				) 
			),
			'tableName' => 'usuario_roles',
			'viewLinkTable' => 'roles',
			'viewLinkLookup' => true 
		) 
	),
	'masterTables' => array( 
		array(
			'table' => 'roles',
			'detailsKeys' => array( 
				'rol_id' 
			),
			'masterKeys' => array( 
				'id' 
			) 
		),
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
	rol_id
FROM
	usuario_roles',
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
					'table' => 'usuario_roles',
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
					'table' => 'usuario_roles',
					'name' => 'usuario_id' 
				),
				'encrypted' => false,
				'columnName' => 'usuario_id' 
			),
			array(
				'sql' => 'rol_id',
				'parsed' => true,
				'type' => 'FieldListItem',
				'alias' => '',
				'expression' => array(
					'sql' => '',
					'parsed' => true,
					'type' => 'SQLField',
					'table' => 'usuario_roles',
					'name' => 'rol_id' 
				),
				'encrypted' => false,
				'columnName' => 'rol_id' 
			) 
		),
		'fromList' => array( 
			array(
				'sql' => 'usuario_roles',
				'parsed' => true,
				'type' => 'FromListItem',
				'table' => array(
					'sql' => 'usuario_roles',
					'parsed' => true,
					'type' => 'SQLTable',
					'columns' => array( 
						'id',
						'usuario_id',
						'rol_id' 
					),
					'name' => 'usuario_roles' 
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
			) 
		),
		'headSql' => 'SELECT',
		'fieldListSql' => 'id,
	usuario_id,
	rol_id',
		'fromListSql' => 'FROM
	usuario_roles',
		'orderBySql' => '',
		'tailSql' => '' 
	),
	'originalTable' => 'usuario_roles',
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
			'rol_id' 
		),
		'searchSuggest' => true,
		'highlightSearchResults' => true,
		'hideDataUntilSearch' => false,
		'hideFilterUntilSearch' => false,
		'googleLikeSearchFields' => array( 
			'id',
			'usuario_id',
			'rol_id' 
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
	$runnerTableLabels['usuario_roles'] = array(
	'tableCaption' => 'Usuario Roles',
	'fieldLabels' => array(
		'id' => 'Id',
		'usuario_id' => 'Usuario Id',
		'rol_id' => 'Rol Id' 
	),
	'fieldTooltips' => array(
		'id' => '',
		'usuario_id' => '',
		'rol_id' => '' 
	),
	'fieldPlaceholders' => array(
		'id' => '',
		'usuario_id' => '',
		'rol_id' => '' 
	),
	'pageTitles' => array(
		 
	) 
);
}
?>