INSERT INTO tbl_role (code,created_at,updated_at,created_by,updated_by,name,description,delete_flag,inactive_flag,task_status,comment,tipe,base) VALUES
	 ('admin_akp','2024-02-07 09:14:11',NULL,'system',NULL,'Admin Akp','1',0,0,NULL,NULL,'sijupri','admin_sijupri'),
	 ('admin_formasi','2024-02-07 09:14:11',NULL,'system',NULL,'Admin Formasi','1',0,0,NULL,NULL,'sijupri','admin_sijupri'),
	 ('admin_instansi','2024-02-07 09:14:11',NULL,'system',NULL,'Admin PusBin','1',0,0,NULL,NULL,'siap',NULL),
	 ('admin_pak','2024-02-07 09:14:11',NULL,'system',NULL,'Admin Pak','1',0,0,NULL,NULL,'sijupri','admin_sijupri'),
	 ('admin_sijupri','2024-02-07 09:14:11',NULL,'system',NULL,'Super Admin','1',0,0,NULL,NULL,'sijupri',NULL),
	 ('admin_ukom','2024-02-07 09:14:11',NULL,'system',NULL,'Admin Ukom','1',0,0,NULL,NULL,'sijupri','admin_sijupri'),
	 ('bkpsdm_bkd','2024-02-07 09:14:11',NULL,'system',NULL,'Instansi Daerah','1',0,0,NULL,NULL,'siap','admin_instansi'),
	 ('opd','2024-02-07 09:14:11',NULL,'system',NULL,'admin opd','1',0,0,NULL,NULL,'siap','pengatur_siap'),
	 ('pengatur_siap','2024-02-07 09:14:11',NULL,'system',NULL,'pengatur_siap','1',0,0,NULL,NULL,'siap',NULL),
	 ('pusbin','2024-02-07 09:14:11',NULL,'system',NULL,'Admin PusBin','1',0,0,NULL,NULL,'siap','admin_instansi');
INSERT INTO tbl_role (code,created_at,updated_at,created_by,updated_by,name,description,delete_flag,inactive_flag,task_status,comment,tipe,base) VALUES
	 ('ses','2024-02-07 09:14:11',NULL,'system',NULL,'ses','1',0,0,NULL,NULL,'siap','pengatur_siap'),
	 ('super_admin','2024-02-07 09:14:11',NULL,'system',NULL,'Super Admin','1',0,0,NULL,NULL,'sijupri','admin_sijupri'),
	 ('unit_kerja','2024-02-07 09:14:11',NULL,'system',NULL,'unit kerja','1',0,0,NULL,NULL,'siap','pengatur_siap'),
	 ('unit_pembina','2024-02-07 09:14:11',NULL,'system',NULL,'Instansi Kementerian Lembaga','1',0,0,NULL,NULL,'siap','admin_instansi'),
	 ('user','2024-02-07 09:14:11',NULL,'system',NULL,'user','1',0,0,NULL,NULL,'siap',NULL),
	 ('user_external','2024-02-07 09:14:11',NULL,'system',NULL,'user','1',0,0,NULL,NULL,'siap','user'),
	 ('user_internal','2024-02-07 09:14:11',NULL,'system',NULL,'user','1',0,0,NULL,NULL,'siap','user');
