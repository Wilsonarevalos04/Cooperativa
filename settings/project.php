<?php
$runnerProjectSettings = array(
	'restAPIReturnEncodedBinary' => true,
	'restAPIAuthType' => 'basic',
	'menuIds' => array( 
		'main' 
	),
	'tablesAdvSecurity' => array(
		'ahorros_programados' => array(
			'table' => 3372 
		),
		'auditoria' => array(
			'table' => 3405 
		),
		'cuentas' => array(
			'table' => 3435 
		),
		'cuotas' => array(
			'table' => 3471 
		),
		'pagos' => array(
			'table' => 3504 
		),
		'prestamos' => array(
			'table' => 3534 
		),
		'roles' => array(
			'table' => 3578 
		),
		'scoring_crediticio' => array(
			'table' => 3602 
		),
		'socios' => array(
			'table' => 3632 
		),
		'transacciones' => array(
			'table' => 3688 
		),
		'usuario_roles' => array(
			'table' => 3723 
		),
		'usuarios' => array(
			'table' => 3749 
		) 
	),
	'phpSpreadsheet' => false,
	'ext' => 'php',
	'security' => array(
		'projectName' => '',
		'loginDataSource' => '',
		'loginForm' => 3,
		'dynamicPermissions' => false,
		'dpTablePrefix' => '',
		'dpTableConnId' => '',
		'providers' => array( 
			 
		),
		'enabled' => false,
		'advancedSecurityAvailable' => false,
		'userGroupsAvailable' => false,
		'hardcodedLogin' => false,
		'defaultProviderCode' => '',
		'adOnlyLogin' => false,
		'sessionControl' => array(
			'lifeTime' => 15,
			'sessionName' => 'vAMVErznFhgLJ8AK7koD',
			'JWTSecret' => 'xN04FUPRhuMUm7jqY80g' 
		),
		'registration' => array(
			'remindMethod' => 0,
			'hashAlgorithm' => 0,
			'passwordValidation' => array(
				'strong' => false,
				'minimumLength' => 8,
				'uniqueCharacters' => 4,
				'digitsAndSymbols' => 2,
				'upperAndLowerCase' => false 
			),
			'registerPage' => false 
		),
		'captchaSettings' => array(
			'captchaType' => 0,
			'siteKey' => '',
			'secretKey' => '',
			'passesCount' => 5 
		),
		'emailSettings' => array(
			'fromEmail' => '',
			'usePHPDefinedSMTP' => false,
			'useBuiltInMailer' => false,
			'SMTPServer' => 'localhost',
			'SMTPPort' => 25,
			'SMTPUser' => '',
			'SMTPPassword' => '',
			'securityProtocol' => 0,
			'provider' => 0,
			'oauthUserEmail' => '',
			'oauthSettingsJson' => '',
			'oauthClientId' => '',
			'oauthClientSecret' => '',
			'oauthTenantId' => '' 
		),
		'advancedSecurity' => array(
			'allowGuestLogin' => false 
		),
		'auditAndLocking' => array(
			'loggingMode' => 0,
			'loggingTable' => array(
				'connId' => '',
				'table' => '' 
			),
			'loggingFile' => 'audit.log',
			'logSecurityActions' => false,
			'lockAfterUnsuccessfulLogin' => false,
			'enableLocking' => false,
			'lockingTable' => array(
				'connId' => '',
				'table' => '' 
			),
			'tables' => array(
				 
			) 
		),
		'twoFactorSettings' => array(
			'available' => false,
			'required' => false,
			'enable' => true,
			'remember' => true,
			'types' => array(
				 
			),
			'twoFactorField' => '',
			'emailField' => '',
			'phoneField' => '',
			'codeField' => '',
			'projectName' => '' 
		),
		'staticPermissions' => array(
			'groups' => array(
				 
			) 
		),
		'adAdminGroups' => array( 
			 
		),
		'showUserSource' => false,
		'dbProviderCodes' => array( 
			 
		) 
	),
	'notifications' => array(
		'enabled' => false,
		'table' => array(
			'connId' => '',
			'table' => '' 
		) 
	),
	'allTables' => array(
		'ahorros_programados' => array(
			'gid' => 3372,
			'name' => 'ahorros_programados',
			'shortName' => 'ahorros_programados',
			'type' => 0,
			'caption' => array(
				'English' => 'Ahorros Programados' 
			),
			'connId' => 'conn',
			'color' => '3cb371',
			'originalTable' => 'ahorros_programados' 
		),
		'auditoria' => array(
			'gid' => 3405,
			'name' => 'auditoria',
			'shortName' => 'auditoria',
			'type' => 0,
			'caption' => array(
				'English' => 'Auditoria' 
			),
			'connId' => 'conn',
			'color' => '4169e1',
			'originalTable' => 'auditoria' 
		),
		'cuentas' => array(
			'gid' => 3435,
			'name' => 'cuentas',
			'shortName' => 'cuentas',
			'type' => 0,
			'caption' => array(
				'English' => 'Cuentas' 
			),
			'connId' => 'conn',
			'color' => 'd2af80',
			'originalTable' => 'cuentas' 
		),
		'cuotas' => array(
			'gid' => 3471,
			'name' => 'cuotas',
			'shortName' => 'cuotas',
			'type' => 0,
			'caption' => array(
				'English' => 'Cuotas' 
			),
			'connId' => 'conn',
			'color' => 'e67349',
			'originalTable' => 'cuotas' 
		),
		'pagos' => array(
			'gid' => 3504,
			'name' => 'pagos',
			'shortName' => 'pagos',
			'type' => 0,
			'caption' => array(
				'English' => 'Pagos' 
			),
			'connId' => 'conn',
			'color' => 'edca00',
			'originalTable' => 'pagos' 
		),
		'prestamos' => array(
			'gid' => 3534,
			'name' => 'prestamos',
			'shortName' => 'prestamos',
			'type' => 0,
			'caption' => array(
				'English' => 'Prestamos' 
			),
			'connId' => 'conn',
			'color' => 'dc143c',
			'originalTable' => 'prestamos' 
		),
		'roles' => array(
			'gid' => 3578,
			'name' => 'roles',
			'shortName' => 'roles',
			'type' => 0,
			'caption' => array(
				'English' => 'Roles' 
			),
			'connId' => 'conn',
			'color' => '6493ea',
			'originalTable' => 'roles' 
		),
		'scoring_crediticio' => array(
			'gid' => 3602,
			'name' => 'scoring_crediticio',
			'shortName' => 'scoring_crediticio',
			'type' => 0,
			'caption' => array(
				'English' => 'Scoring Crediticio' 
			),
			'connId' => 'conn',
			'color' => '7b68ee',
			'originalTable' => 'scoring_crediticio' 
		),
		'socios' => array(
			'gid' => 3632,
			'name' => 'socios',
			'shortName' => 'socios',
			'type' => 0,
			'caption' => array(
				'English' => 'Socios' 
			),
			'connId' => 'conn',
			'color' => 'db7093',
			'originalTable' => 'socios' 
		),
		'transacciones' => array(
			'gid' => 3688,
			'name' => 'transacciones',
			'shortName' => 'transacciones',
			'type' => 0,
			'caption' => array(
				'English' => 'Transacciones' 
			),
			'connId' => 'conn',
			'color' => '6493ea',
			'originalTable' => 'transacciones' 
		),
		'usuario_roles' => array(
			'gid' => 3723,
			'name' => 'usuario_roles',
			'shortName' => 'usuario_roles',
			'type' => 0,
			'caption' => array(
				'English' => 'Usuario Roles' 
			),
			'connId' => 'conn',
			'color' => 'e07878',
			'originalTable' => 'usuario_roles' 
		),
		'usuarios' => array(
			'gid' => 3749,
			'name' => 'usuarios',
			'shortName' => 'usuarios',
			'type' => 0,
			'caption' => array(
				'English' => 'Usuarios' 
			),
			'connId' => 'conn',
			'color' => 'd2af80',
			'originalTable' => 'usuarios' 
		) 
	),
	'tablesByShort' => array(
		'ahorros_programados' => 'ahorros_programados',
		'auditoria' => 'auditoria',
		'cuentas' => 'cuentas',
		'cuotas' => 'cuotas',
		'pagos' => 'pagos',
		'prestamos' => 'prestamos',
		'roles' => 'roles',
		'scoring_crediticio' => 'scoring_crediticio',
		'socios' => 'socios',
		'transacciones' => 'transacciones',
		'usuario_roles' => 'usuario_roles',
		'usuarios' => 'usuarios' 
	),
	'tablesByGood' => array(
		'ahorros_programados' => 'ahorros_programados',
		'auditoria' => 'auditoria',
		'cuentas' => 'cuentas',
		'cuotas' => 'cuotas',
		'pagos' => 'pagos',
		'prestamos' => 'prestamos',
		'roles' => 'roles',
		'scoring_crediticio' => 'scoring_crediticio',
		'socios' => 'socios',
		'transacciones' => 'transacciones',
		'usuario_roles' => 'usuario_roles',
		'usuarios' => 'usuarios' 
	),
	'events' => array( 
		 
	),
	'languages' => array( 
		array(
			'name' => 'English',
			'nativeName' => 'English',
			'rtl' => false,
			'filename' => 'English.lng' 
		) 
	),
	'languageNames' => array( 
		'English' 
	),
	'defaultLanguage' => 'English',
	'detectDefaultLanguage' => true,
	'charset' => 'utf-8',
	'codepage' => 65001,
	'defaultConnID' => 'conn',
	'wrConnectionID' => '',
	'wizardBuild' => '44200',
	'projectBuild' => 'DRsvtbB6CiT9',
	'projectTheme' => 'default',
	'projectSize' => 'normal',
	'customErrorMsg' => array(
		'text' => 'Error occured.',
		'type' => 0 
	),
	'cloudSettings' => array(
		'cloudAmazonRegion' => '',
		'cloudAmazonBucket' => '',
		'cloudAmazonAccessKey' => '',
		'cloudAmazonSecretKey' => '',
		'cloudWasabiRegion' => '',
		'cloudWasabiBucket' => '',
		'cloudWasabiAccessKey' => '',
		'cloudWasabiSecretKey' => '',
		'cloudGDriveClientId' => '',
		'cloudGDriveClientSecret' => '',
		'cloudOneDriveClientId' => '',
		'cloudOneDriveClientSecret' => '',
		'cloudOneDriveDrive' => '',
		'cloudOneDriveAccountType' => 0,
		'cloudOneDriveDirectoryId' => '',
		'cloudDropboxClientId' => '',
		'cloudDropboxClientSecret' => '' 
	),
	'mapSettings' => array(
		'embed' => true,
		'provider' => 0,
		'apikey' => '' 
	),
	'viewPluginsWithJS' => array( 
		 
	),
	'rtlLanguages' => array(
		'English' => false 
	),
	'smsSettings' => array(
		'smsProvider' => 4,
		'iBusername' => '',
		'iBpassword' => '',
		'iBsender' => '',
		'essUsername' => '',
		'essPassword' => '',
		'essSender' => '',
		'gwApiToken' => '',
		'gwSender' => '',
		'mbAuth' => '',
		'mbSender' => '',
		'twilioSID' => '',
		'twilioAuth' => '',
		'twilioNumber' => '',
		'phoneField' => '',
		'counryCode' => '+1',
		'wauUsername' => '',
		'wauPassword' => '',
		'wauSender' => '' 
	) 
);

?>