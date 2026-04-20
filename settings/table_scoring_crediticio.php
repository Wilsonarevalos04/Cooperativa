<?php
global $runnerTableSettings;
$runnerTableSettings['scoring_crediticio'] = array(
	'name' => 'scoring_crediticio',
	'shortName' => 'scoring_crediticio',
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
	'afterEditDetails' => 'scoring_crediticio',
	'afterAddDetail' => 'scoring_crediticio',
	'detailsBadgeColor' => '7b68ee',
	'sql' => 'SELECT
	id,
	socio_id,
	puntaje,
	riesgo,
	fecha
FROM
	scoring_crediticio',
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
			'tableName' => 'scoring_crediticio' 
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
			'tableName' => 'scoring_crediticio',
			'viewLinkTable' => 'socios',
			'viewLinkLookup' => true 
		),
		'puntaje' => array(
			'name' => 'puntaje',
			'goodName' => 'puntaje',
			'strField' => 'puntaje',
			'index' => 3,
			'type' => 3,
			'sqlExpression' => 'puntaje',
			'viewFormats' => array(
				'view' => array(
					 
				) 
			),
			'editFormats' => array(
				'edit' => array(
					 
				) 
			),
			'tableName' => 'scoring_crediticio' 
		),
		'riesgo' => array(
			'name' => 'riesgo',
			'goodName' => 'riesgo',
			'strField' => 'riesgo',
			'index' => 4,
			'type' => 129,
			'sqlExpression' => 'riesgo',
			'viewFormats' => array(
				'view' => array(
					 
				) 
			),
			'editFormats' => array(
				'edit' => array(
					'format' => 'Lookup wizard',
					'lookupType' => 0,
					'lookupValues' => array( 
						'bajo',
						'medio',
						'alto' 
					) 
				) 
			),
			'tableName' => 'scoring_crediticio' 
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
			'tableName' => 'scoring_crediticio' 
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
	puntaje,
	riesgo,
	fecha
FROM
	scoring_crediticio',
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
					'table' => 'scoring_crediticio',
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
					'table' => 'scoring_crediticio',
					'name' => 'socio_id' 
				),
				'encrypted' => false,
				'columnName' => 'socio_id' 
			),
			array(
				'sql' => 'puntaje',
				'parsed' => true,
				'type' => 'FieldListItem',
				'alias' => '',
				'expression' => array(
					'sql' => '',
					'parsed' => true,
					'type' => 'SQLField',
					'table' => 'scoring_crediticio',
					'name' => 'puntaje' 
				),
				'encrypted' => false,
				'columnName' => 'puntaje' 
			),
			array(
				'sql' => 'riesgo',
				'parsed' => true,
				'type' => 'FieldListItem',
				'alias' => '',
				'expression' => array(
					'sql' => '',
					'parsed' => true,
					'type' => 'SQLField',
					'table' => 'scoring_crediticio',
					'name' => 'riesgo' 
				),
				'encrypted' => false,
				'columnName' => 'riesgo' 
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
					'table' => 'scoring_crediticio',
					'name' => 'fecha' 
				),
				'encrypted' => false,
				'columnName' => 'fecha' 
			) 
		),
		'fromList' => array( 
			array(
				'sql' => 'scoring_crediticio',
				'parsed' => true,
				'type' => 'FromListItem',
				'table' => array(
					'sql' => 'scoring_crediticio',
					'parsed' => true,
					'type' => 'SQLTable',
					'columns' => array( 
						'id',
						'socio_id',
						'puntaje',
						'riesgo',
						'fecha' 
					),
					'name' => 'scoring_crediticio' 
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
	socio_id,
	puntaje,
	riesgo,
	fecha',
		'fromListSql' => 'FROM
	scoring_crediticio',
		'orderBySql' => '',
		'tailSql' => '' 
	),
	'originalTable' => 'scoring_crediticio',
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
			'puntaje',
			'riesgo',
			'fecha' 
		),
		'searchSuggest' => true,
		'highlightSearchResults' => true,
		'hideDataUntilSearch' => false,
		'hideFilterUntilSearch' => false,
		'googleLikeSearchFields' => array( 
			'id',
			'socio_id',
			'puntaje',
			'riesgo',
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
	$runnerTableLabels['scoring_crediticio'] = array(
	'tableCaption' => 'Scoring Crediticio',
	'fieldLabels' => array(
		'id' => 'Id',
		'socio_id' => 'Socio Id',
		'puntaje' => 'Puntaje',
		'riesgo' => 'Riesgo',
		'fecha' => 'Fecha' 
	),
	'fieldTooltips' => array(
		'id' => '',
		'socio_id' => '',
		'puntaje' => '',
		'riesgo' => '',
		'fecha' => '' 
	),
	'fieldPlaceholders' => array(
		'id' => '',
		'socio_id' => '',
		'puntaje' => '',
		'riesgo' => '',
		'fecha' => '' 
	),
	'pageTitles' => array(
		 
	) 
);
}
?>