<?php
global $runnerDbTableInfo;
$runnerDbTableInfo['pagos'] = array(
	'type' => 0,
	'foreignKeys' => array( 
		array(
			'name' => 'pagos_ibfk_1',
			'refTable' => 'prestamos',
			'refSchema' => '',
			'del_rule' => 1,
			'columns' => array( 
				array(
					'column' => 'prestamo_id',
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
			'name' => 'prestamo_id',
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
			'name' => 'fecha_pago',
			'type' => 135,
			'size' => 0,
			'scale' => 0,
			'typeName' => 'timestamp',
			'nullable' => true,
			'autoinc' => false,
			'defaultValueSQL' => 'CURRENT_TIMESTAMP',
			'defaultValue' => 'CURRENT_TIMESTAMP' 
		),
		array(
			'name' => 'metodo',
			'type' => 129,
			'size' => 0,
			'scale' => 0,
			'typeName' => 'enum(\'efectivo\',\'transferencia\')',
			'enumValues' => array( 
				'efectivo',
				'transferencia' 
			),
			'nullable' => true,
			'autoinc' => false,
			'defaultValueSQL' => null,
			'defaultValue' => '' 
		) 
	),
	'primaryKeys' => array( 
		'id' 
	),
	'uniqueFields' => array( 
		 
	),
	'name' => 'pagos' 
);
?>