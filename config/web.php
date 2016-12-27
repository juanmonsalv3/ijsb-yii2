<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'ijsb',
    'name'=>'Instituto Jerome S. Bruner',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'components' => [
        'urlManager' => [ 
            'showScriptName' => false,
            'enablePrettyUrl' => true,
            'enableStrictParsing' => false,
            'rules' => [
                'inscripciones' => 'inscripciones/index', 
                'inscripciones/<id:\d+>' => 'inscripciones/view',
                'inscripciones/borrar/<id:\d+>' => 'inscripciones/delete',
                'inscripciones/aceptar/<id:\d+>' => 'inscripciones/aceptar',
                'inscripciones/rechazar/<id:\d+>' => 'inscripciones/rechazar',
                'matricula/estudiante/<id:\d+>/<id_grupo:\d+>' => 'matricula/matricular',
                'matricula/ficha-medica/<id:\d+>' => 'matricula/ficha-medica',
                'matricula/ficha-psicologica/<id:\d+>' => 'matricula/ficha-psicologica',
                'matricula/acudientes/<id:\d+>' => 'matricula/acudientes',
                'indicadores/editar/<id:\d+>'=>'indicadores/editar',
                'grupo/<id_grupo:\d+>/horario' => 'grupos/horario',
                'grupos/<id_grupo:\d+>' => 'grupos/grupo',
                'logout'=>'usuarios/logout',
                'email-activacion/<id:\d+>'=>'usuarios/activateemail',
                'login' => 'usuarios/login',
                'forgotpass' => 'usuarios/forgot',
                'restablecer'=> 'usuarios/reset',
                'usuarios/nuevo'=>'usuarios/nuevo',
                'usuarios/prueba' => 'usuarios/prueba',
                'usuarios/confirm' => 'usuarios/confirm',
                'usuarios/<login:\w+>' => 'usuarios/view',
                'usuarios' => 'usuarios/index',
                'estudiante/<id:\d+>/logros/anio/<anio:\d+>' => 'estudiantes/anio',
                'estudiante/<id:\d+>/historial' => 'estudiantes/historial',
                'estudiante/<id:\d+>/indicadores' => 'estudiantes/indicadores',
                'estudiante/<id:\d+>/logros' => 'estudiantes/logros',
                'estudiante/<id:\d+>/editar' => 'estudiantes/editar',
                'estudiante/<id:\d+>/acudientes' => 'estudiantes/acudientes',
                'estudiante/<id:\d+>' => 'estudiantes/estudiante',
                'cierre-academico' => 'parametros/cierre',
                'cierre' => 'parametros/cerrar',
                //new stuff
                'student/<id>' => 'students/view',
                'student/grades-report/<id>' => 'students/grades-report'
            ],
        ],  
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'ijsb',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.gmail.com',
                'username' => 'proyectojeromesbruner@gmail.com',
                'password' => 'jeromerbruner123456789',
                'port' => '587',
                'encryption' => 'tls',
            ],
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => require(__DIR__ . '/db.php'),
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
            'loginUrl' => ['usuarios/login'],
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
