INSERT INTO sec_channel (code, name) VALUES
	 ('WEB','Web'),
	 ('MOBILE','mobile');

INSERT INTO sec_application (code,name, idx) VALUES
	 ('sijupri-admin','Admin', 1),
	 ('sijupri-instansi','User Instansi', 2),
	 ('sijupri-unit-kerja','User Unit Kerja', 3),
	 ('sijupri-internal','JF Internal', 4),
	 ('sijupri-external','JF External', 5);

INSERT INTO sec_application_channel (id, auth_type, application_code, channel_code) VALUES
	 ('0478b542-b6de-4db6-905c-b2631e13e015', 'password', 'sijupri-admin', 'WEB'),
	 ('1478b542-b6de-4db6-905c-b2631e13e015', 'password', 'sijupri-admin', 'MOBILE'),
	 ('2478b542-b6de-4db6-905c-b2631e13e015', 'password', 'sijupri-instansi', 'WEB'),
	 ('3478b542-b6de-4db6-905c-b2631e13e015', 'password', 'sijupri-instansi', 'MOBILE'),
	 ('4478b542-b6de-4db6-905c-b2631e13e015', 'password', 'sijupri-unit-kerja', 'WEB'),
	 ('5478b542-b6de-4db6-905c-b2631e13e015', 'password', 'sijupri-unit-kerja', 'MOBILE'),
	 ('6478b542-b6de-4db6-905c-b2631e13e015', 'password', 'sijupri-internal', 'WEB'),
	 ('7478b542-b6de-4db6-905c-b2631e13e015', 'password', 'sijupri-internal', 'MOBILE'),
	 ('8478b542-b6de-4db6-905c-b2631e13e015', 'password', 'sijupri-external', 'WEB'),
	 ('9478b542-b6de-4db6-905c-b2631e13e015', 'password', 'sijupri-external', 'MOBILE');

INSERT INTO sec_user (id,name,email,phone,user_details,status,version,updated_by,last_updated,delete_flag,inactive_flag,created_by,date_created,idx) VALUES
	 ('111111111111111111','Goldian Pakpahan','goldianperdanapakpahan@gmail.com','08123312332231',NULL,'ACTIVE',NULL,'admin','2024-05-14 15:32:52',false,false,NULL,'2024-05-14 15:21:36', 999);

INSERT INTO sec_user_application_channel (id, user_id, application_code, channel_code, created_by, date_created, idx) VALUES
	 ('0478b542-b6de-4db6-905c-b2631e13e015', '111111111111111111','sijupri-admin', 'WEB', 'system', '2024-05-14 15:32:52', 999),
	 ('1478b542-b6de-4db6-905c-b2631e13e015', '111111111111111111','sijupri-admin', 'MOBILE', 'system', '2024-05-14 15:32:52', 999);

INSERT INTO sec_role (code,creatable,updatable,deletable,application_code,name,description,delete_flag,inactive_flag,version,updated_by,last_updated,created_by,date_created,idx) VALUES
	 ('ADMIN',true,true,true,'sijupri-admin','Admin','admin',false,false,NULL,NULL,'2024-05-23 14:37:08','system','2024-05-14 15:21:36',999),
	 ('ADMIN_AKP',true,true,true,'sijupri-admin','Admin AKP','Admin AKP',false,false,NULL,NULL,'2024-05-23 14:37:08','system','2024-05-14 15:21:36',999),
	 ('ADMIN_PAK',true,true,true,'sijupri-admin','Admin PAK','Admin PAK',false,false,NULL,NULL,'2024-05-23 14:37:08','system','2024-05-14 15:21:36',999),
	 ('ADMIN_UKOM',true,true,true,'sijupri-admin','Admin UKom','Admin UKom',false,false,NULL,NULL,'2024-05-23 14:37:08','system','2024-05-14 15:21:36',999),
	 ('ADMIN_FORMASI',true,true,true,'sijupri-admin','Admin Formasi','Admin Formasi',false,false,NULL,NULL,'2024-05-23 14:37:08','system','2024-05-14 15:21:36',999),
	 ('USER_INSTANSI',true,true,true,'sijupri-instansi','User Instansi','User Instansi',false,false,NULL,NULL,'2024-05-22 23:18:02','system','2024-05-14 15:21:36',999),
	 ('USER_UNIT_KERJA',true,true,true,'sijupri-unit-kerja','User Unit Kerja','User Unit Kerja',false,false,NULL,NULL,'2024-05-22 23:18:02','system','2024-05-14 15:21:36',999),
	 ('USER_EXTERNAL',true,true,true,'sijupri-internal','User External','User External',false,false,NULL,NULL,'2024-05-22 17:23:03','system','2024-05-17 12:36:17',999),
	 ('USER_INTERNAL',true,true,true,'sijupri-external','User Internal','User Internal',false,false,NULL,NULL,'2024-05-22 17:23:03','system','2024-05-17 12:36:17',999);

INSERT INTO sec_menu (code,parent_menu_code,application_code,name,url,level,path,description,delete_flag,inactive_flag,version,updated_by,last_updated,created_by,date_created,idx) VALUES
	 ('MNU_SEC0001',NULL,'sijupri-admin','Security','/api/v1/**',1,'security',NULL,false,false,NULL,NULL,'2024-05-14 15:21:36',NULL,'2024-05-14 15:21:36',6),
	 ('MNU_SEC0002','MNU_SEC0001','sijupri-admin','User','/api/v1/**',2,'user',NULL,false,false,NULL,NULL,'2024-05-14 15:21:36',NULL,'2024-05-14 15:21:36',1),
	 ('MNU_SEC0003','MNU_SEC0001','sijupri-admin','Role','/api/v1/**',2,'role',NULL,false,false,NULL,NULL,'2024-05-14 15:21:36',NULL,'2024-05-14 15:21:36',2),

	 ('MNU_MNT0001',NULL,'sijupri-admin','Maintenance','/api/v1/**',1,'maintenance',NULL,false,false,NULL,NULL,'2024-05-14 15:21:36',NULL,'2024-05-14 15:21:36',7),
	 ('MNU_MNT0002','MNU_MNT0001','sijupri-admin','Instansi','/api/v1/**',2,'instansi',NULL,false,false,NULL,NULL,'2024-05-14 15:21:36',NULL,'2024-05-14 15:21:36',1),
	 ('MNU_MNT0003','MNU_MNT0001','sijupri-admin','Unit Kerja','/api/v1/**',2,'unit-kerja',NULL,false,false,NULL,NULL,'2024-05-14 15:21:36',NULL,'2024-05-14 15:21:36',2),
	 ('MNU_MNT0004','MNU_MNT0001','sijupri-admin','Provinsi','/api/v1/**',2,'provinsi',NULL,false,false,NULL,NULL,'2024-05-14 15:21:36',NULL,'2024-05-14 15:21:36',3),
	 ('MNU_MNT0005','MNU_MNT0001','sijupri-admin','Kabupaten/Kota','/api/v1/**',2,'kab-kota',NULL,false,false,NULL,NULL,'2024-05-14 15:21:36',NULL,'2024-05-14 15:21:36',4),
	 
	 ('MNU_AKP0001',NULL,'sijupri-admin','AKP','/api/v1/**',1,'akp',NULL,false,false,NULL,NULL,'2024-05-14 15:21:36',NULL,'2024-05-14 15:21:36',1),
	 ('MNU_AKP0002','MNU_AKP0001','sijupri-admin','KKN','/api/v1/**',2,'kkn',NULL,false,false,NULL,NULL,'2024-05-14 15:21:36',NULL,'2024-05-14 15:21:36',2),
	 ('MNU_AKP0003','MNU_AKP0001','sijupri-admin','Pengajuan AKP','/api/v1/**',2,'akp-task-list',NULL,false,false,NULL,NULL,'2024-05-14 15:21:36',NULL,'2024-05-14 15:21:36',1),
	 ('MNU_AKP0004','MNU_AKP0001','sijupri-admin','Pemetaan AKP','/api/v1/**',2,'akp-list',NULL,false,false,NULL,NULL,'2024-05-14 15:21:36',NULL,'2024-05-14 15:21:36',3),
	 ('MNU_AKP0005','MNU_AKP0001','sijupri-admin','Pelatihan Teknis','/api/v1/**',2,'akp-pelatihan-list',NULL,false,false,NULL,NULL,'2024-05-14 15:21:36',NULL,'2024-05-14 15:21:36',4),
	 ('MNU_AKP0006','MNU_AKP0001','sijupri-admin','Validasi Pelatihan','/api/v1/**',2,'akp-pelatihan-validate',NULL,false,false,NULL,NULL,'2024-05-14 15:21:36',NULL,'2024-05-14 15:21:36',5),
	 
	 ('MNU_FOR0001',NULL,'sijupri-admin','Formasi','/api/v1/**',1,'formasi',NULL,false,false,NULL,NULL,'2024-05-14 15:21:36',NULL,'2024-05-14 15:21:36',2),
	 ('MNU_FOR0002','MNU_FOR0001','sijupri-admin','Pengajuan Formasi','/api/v1/**',2,'formasi-task-list',NULL,false,false,NULL,NULL,'2024-05-14 15:21:36',NULL,'2024-05-14 15:21:36',1),
	 ('MNU_FOR0003','MNU_FOR0001','sijupri-admin','Data Dukung Formasi','/api/v1/**',2,'formasi-document-list',NULL,false,false,NULL,NULL,'2024-05-14 15:21:36',NULL,'2024-05-14 15:21:36',2),
	 ('MNU_FOR0004','MNU_FOR0001','sijupri-admin','Pemetaan Formasi Seluruh Indonesia','/api/v1/**',2,'formasi-map',NULL,false,false,NULL,NULL,'2024-05-14 15:21:36',NULL,'2024-05-14 15:21:36',3),
	 ('MNU_FOR0005','MNU_FOR0001','sijupri-admin','Data Rekomendasi Formasi','/api/v1/**',2,'formasi-rekomendasi-list',NULL,false,false,NULL,NULL,'2024-05-14 15:21:36',NULL,'2024-05-14 15:21:36',4),
	 
	 ('MNU_PAK0001',NULL,'sijupri-admin','Monitoring Kinerja','/api/v1/**',1,'pak',NULL,false,false,NULL,NULL,'2024-05-14 15:21:36',NULL,'2024-05-14 15:21:36',3),
	 ('MNU_PAK0002','MNU_PAK0001','sijupri-admin','Pemetaan Kinerja','/api/v1/**',2,'pak-list',NULL,false,false,NULL,NULL,'2024-05-14 15:21:36',NULL,'2024-05-14 15:21:36',1),
	 
	 ('MNU_UKM0001',NULL,'sijupri-admin','UKom','/api/v1/**',1,'ukom',NULL,false,false,NULL,NULL,'2024-05-14 15:21:36',NULL,'2024-05-14 15:21:36',4),
	 ('MNU_UKM0002','MNU_UKM0001','sijupri-admin','Soal Ukom','/api/v1/**',2,'ukom-question',NULL,false,false,NULL,NULL,'2024-05-14 15:21:36',NULL,'2024-05-14 15:21:36',1),
	 ('MNU_UKM0003','MNU_UKM0001','sijupri-admin','Rekapitulasi Hasil Verifikasi Ukom','/api/v1/**',2,'ukom-list',NULL,false,false,NULL,NULL,'2024-05-14 15:21:36',NULL,'2024-05-14 15:21:36',2),
	 ('MNU_UKM0004','MNU_UKM0001','sijupri-admin','Pengajuan Ukom','/api/v1/**',2,'ukom-task-list',NULL,false,false,NULL,NULL,'2024-05-14 15:21:36',NULL,'2024-05-14 15:21:36',3),
	 ('MNU_UKM0005','MNU_UKM0001','sijupri-admin','Nilai Ukom','/api/v1/**',2,'ukom-grade-list',NULL,false,false,NULL,NULL,'2024-05-14 15:21:36',NULL,'2024-05-14 15:21:36',4),
	 ('MNU_UKM0006','MNU_UKM0001','sijupri-admin','Data Dukung UKom','/api/v1/**',2,'ukom-document-list',NULL,false,false,NULL,NULL,'2024-05-14 15:21:36',NULL,'2024-05-14 15:21:36',5),
	 ('MNU_UKM0007','MNU_UKM0001','sijupri-admin','Rumus UKom','/api/v1/**',2,'ukom-formula',NULL,false,false,NULL,NULL,'2024-05-14 15:21:36',NULL,'2024-05-14 15:21:36',6),
	 
	 ('MNU_SIP0001',NULL,'sijupri-admin','SIAP','/api/v1/**',1,'siap',NULL,false,false,NULL,NULL,'2024-05-14 15:21:36',NULL,'2024-05-14 15:21:36',5),
	 ('MNU_SIP0002','MNU_SIP0001','sijupri-admin','User JF','/api/v1/**',2,'user-jf',NULL,false,false,NULL,NULL,'2024-05-14 15:21:36',NULL,'2024-05-14 15:21:36',1),
	 ('MNU_SIP0003','MNU_SIP0001','sijupri-admin','User Instansi','/api/v1/**',2,'user-instansi',NULL,false,false,NULL,NULL,'2024-05-14 15:21:36',NULL,'2024-05-14 15:21:36',2),
	 ('MNU_SIP0004','MNU_SIP0001','sijupri-admin','User Unit Kerja','/api/v1/**',2,'user-unit-kerja',NULL,false,false,NULL,NULL,'2024-05-14 15:21:36',NULL,'2024-05-14 15:21:36',3),
	 
	 ('MNU_RPT0001',NULL,'sijupri-admin','Report','/api/v1/**',1,'siap',NULL,false,false,NULL,NULL,'2024-05-14 15:21:36',NULL,'2024-05-14 15:21:36',8),
	 ('MNU_RPT0002','MNU_RPT0001','sijupri-admin','Report SIAP','/api/v1/**',2,'report-siap',NULL,false,false,NULL,NULL,'2024-05-14 15:21:36',NULL,'2024-05-14 15:21:36',1),
	 ('MNU_RPT0003','MNU_RPT0001','sijupri-admin','Report AKP','/api/v1/**',2,'report-akp',NULL,false,false,NULL,NULL,'2024-05-14 15:21:36',NULL,'2024-05-14 15:21:36',2),
	 ('MNU_RPT0004','MNU_RPT0001','sijupri-admin','Report Formasi','/api/v1/**',2,'report-formasi',NULL,false,false,NULL,NULL,'2024-05-14 15:21:36',NULL,'2024-05-14 15:21:36',3),
	 ('MNU_RPT0005','MNU_RPT0001','sijupri-admin','Report UKom','/api/v1/**',2,'report-ukom',NULL,false,false,NULL,NULL,'2024-05-14 15:21:36',NULL,'2024-05-14 15:21:36',4),
	 
	 ('MNU_SIPI0001',NULL,'sijupri-instansi','SIAP','/api/v1/**',1,'siap',NULL,false,false,NULL,NULL,'2024-05-14 15:21:36',NULL,'2024-05-14 15:21:36',1),
	 ('MNU_SIPI0002','MNU_SIPI0001','sijupri-instansi','User JF','/api/v1/**',2,'user-jf',NULL,false,false,NULL,NULL,'2024-05-14 15:21:36',NULL,'2024-05-14 15:21:36',1),
	 ('MNU_SIPI0003','MNU_SIPI0001','sijupri-instansi','User Instansi','/api/v1/**',2,'user-instansi',NULL,false,false,NULL,NULL,'2024-05-14 15:21:36',NULL,'2024-05-14 15:21:36',2),
	 ('MNU_SIPI0004','MNU_SIPI0001','sijupri-instansi','User Unit Kerja','/api/v1/**',2,'user-unit-kerja',NULL,false,false,NULL,NULL,'2024-05-14 15:21:36',NULL,'2024-05-14 15:21:36',3),
	 
	 ('MNU_MNTI0001',NULL,'sijupri-instansi','Maintenance','/api/v1/**',1,'maintenance',NULL,false,false,NULL,NULL,'2024-05-14 15:21:36',NULL,'2024-05-14 15:21:36',2),
	 ('MNU_MNTI0002','MNU_MNTI0001','sijupri-instansi','Unit Kerja','/api/v1/**',2,'unit-kerja',NULL,false,false,NULL,NULL,'2024-05-14 15:21:36',NULL,'2024-05-14 15:21:36',1),
	 
	 ('MNU_SIPU0001',NULL,'sijupri-unit-kerja','SIAP','/api/v1/**',1,'siap',NULL,false,false,NULL,NULL,'2024-05-14 15:21:36',NULL,'2024-05-14 15:21:36',1),
	 ('MNU_SIPU0002','MNU_SIPU0001','sijupri-unit-kerja','User JF','/api/v1/**',2,'user-jf',NULL,false,false,NULL,NULL,'2024-05-14 15:21:36',NULL,'2024-05-14 15:21:36',1),
	 ('MNU_SIPU0005','MNU_SIPU0001','sijupri-unit-kerja','Verifikasi User JF','/api/v1/**',2,'verify-user-jf',NULL,false,false,NULL,NULL,'2024-05-14 15:21:36',NULL,'2024-05-14 15:21:36',2),
	 ('MNU_SIPU0003','MNU_SIPU0001','sijupri-unit-kerja','User Instansi','/api/v1/**',2,'user-instansi',NULL,false,false,NULL,NULL,'2024-05-14 15:21:36',NULL,'2024-05-14 15:21:36',3),
	 ('MNU_SIPU0004','MNU_SIPU0001','sijupri-unit-kerja','User Unit Kerja','/api/v1/**',2,'user-unit-kerja',NULL,false,false,NULL,NULL,'2024-05-14 15:21:36',NULL,'2024-05-14 15:21:36',4),
	 
	 ('MNU_FORU0001',NULL,'sijupri-unit-kerja','Formasi','/api/v1/**',1,'formasi',NULL,false,false,NULL,NULL,'2024-05-14 15:21:36',NULL,'2024-05-14 15:21:36',2),
	 ('MNU_FORU0002','MNU_FORU0001','sijupri-unit-kerja','Pendaftaran Formasi','/api/v1/**',2,'formasi-task',NULL,false,false,NULL,NULL,'2024-05-14 15:21:36',NULL,'2024-05-14 15:21:36',1),
	 ('MNU_FORU0003','MNU_FORU0001','sijupri-unit-kerja','Rekomendasi Formasi','/api/v1/**',2,'formasi-rekomendasi',NULL,false,false,NULL,NULL,'2024-05-14 15:21:36',NULL,'2024-05-14 15:21:36',2),
	 
	 ('MNU_AKPJE001',NULL,'sijupri-external','AKP','/api/v1/**',1,'akp',NULL,false,false,NULL,NULL,'2024-05-14 15:21:36',NULL,'2024-05-14 15:21:36',1),
	 ('MNU_AKPJE002','MNU_AKPJE001','sijupri-external','Penilaian AKP','/api/v1/**',2,'akp-task',NULL,false,false,NULL,NULL,'2024-05-14 15:21:36',NULL,'2024-05-14 15:21:36',1),
	 ('MNU_AKPJE003','MNU_AKPJE001','sijupri-external','Riwayat AKP','/api/v1/**',2,'akp-list',NULL,false,false,NULL,NULL,'2024-05-14 15:21:36',NULL,'2024-05-14 15:21:36',2),
	 
	 ('MNU_UKMJE001',NULL,'sijupri-external','UKom','/api/v1/**',1,'ukom',NULL,false,false,NULL,NULL,'2024-05-14 15:21:36',NULL,'2024-05-14 15:21:36',2),
	 ('MNU_UKMJE002','MNU_UKMJE001','sijupri-external','Pendaftaran Ukom','/api/v1/**',2,'ukom-task',NULL,false,false,NULL,NULL,'2024-05-14 15:21:36',NULL,'2024-05-14 15:21:36',1),
	 ('MNU_UKMJE003','MNU_UKMJE001','sijupri-external','Riwayat Ukom','/api/v1/**',2,'ukom-list',NULL,false,false,NULL,NULL,'2024-05-14 15:21:36',NULL,'2024-05-14 15:21:36',2),
	 
	 ('MNU_FORJE001',NULL,'sijupri-external','Formasi','/api/v1/**',1,'formasi',NULL,false,false,NULL,NULL,'2024-05-14 15:21:36',NULL,'2024-05-14 15:21:36',3),
	 ('MNU_FORJE002','MNU_FORJE001','sijupri-external','Daftar Formasi','/api/v1/**',2,'formasi-list',NULL,false,false,NULL,NULL,'2024-05-14 15:21:36',NULL,'2024-05-14 15:21:36',1),
	 
	 ('MNU_AKPJI001',NULL,'sijupri-internal','UKom','/api/v1/**',1,'akp',NULL,false,false,NULL,NULL,'2024-05-14 15:21:36',NULL,'2024-05-14 15:21:36',1),
	 ('MNU_AKPJI002','MNU_AKPJI001','sijupri-internal','Penilaian AKP','/api/v1/**',2,'akp-task',NULL,false,false,NULL,NULL,'2024-05-14 15:21:36',NULL,'2024-05-14 15:21:36',1),
	 ('MNU_AKPJI003','MNU_AKPJI001','sijupri-internal','Riwayat AKP','/api/v1/**',2,'akp-list',NULL,false,false,NULL,NULL,'2024-05-14 15:21:36',NULL,'2024-05-14 15:21:36',2),
	 
	 ('MNU_UKMJI001',NULL,'sijupri-internal','UKom','/api/v1/**',1,'ukom',NULL,false,false,NULL,NULL,'2024-05-14 15:21:36',NULL,'2024-05-14 15:21:36',2),
	 ('MNU_UKMJI002','MNU_UKMJI001','sijupri-internal','Pendaftaran Ukom','/api/v1/**',2,'ukom-task',NULL,false,false,NULL,NULL,'2024-05-14 15:21:36',NULL,'2024-05-14 15:21:36',1),
	 ('MNU_UKMJI003','MNU_UKMJI001','sijupri-internal','Riwayat Ukom','/api/v1/**',2,'ukom-list',NULL,false,false,NULL,NULL,'2024-05-14 15:21:36',NULL,'2024-05-14 15:21:36',2),
	 
	 ('MNU_FORJI001',NULL,'sijupri-internal','Formasi','/api/v1/**',1,'formasi',NULL,false,false,NULL,NULL,'2024-05-14 15:21:36',NULL,'2024-05-14 15:21:36',3),
	 ('MNU_FORJI002','MNU_FORJE001','sijupri-internal','Daftar Formasi','/api/v1/**',2,'formasi-list',NULL,false,false,NULL,NULL,'2024-05-14 15:21:36',NULL,'2024-05-14 15:21:36',1);

INSERT INTO sec_user_role (id,user_id,role_code,created_by,date_created,idx) VALUES
	 ('0478b542-b6de-4db6-905c-b2631e13e015','111111111111111111','ADMIN','system','2024-05-17 11:45:14',999);

INSERT INTO sec_role_menu (id,role_code,menu_code,created_by,date_created,idx) VALUES
	 ('1169b1df-6610-4371-b543-fcea2c201e71','ADMIN','MNU_SEC0001','system','2024-05-23 01:38:07',999),
	 ('1169b1df-6610-4371-b543-fcea2c201e72','ADMIN','MNU_SEC0002','system','2024-05-23 01:38:07',999),
	 ('1169b1df-6610-4371-b543-fcea2c201e73','ADMIN','MNU_SEC0003','system','2024-05-23 01:38:07',999),
	 
	 ('1169b1df-6610-4371-b543-fcea2c201e81','USER_INSTANSI','MNU_SIPI0001','system','2024-05-23 01:38:07',999),
	 ('1169b1df-6610-4371-b543-fcea2c201e82','USER_INSTANSI','MNU_SIPI0002','system','2024-05-23 01:38:07',999),
	 ('1169b1df-6610-4371-b543-fcea2c201e83','USER_INSTANSI','MNU_SIPI0003','system','2024-05-23 01:38:07',999),
	 ('1169b1df-6610-4371-b543-fcea2c201e84','USER_INSTANSI','MNU_SIPI0004','system','2024-05-23 01:38:07',999),
	 ('1169b1df-6610-4371-b543-fcea2c201e85','USER_INSTANSI','MNU_MNTI0001','system','2024-05-23 01:38:07',999),
	 ('1169b1df-6610-4371-b543-fcea2c201e86','USER_INSTANSI','MNU_MNTI0002','system','2024-05-23 01:38:07',999),

	 ('1169b1df-6610-4371-b543-fcea2c201e91','USER_UNIT_KERJA','MNU_SIPU0001','system','2024-05-23 01:38:07',999),
	 ('1169b1df-6610-4371-b543-fcea2c201e92','USER_UNIT_KERJA','MNU_SIPU0002','system','2024-05-23 01:38:07',999),
	 ('1169b1df-6610-4371-b543-fcea2c201e93','USER_UNIT_KERJA','MNU_SIPU0003','system','2024-05-23 01:38:07',999),
	 ('1169b1df-6610-4371-b543-fcea2c201e94','USER_UNIT_KERJA','MNU_SIPU0004','system','2024-05-23 01:38:07',999),
	 ('1169b1df-6610-4371-b543-fcea2c201e95','USER_UNIT_KERJA','MNU_FORU0001','system','2024-05-23 01:38:07',999),
	 ('1169b1df-6610-4371-b543-fcea2c201e96','USER_UNIT_KERJA','MNU_FORU0002','system','2024-05-23 01:38:07',999),
	 ('1169b1df-6610-4371-b543-fcea2c201e97','USER_UNIT_KERJA','MNU_FORU0003','system','2024-05-23 01:38:07',999),
	 ('1169b1df-6610-4371-b543-fcea2c201e99','USER_UNIT_KERJA','MNU_SIPU0005','system','2024-05-23 01:38:07',999),

	 ('1969b1df-6610-4371-b543-fcea2c201e91','USER_EXTERNAL','MNU_AKPJE001','system','2024-05-23 01:38:07',999),
	 ('1969b1df-6610-4371-b543-fcea2c201e92','USER_EXTERNAL','MNU_AKPJE002','system','2024-05-23 01:38:07',999),
	 ('1969b1df-6610-4371-b543-fcea2c201e93','USER_EXTERNAL','MNU_AKPJE003','system','2024-05-23 01:38:07',999),
	 ('1969b1df-6610-4371-b543-fcea2c201e94','USER_EXTERNAL','MNU_UKMJE001','system','2024-05-23 01:38:07',999),
	 ('1969b1df-6610-4371-b543-fcea2c201e95','USER_EXTERNAL','MNU_UKMJE002','system','2024-05-23 01:38:07',999),
	 ('1969b1df-6610-4371-b543-fcea2c201e96','USER_EXTERNAL','MNU_UKMJE003','system','2024-05-23 01:38:07',999),
	 ('1969b1df-6610-4371-b543-fcea2c201e97','USER_EXTERNAL','MNU_FORJE001','system','2024-05-23 01:38:07',999),
	 ('1969b1df-6610-4371-b543-fcea2c201e99','USER_EXTERNAL','MNU_FORJE002','system','2024-05-23 01:38:07',999),

	 ('2969b1df-6610-4371-b543-fcea2c201e91','USER_INTERNAL','MNU_AKPJI001','system','2024-05-23 01:38:07',999),
	 ('2969b1df-6610-4371-b543-fcea2c201e92','USER_INTERNAL','MNU_AKPJI002','system','2024-05-23 01:38:07',999),
	 ('2969b1df-6610-4371-b543-fcea2c201e93','USER_INTERNAL','MNU_AKPJI003','system','2024-05-23 01:38:07',999),
	 ('2969b1df-6610-4371-b543-fcea2c201e94','USER_INTERNAL','MNU_UKMJI001','system','2024-05-23 01:38:07',999),
	 ('2969b1df-6610-4371-b543-fcea2c201e95','USER_INTERNAL','MNU_UKMJI002','system','2024-05-23 01:38:07',999),
	 ('2969b1df-6610-4371-b543-fcea2c201e96','USER_INTERNAL','MNU_UKMJI003','system','2024-05-23 01:38:07',999),
	 ('2969b1df-6610-4371-b543-fcea2c201e97','USER_INTERNAL','MNU_FORJI001','system','2024-05-23 01:38:07',999),
	 ('2969b1df-6610-4371-b543-fcea2c201e99','USER_INTERNAL','MNU_FORJI002','system','2024-05-23 01:38:07',999);