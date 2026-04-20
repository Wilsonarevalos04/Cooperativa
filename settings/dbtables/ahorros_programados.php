<?php
global $runnerDbTableInfo;
$runnerDbTableInfo['ahorros_programados'] = array(
	'type' => 0,
	'foreignKeys' => array( 
		array(
			'name' => 'ahorros_programados_ibfk_1',
			'refTable' => 'socios',
			'refSchema' => '',
			'del_rule' => 1,
			'columns' => array( 
				array(
					'column' => 'socio_id',
					'ref_column' => 'id' 
				) 
			) 
		) 
	),
	'fields' => array( 
		array(
			'name' => 'id',
			'type' => 3,
			'size' => 0,
			'scale' => 0,
			'typeName' => 'int',
			'nullable' => false,
			'autoinc' => true,
			'defaultValueSQL' => null,
			'defaultValue' => '' 
		),
		array(
			'name' => 'socio_id',
			'type' => 3,
			'size' => 0,
			'scale' => 0,
			'typeName' => 'int',
			'nullable' => true,
			'autoinc' => false,
			'defaultValueSQL' => null,
			'defaultValue' => '' 
		),
		array(
			'name' => 'monto_mensual',
			'type' => 14,
			'size' => 12,
			'scale' => 2,
			'typeName' => 'decimal(12,2)',
			'nullable' => true,
			'autoinc' => false,
			'defaultValueSQL' => null,
			'defaultValue' => '' 
		),
		array(
			'name' => 'plazo_meses',
			'type' => 3,
			'size' => 0,
			'scale' => 0,
			'typeName' => 'int',
			'nullable' => true,
			'autoinc' => false,
			'defaultValueSQL' => null,
			'defaultValue' => '' 
		),
		array(
			'name' => 'fecha_inicio',
			'type' => 7,
			'size' => 0,
			'scale' => 0,
			'typeName' => 'date',
			'nullable' => true,
			'autoinc' => false,
			'defaultValueSQL' => null,
			'defaultValue' => '' 
		),
		array(
			'name' => 'estado',
			'type' => 129,
			'size' => 0,
			'scale' => 0,
			'typeName' => 'enum(\'activo\',\'finalizado\',\'cancelado\')',
			'enumValues' => array( 
				'activo',
				'finalizado',
				'cancelado' 
			),
			'nullable' => true,
			'autoinc' => false,
			'defaultValueSQL' => '\'activo\'',
			'defaultValue' => 'activo' 
		) 
	),
	'primaryKeys' => array( 
		'id' 
	),
	'uniqueFields' => array( 
		 
	),
	'name' => 'ahorros_programados' 
);
?>