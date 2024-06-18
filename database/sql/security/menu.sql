INSERT INTO tbl_menu (code,created_at,updated_at,created_by,updated_by,name,lvl,idx,routes,app_code,description,delete_flag,inactive_flag,parent_code) VALUES
	 ('AKP_1',NULL,NULL,'system',NULL,'AKP',0,1,'','USER,PUSBIN',NULL,false,false,NULL),
	 ('AKP_2',NULL,NULL,'system',NULL,'Review',1,1,'/akp/review,/akp/review/personal','USER',NULL,false,false,'AKP_1'),
	 ('AKP_3',NULL,NULL,'system',NULL,'KKN',1,1,'/akp/kkn/**','USER,PUSBIN',NULL,false,false,'AKP_1'),
	 ('AKP_4',NULL,NULL,'system',NULL,'Daftar',1,1,'/akp/daftar/**,/akp/edit_matrix,/akp/upload_rekomendasi','PUSBIN',NULL,false,false,'AKP_1'),
	 ('AKP_5',NULL,NULL,'system',NULL,'Pemetaan AKP',1,1,'/akp/pemetaan_akp/**,/akp/daftar_user_akp/**,/akp/edit_matrix','PUSBIN',NULL,false,false,'AKP_1'),
	 ('AUD_1',NULL,NULL,'system',NULL,'Audit',0,7,'','PUSBIN',NULL,false,false,NULL),
	 ('AUD_2',NULL,NULL,'system',NULL,'Riwayat Login',1,1,'/audit/riwayat_login/**','PUSBIN',NULL,false,false,'AUD_1'),
	 ('AUD_3',NULL,NULL,'system',NULL,'Riwayat Aktivitas',1,1,'/audit/riwayat_aktivitas/**','PUSBIN',NULL,false,false,'AUD_1'),
	 ('DAS_1',NULL,NULL,'system',NULL,'Dashboard',0,0,'/dashboard,/profile/**,/message/**,/pengumuman/**,/siap/**,/api/v1/**','USER,PUSBIN',NULL,false,false,NULL),
	 ('FOR_1',NULL,NULL,'system',NULL,'Formasi',0,3,'','USER,PUSBIN',NULL,false,false,NULL);
INSERT INTO tbl_menu (code,created_at,updated_at,created_by,updated_by,name,lvl,idx,routes,app_code,description,delete_flag,inactive_flag,parent_code) VALUES
	 ('FOR_10',NULL,NULL,'system',NULL,'Data Rekomendasi Formasi',1,1,'/formasi/data_rekomendasi_formasi','USER',NULL,false,false,'FOR_1'),
	 ('FOR_11',NULL,NULL,'system',NULL,'Request Formasi',1,1,'/formasi/request_formasi/**','PUSBIN',NULL,false,false,'FOR_1'),
	 ('FOR_12',NULL,NULL,'system',NULL,'Pemetaan Formasi Seluruh Indonesia',1,1,'/formasi/pemetaan_formasi_seluruh_indonesia/**','PUSBIN',NULL,false,false,'FOR_1'),
	 ('FOR_13',NULL,NULL,'system',NULL,'Pendaftaran Formasi',1,1,'/formasi/pendaftaran_formasi/**,/formasi/upload_dokumen/**','USER',NULL,false,false,'FOR_1'),
	 ('FOR_14',NULL,NULL,'system',NULL,'Proses Verifikasi Dokumen',1,1,'/formasi/proses_verifikasi_dokumen','USER',NULL,false,false,'FOR_1'),
	 ('FOR_8',NULL,NULL,'system',NULL,'Data Rekomendasi Formasi',1,1,'/formasi/data_rekomendasi_formasi/**,/formasi/daftar,/formasi/import,/formasi/upload_rekomendasi','PUSBIN',NULL,false,false,'FOR_1'),
	 ('FOR_9',NULL,NULL,'system',NULL,'Data Rekomendasi Formasi',1,1,'/formasi/data_rekomendasi_formasi,/formasi/jabatan/konfirmasi/**','USER',NULL,false,false,'FOR_1'),
	 ('MNT_1',NULL,NULL,'system',NULL,'Maintenance',0,5,'','USER,PUSBIN',NULL,false,false,NULL),
	 ('MNT_10',NULL,NULL,'system',NULL,'Konfigurasi',1,1,'/maintenance/konfigurasi/**','PUSBIN',NULL,false,false,'MNT_1'),
	 ('MNT_2',NULL,NULL,'system',NULL,'Pendidikan',1,1,'/maintenance/pendidikan','PUSBIN',NULL,false,false,'MNT_1');
INSERT INTO tbl_menu (code,created_at,updated_at,created_by,updated_by,name,lvl,idx,routes,app_code,description,delete_flag,inactive_flag,parent_code) VALUES
	 ('MNT_3',NULL,NULL,'system',NULL,'Jabatan',1,1,'/maintenance/jabatan','PUSBIN',NULL,false,false,'MNT_1'),
	 ('MNT_4',NULL,NULL,'system',NULL,'Jenjang',1,1,'/maintenance/jenjang','PUSBIN',NULL,false,false,'MNT_1'),
	 ('MNT_5',NULL,NULL,'system',NULL,'Pangkat',1,1,'/maintenance/pangkat','PUSBIN',NULL,false,false,'MNT_1'),
	 ('MNT_6',NULL,NULL,'system',NULL,'Unit Kerja/Instansi Daerah',1,1,'/maintenance/unit_kerja_instansi_daerah','USER,PUSBIN',NULL,false,false,'MNT_1'),
	 ('MNT_7',NULL,NULL,'system',NULL,'Provinsi',1,1,'/maintenance/provinsi/**','PUSBIN',NULL,false,false,'MNT_1'),
	 ('MNT_8',NULL,NULL,'system',NULL,'Kabupaten',1,1,'/maintenance/kabupaten/**','PUSBIN',NULL,false,false,'MNT_1'),
	 ('MNT_9',NULL,NULL,'system',NULL,'Kota',1,1,'/maintenance/kota/**','PUSBIN',NULL,false,false,'MNT_1'),
	 ('PAK_1',NULL,NULL,'system',NULL,'Monitoring Kinerja',0,6,'','USER,PUSBIN',NULL,false,false,NULL),
	 ('PAK_2',NULL,NULL,'system',NULL,'Pemetaan Kinerja',1,1,'/monitoring_kinerja/pemetaan_kinerja/**','PUSBIN',NULL,false,false,'PAK_1'),
	 ('RPT_1',NULL,NULL,'system',NULL,'Report',0,4,'/report/download/**,/report/hapus/**','PUSBIN',NULL,false,false,NULL);
INSERT INTO tbl_menu (code,created_at,updated_at,created_by,updated_by,name,lvl,idx,routes,app_code,description,delete_flag,inactive_flag,parent_code) VALUES
	 ('RPT_2',NULL,NULL,'system',NULL,'Rekomendasi Formasi',1,1,'/report/rekomendasi_formasi/**','PUSBIN',NULL,false,false,'RPT_1'),
	 ('SEC_1',NULL,NULL,'system',NULL,'Security',0,8,'','PUSBIN',NULL,false,false,NULL),
	 ('SEC_2',NULL,NULL,'system',NULL,'User',1,1,'/security/user/**,/registration/sijupri/**','PUSBIN',NULL,false,false,'SEC_1'),
	 ('SEC_3',NULL,NULL,'system',NULL,'Role',1,1,'/security/role/**','PUSBIN',NULL,false,false,'SEC_1'),
	 ('UKM_1',NULL,NULL,'system',NULL,'UKom',0,2,'','USER,PUSBIN',NULL,false,false,NULL),
	 ('UKM_10',NULL,NULL,'system',NULL,'Riwayat UKom',1,1,'/ukom/riwayat_ukom/**','USER',NULL,false,false,'UKM_1'),
	 ('UKM_11',NULL,NULL,'system',NULL,'Pendaftaran UKom',1,1,'/ukom/pendaftaran_ukom/**,,/ukom/kenaikan_jenjang/**,/ukom/perpindahan_jabatan/**','USER',NULL,false,false,'UKM_1'),
	 ('UKM_2',NULL,NULL,'system',NULL,'Periode',1,1,'/ukom/periode/**,/ck_editor_upload','PUSBIN',NULL,false,false,'UKM_1'),
	 ('UKM_5',NULL,NULL,'system',NULL,'Pemetaan Ukom',1,1,'/ukom/pemetaan_ukom/**,/ukom/upload_rekomendasi','PUSBIN',NULL,false,false,'UKM_1'),
	 ('UKM_6',NULL,NULL,'system',NULL,'Import Nilai',1,1,'/ukom/import_nilai/**','PUSBIN',NULL,false,false,'UKM_1');
INSERT INTO tbl_menu (code,created_at,updated_at,created_by,updated_by,name,lvl,idx,routes,app_code,description,delete_flag,inactive_flag,parent_code) VALUES
	 ('UKM_8',NULL,NULL,'system',NULL,'Pendaftaran',1,1,'/ukom/pendaftaran/**','PUSBIN',NULL,false,false,'UKM_1'),
	 ('USR_1',NULL,NULL,'system',NULL,'User',0,9,'','USER,PUSBIN',NULL,false,false,NULL),
	 ('USR_2',NULL,NULL,'system',NULL,'Admin Instansi',1,1,'/user/admin_instansi/**,/registration/instansi/**','USER,PUSBIN',NULL,false,false,'USR_1'),
	 ('USR_3',NULL,NULL,'system',NULL,'Admin Unit Kerja/Instansi Daerah',1,1,'/user/admin_unit_kerja_instansi_daerah/**,/registration/pengelola/**','USER,PUSBIN',NULL,false,false,'USR_1'),
	 ('USR_4',NULL,NULL,'system',NULL,'User JF',1,1,'/user/user_jf/**,/registration/user/**','USER,PUSBIN',NULL,false,false,'USR_1');
