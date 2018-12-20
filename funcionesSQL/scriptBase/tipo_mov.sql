CREATE OR REPLACE TABLE tipo_mov(
	tipo_mov      char(4)     NOT NULL,
	mov           varchar(40) NOT NULL,
    activo        int(1)      NOT NULL,
    usr_ult_mod   int(11)     NOT NULL,
	fec_ult_mod   date        NOT NULL,
	PRIMARY KEY (tipo_mov),
	FOREIGN KEY (usr_ult_mod)     REFERENCES users(user_id)
	);
COMMIT;




