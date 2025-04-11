INSERT INTO sec_menu (code,parent_menu_code,application_code,name,url,level,path,description,delete_flag,inactive_flag,version,updated_by,last_updated,created_by,date_created,idx) VALUES
	 ('MNU_MNT0006','MNU_MNT0001','sijupri-admin','Kompetensi','/api/v1/**',2,'kompetensi-list',NULL,false,false,NULL,NULL,'2024-05-14 15:21:36',NULL,'2024-05-14 15:21:36',5),
	 ('MNU_MNT0007','MNU_MNT0001','sijupri-admin','Konfigurasi Sistem','/api/v1/**',2,'sys-conf-list',NULL,false,false,NULL,NULL,'2024-05-14 15:21:36',NULL,'2024-05-14 15:21:36',6),

	 ('MNU_PAK0003','MNU_PAK0001','sijupri-admin','Konfirmasi Data Kinerja','/api/v1/**',2,'pak-task-list',NULL,false,false,NULL,NULL,'2024-05-14 15:21:36',NULL,'2024-05-14 15:21:36',2),

	 ('MNU_UKM0008','MNU_UKM0001','sijupri-admin','Kelas','/api/v1/**',2,'ukom-room-list',NULL,false,false,NULL,NULL,'2024-05-14 15:21:36',NULL,'2024-05-14 15:21:36',7),
	 ('MNU_UKM0009','MNU_UKM0001','sijupri-admin','Peserta Ukom','/api/v1/**',2,'ukom-participant-list',NULL,false,false,NULL,NULL,'2024-05-14 15:21:36',NULL,'2024-05-14 15:21:36',8),
	 ('MNU_UKM0010','MNU_UKM0001','sijupri-admin','Penguji Ukom','/api/v1/**',2,'ukom-examiner-list',NULL,false,false,NULL,NULL,'2024-05-14 15:21:36',NULL,'2024-05-14 15:21:36',9),
	 ('MNU_UKM0011','MNU_UKM0001','sijupri-admin','Rumus Ukom','/api/v1/**',2,'ukom-formula',NULL,false,false,NULL,NULL,'2024-05-14 15:21:36',NULL,'2024-05-14 15:21:36',10);