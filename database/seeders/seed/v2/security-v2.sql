INSERT INTO sec_application (code,name, idx) VALUES
	 ('siukom-participant','Participant Ukom', 6),
	 ('siukom-examiner','Examiner Ukom', 7);

INSERT INTO sec_application_channel (id, auth_type, application_code, channel_code) VALUES
	 ('9478b542-b6de-4db6-905c-b2631e130001', 'password', 'siukom-participant', 'WEB'),
	 ('9478b542-b6de-4db6-905c-b2631e130002', 'password', 'siukom-participant', 'MOBILE'),
	 ('9478b542-b6de-4db6-905c-b2631e130003', 'password', 'siukom-examiner', 'WEB'),
	 ('9478b542-b6de-4db6-905c-b2631e130004', 'password', 'siukom-examiner', 'MOBILE');