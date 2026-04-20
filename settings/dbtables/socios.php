<?php
global $runnerDbTableInfo;
$runnerDbTableInfo['socios'] = array(
	'type' => 0,
	'foreignKeys' => array( 
		 
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
			'name' => 'cedula',
			'type' => 200,
			'size' => 20,
			'scale' => 0,
			'typeName' => 'varchar(20)',
			'nullable' => true,
			'autoinc' => false,
			'defaultValueSQL' => null,
			'defaultValue' => '' 
		),
		array(
			'name' => 'nombre',
			'type' => 200,
			'size' => 100,
			'scale' => 0,
			'typeName' => 'varchar(100)',
			'nullable' => true,
			'autoinc' => false,
			'defaultValueSQL' => null,
			'defaultValue' => '' 
		),
		array(
			'name' => 'apellido',
			'type' => 200,
			'size' => 100,
			'scale' => 0,
			'typeName' => 'varchar(100)',
			'nullable' => true,
			'autoinc' => false,
			'defaultValueSQL' => null,
			'defaultValue' => '' 
		),
		array(
			'name' => 'direccion',
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
			'name' => 'telefono',
			'type' => 200,
			'size' => 20,
			'scale' => 0,
			'typeName' => 'varchar(20)',
			'nullable' => true,
			'autoinc' => false,
			'defaultValueSQL' => null,
			'defaultValue' => '' 
		),
		array(
			'name' => 'email',
			'type' => 200,
			'size' => 100,
			'scale' => 0,
			'typeName' => 'varchar(100)',
			'nullable' => true,
			'autoinc' => false,
			'defaultValueSQL' => null,
			'defaultValue' => '' 
		),
		array(
			'name' => 'fecha_ingreso',
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
			'typeName' => 'enum(\'activo\',\'inactivo\')',
			'enumValues' => array( 
				'activo',
				'inactivo' 
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
	'name' => 'socios' 
);
?>