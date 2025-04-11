<?php

use Eyegil\ReportJasper\Enums\JasperDataType;

return [
    'client_url' => env("CLIENT_URL", 'http://localhost:4200'),

    'security' => [
        "reuseDeletedUser" => true,
        "defaultAuthType" => "password",
        'oauth2' => [
            'clients' => [
                'sijupri-web' => [
                    'id' => 'sijupri-web',
                    'secret' => 'sijupri-webP@ssw0rd',
                    'redirectUris' => '',
                    'grants' => ['password', 'refresh_token'],
                    'accessTokenLifetime' => 3000000,
                    'refreshTokenLifetime' => 3000000,
                    'authType' => 'password',
                ],
                'sijupri-jf-mobile' => [
                    'id' => 'sijupri-jf-mobile',
                    'secret' => 'sijupri-jf-mobileP@ssw0rd',
                    'redirectUris' => '',
                    'grants' => ['password', 'refresh_token'],
                    'accessTokenLifetime' => 3000000,
                    'refreshTokenLifetime' => 3000000,
                    'authType' => 'password',
                ],
                'siukom-participant' => [
                    'id' => 'siukom-participant',
                    'secret' => 'siukom-participantP@ssw0rd',
                    'redirectUris' => '',
                    'grants' => ['password', 'refresh_token'],
                    'accessTokenLifetime' => 3000000,
                    'refreshTokenLifetime' => 3000000,
                    'authType' => 'password',
                ],
                'siukom-examiner' => [
                    'id' => 'siukom-examiner',
                    'secret' => 'siukom-examinerP@ssw0rd',
                    'redirectUris' => '',
                    'grants' => ['password', 'refresh_token'],
                    'accessTokenLifetime' => 3000000,
                    'refreshTokenLifetime' => 3000000,
                    'authType' => 'password',
                ]
            ],
        ],
        "password" => [
            'encrypt' => \App\Helpers\PasswordHelper::class,
            'validate' => \App\Helpers\PasswordHelper::class,
        ]
    ],

    'storage' => [
        'basePath' => '',
        'system' => [
            'host' => env("APP_URL", "http://localhost:8000"),
            'isUnsigned' => false,
        ],
        'buckets' => [
            'temporary' => [
                'name' => 'buckets/test',
                'expiry' => 1600,
            ],
            'user' => [
                'name' => 'buckets/user',
                'expiry' => 1600,
            ],
            'jf' => [
                'name' => 'buckets/jf',
                'expiry' => 1600,
            ],
            'formasi' => [
                'name' => 'buckets/formasi',
                'expiry' => 1600,
            ],
            'akp' => [
                'name' => 'buckets/akp',
                'expiry' => 1600,
            ],
            'ukom' => [
                'name' => 'buckets/ukom',
                'expiry' => 1600,
            ],
            'template' => [
                'name' => 'buckets/template',
                'expiry' => 1600,
            ],
            'report' => [
                'name' => 'buckets/report',
                'expiry' => 1600,
            ],
            'lms' => [
                'name' => 'buckets/lms',
                'expiry' => 1600,
            ],
        ],
    ],

    'notification' => [
        'driver' => 'db',
        'smtp' => [
            'host' => 'smtp.gmail.com',
            'port' => 587,
            'useSsl' => false,
            'auth' => [
                'user' => 'reservasicrystallotus@gmail.com',
                'pass' => 'utvognulpbsepweb',
            ],
        ],
    ],

    'report' => [
        'temp' => env("BASE_PROJECT") . "storage/app/temp",
        'templates' => [
            'akpReport' => [
                'input' => env("BASE_PROJECT") . "storage/app/report/akpReport.jasper",
                'name' => 'Akp Report',
                'storage_engine' => 'system',
                'report_engine' => 'jasper',
                'fileTypes' => ['xlsx', 'xls', 'csv'],
                'parameter' => [
                    'unit_kerja_id' => [
                        'type' => JasperDataType::String,
                        'required' => true,
                    ],
                    'unit_kerja_name' => [
                        'type' => JasperDataType::String,
                        'required' => true,
                    ],
                    'date_from' => [
                        'type' => JasperDataType::Date,
                        'required' => true,
                    ],
                    'date_to' => [
                        'type' => JasperDataType::Date,
                        'required' => true,
                    ],
                ]
            ],
            'siapReport' => [
                'input' => env("BASE_PROJECT") . "storage/app/report/siapReport.jasper",
                'name' => 'Siap Report',
                'storage_engine' => 'system',
                'report_engine' => 'jasper',
                'fileTypes' => ['xlsx', 'xls', 'csv'],
                'parameter' => [
                    'instansi_id' => [
                        'type' => JasperDataType::String,
                        'required' => false,
                    ],
                    'instansi_name' => [
                        'type' => JasperDataType::String,
                        'required' => false,
                    ],
                    'unit_kerja_id' => [
                        'type' => JasperDataType::String,
                        'required' => false,
                    ],
                    'unit_kerja_name' => [
                        'type' => JasperDataType::String,
                        'required' => false,
                    ],
                    'provinsi_id' => [
                        'type' => JasperDataType::String,
                        'required' => false,
                    ],
                    'provinsi_name' => [
                        'type' => JasperDataType::String,
                        'required' => false,
                    ],
                    'kab_kota_id' => [
                        'type' => JasperDataType::String,
                        'required' => false,
                    ],
                    'kab_kota_name' => [
                        'type' => JasperDataType::String,
                        'required' => false,
                    ],
                ]
            ],
            'formasiReport' => [
                'input' => env("BASE_PROJECT") . "storage/app/report/formasiReport.jasper",
                'name' => 'Formasi Report',
                'storage_engine' => 'system',
                'report_engine' => 'jasper',
                'fileTypes' => ['xlsx', 'xls', 'csv'],
                'parameter' => [
                    'unit_kerja_id' => [
                        'type' => JasperDataType::String,
                        'required' => false,
                    ],
                    'unit_kerja_name' => [
                        'type' => JasperDataType::String,
                        'required' => false,
                    ],
                    'provinsi_id' => [
                        'type' => JasperDataType::String,
                        'required' => false,
                    ],
                    'provinsi_name' => [
                        'type' => JasperDataType::String,
                        'required' => false,
                    ],
                    'kab_kota_id' => [
                        'type' => JasperDataType::String,
                        'required' => false,
                    ],
                    'kab_kota_name' => [
                        'type' => JasperDataType::String,
                        'required' => false,
                    ],
                ]
            ],
            'ukomReport' => [
                'input' => env("BASE_PROJECT") . "storage/app/report/ukomReport.jasper",
                'name' => 'Ukom Report',
                'storage_engine' => 'system',
                'report_engine' => 'jasper',
                'fileTypes' => ['xlsx', 'xls', 'csv'],
                'parameter' => [
                    'date_from' => [
                        'type' => JasperDataType::Date,
                        'required' => true,
                    ],
                    'date_to' => [
                        'type' => JasperDataType::Date,
                        'required' => true,
                    ]
                ]
            ],
            'ukomGrade' => [
                'input' => env("BASE_PROJECT") . "storage/app/report/ukomGrade.jasper",
                'name' => 'Ukom Report',
                'storage_engine' => 'system',
                'report_engine' => 'jasper',
                'fileTypes' => ['xlsx', 'xls', 'csv'],
                'parameter' => [
                    'date_from' => [
                        'type' => JasperDataType::Date,
                        'required' => true,
                    ],
                    'date_to' => [
                        'type' => JasperDataType::Date,
                        'required' => true,
                    ]
                ]
            ],
            'ukomVerification' => [
                'input' => env("BASE_PROJECT") . "storage/app/report/ukomVerification.jasper",
                'name' => 'Ukom Report',
                'storage_engine' => 'system',
                'report_engine' => 'jasper',
                'fileTypes' => ['xlsx', 'xls', 'csv'],
                'parameter' => [
                    'task_status' => [
                        'type' => JasperDataType::String
                    ],
                    'jabatan_code' => [
                        'type' => JasperDataType::String,
                    ],
                    'jabatan_name' => [
                        'type' => JasperDataType::String,
                    ],
                    'date_from' => [
                        'type' => JasperDataType::Date,
                        'required' => true,
                    ],
                    'date_to' => [
                        'type' => JasperDataType::Date,
                        'required' => true,
                    ]
                ]
            ],
        ],
    ],

    'workflow' => [
        "approvalSiap" => env("BASE_PROJECT") . "storage/app/workflow/ApprovalSIap.bpmn",
        "approvalFormasi" => env("BASE_PROJECT") . "storage/app/workflow/ApprovalFormasi.bpmn",
        "approvalAkp" => env("BASE_PROJECT") . "storage/app/workflow/ApprovalAkp.bpmn",
        "approvalUkom" => env("BASE_PROJECT") . "storage/app/workflow/ApprovalUkom.bpmn",
        'templates' => [
            'jf_task' => 'approvalSiap',
            'rw_jabatan_task' => 'approvalSiap',
            'rw_kinerja_task' => 'approvalSiap',
            'rw_kompetensi_task' => 'approvalSiap',
            'rw_pangkat_task' => 'approvalSiap',
            'rw_pendidikan_task' => 'approvalSiap',
            'rw_sertifikasi_task' => 'approvalSiap',
            'formasi_task' => 'approvalFormasi',
            'akp_task' => 'approvalAkp',
            'participant_ukom_task' => 'approvalUkom',
        ],
    ],

    "queue" => [
        "reports" => 4
    ],

    "firebase" => [
        "credentials" => env("BASE_PROJECT") . "storage/sijupri-firebase-adminsdk-m3ssv-cfbd89ada7.json"
    ],

    "captcha" => [
        "enable" => env("CAPTCHA_ENABLE", false),
        "secretKey" => env("CAPTCHA_SECRET_KEY"),
    ],

    "middlewares" => [
        "global" => ['response_handler', "case_support", "client", "auth:api", "request_context", "user_context"],
        "local" => [
            [
                "excludes" => ["client", "auth:api", "request_context", "user_context"],
                "includes" => [],
                "routes" => [
                    "/api/v1/application",
                    "/storage_system/{bucket_id}/{object_name}",
                    "/api/v1/akp/reviewer/{reviewer}/{id}",
                    "/api/v1/akp/matrix/rekan",
                    "/api/v1/akp/matrix/atasan",
                    "/api/v1/test_notify/profile" => ["post"],
                    "/api/v1/test_notify/rw_pendidikan" => ["post"],
                    "/api/v1/test_notify/rw_pangkat" => ["post"],
                    "/api/v1/test_notify/rw_jabatan" => ["post"],
                    "/api/v1/test_notify/rw_kinerja" => ["post"],
                    "/api/v1/test_notify/rw_kompetensi" => ["post"],
                    "/api/v1/test_notify/rw_sertifikasi" => ["post"],
                    "/api/v1/test_notify/verify/siap" => ["post"],
                    "/api/v1/document_ukom/jenis_ukom/{jenis_ukom}",
                    "/api/v1/participant_ukom/task" => ["post"],
                    "/api/v1/participant_ukom/task/non_jf/submit" => ["post"],
                    "/api/v1/participant_ukom/task/non_jf",
                    "/api/v1/participant_ukom_detail",
                    "/api/v1/instansi",
                    "/api/v1/unit_kerja/instansi/{instansi_id}",
                    "/api/v1/jabatan",
                    "/api/v1/jenjang",
                    "/api/v1/pangkat",
                    "/api/v1/jabatan/jenjang/{jenjang_code}",
                    "/api/v1/jenjang/jabatan/{jabatan_code}",
                    "/api/v1/pangkat/jenjang/{jenjang_code}",
                    "/api/v1/document_ukom/jenis_ukom/{jenis_ukom}",
                    "/api/v1/ukom_ban/banme",
                    "/api/v1/sys_conf/{code}",
                    "/api/v1/provinsi",
                    "/api/v1/provinsi/{id}",
                    "/api/v1/kab_kota",
                    "/api/v1/kab_kota/{id}",
                    "/api/v1/kab_kota/type/{type}/{provinsi_id}",
                    "/api/v1/predikat_kinerja",
                    "/api/v1/pendidikan",
                    "/api/v1/bidang_jabatan/{id}",
                    "/api/v1/bidang_jabatan/jabatan/{jabatan_code}",
                    "/api/v1/forgot_password" => ["post"],
                    "/api/v1/password/forgot" => ["put"],
                ]
            ],
        ],
        // "global" => ["case_support"],
        "modules" => [
            "SecurityBase" => [
                'global' => [],
            ]
        ]
    ]
];
