CREATE OR REPLACE TABLE cliente_movs(
	id_mov_cli      int(11) NOT NULL AUTO_INCREMENT,
	numero_factura  int(11) NOT NULL,
   id_cliente      int(11) NOT NULL,
   nro_cuota       int(11) NOT NULL,
	fec_mov         date    NOT NULL,
	importe_dc      int(11) NOT NULL,
	importe_cobrado int(11) NOT NULL,
	dc              int(1)  NOT NULL,
	id_vendedor     int(11) NOT NULL,
	tipo_mov        int     NOT NULL,
	PRIMARY KEY (id_mov_cli),
	UNIQUE KEY numero_cotizacion (numero_factura),
	FOREIGN KEY (numero_factura) REFERENCES venta(numero_factura),
	FOREIGN KEY (id_vendedor)    REFERENCES users(user_id),
	FOREIGN KEY (id_cliente)     REFERENCES cliente(id_cliente)
	);
COMMIT;




