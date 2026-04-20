<?php
global $runnerDbTableInfo;
$runnerDbTableInfo['cuotas'] = array(
	'type' => 0,
	'foreignKeys' => array( 
		array(
			'name' => 'cuotas_ibfk_1',
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
			'name' => 'numero_cuota',
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
			'name' => 'fecha_vencimiento',
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
			'typeName' => 'enum(\'pendiente\',\'pagado\',\'atrasado\')',
			'enumValues' => array( 
				'pendiente',
				'pagado',
				'atrasado' 
			),
			'nullable' => true,
			'autoinc' => false,
			'defaultValueSQL' => '\'pendiente\'',
			'defaultValue' => 'pendiente' 
		) 
	),
	'primaryKeys' => array( 
		'id' 
	),
	'uniqueFields' => array( 
		 
	),
	'name' => 'cuotas' 
);
?>