<?php
global $runnerDbTableInfo;
$runnerDbTableInfo['cuentas'] = array(
	'type' => 0,
	'foreignKeys' => array( 
		array(
			'name' => 'cuentas_ibfk_1',
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
			'name' => 'numero_cuenta',
			'type' => 200,
			'size' => 50,
			'scale' => 0,
			'typeName' => 'varchar(50)',
			'nullable' => true,
			'autoinc' => false,
			'defaultValueSQL' => null,
			'defaultValue' => '' 
		),
		array(
			'name' => 'tipo',
			'type' => 129,
			'size' => 0,
			'scale' => 0,
			'typeName' => 'enum(\'ahorro\',\'corriente\')',
			'enumValues' => array( 
				'ahorro',
				'corriente' 
			),
			'nullable' => true,
			'autoinc' => false,
			'defaultValueSQL' => null,
			'defaultValue' => '' 
		),
		array(
			'name' => 'saldo',
			'type' => 14,
			'size' => 12,
			'scale' => 2,
			'typeName' => 'decimal(12,2)',
			'nullable' => true,
			'autoinc' => false,
			'defaultValueSQL' => '0.00',
			'defaultValue' => '0.00' 
		),
		array(
			'name' => 'estado',
			'type' => 129,
			'size' => 0,
			'scale' => 0,
			'typeName' => 'enum(\'activa\',\'bloqueada\',\'cerrada\')',
			'enumValues' => array( 
				'activa',
				'bloqueada',
				'cerrada' 
			),
			'nullable' => true,
			'autoinc' => false,
			'defaultValueSQL' => '\'activa\'',
			'defaultValue' => 'activa' 
		),
		array(
			'name' => 'created_at',
			'type' => 135,
			'size' => 0,
			'scale' => 0,
			'typeName' => 'timestamp',
			'nullable' => true,
			'autoinc' => false,
			'defaultValueSQL' => 'CURRENT_TIMESTAMP',
			'defaultValue' => 'CURRENT_TIMESTAMP' 
		) 
	),
	'primaryKeys' => array( 
		'id' 
	),
	'uniqueFields' => array( 
		 
	),
	'name' => 'cuentas' 
);
?>