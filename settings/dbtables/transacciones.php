<?php
global $runnerDbTableInfo;
$runnerDbTableInfo['transacciones'] = array(
	'type' => 0,
	'foreignKeys' => array( 
		array(
			'name' => 'transacciones_ibfk_1',
			'refTable' => 'cuentas',
			'refSchema' => '',
			'del_rule' => 1,
			'columns' => array( 
				array(
					'column' => 'cuenta_id',
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
			'name' => 'cuenta_id',
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
			'name' => 'tipo',
			'type' => 129,
			'size' => 0,
			'scale' => 0,
			'typeName' => 'enum(\'deposito\',\'retiro\',\'transferencia\')',
			'enumValues' => array( 
				'deposito',
				'retiro',
				'transferencia' 
			),
			'nullable' => true,
			'autoinc' => false,
			'defaultValueSQL' => null,
			'defaultValue' => '' 
		),
		array(
			'name' => 'monto',
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
			'name' => 'descripcion',
			'type' => 201,
			'size' => 0,
			'scale' => 0,
			'typeName' => 'text',
			'nullable' => true,
			'autoinc' => false,
			'defaultValueSQL' => null,
			'defaultValue' => '' 
		),
		array(
			'name' => 'fecha',
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
	'name' => 'transacciones' 
);
?>