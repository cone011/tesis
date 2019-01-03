/*compra*/
CREATE OR REPLACE VIEW detalle_cuenta_proveedor AS 
   SELECT 'COMPRA' AS TIPO,
          CASE 
		    WHEN tipo_pago = 1 THEN 'EFECTIVO'
       	 WHEN tipo_pago = 2 THEN 'TARJETA'
    	    WHEN tipo_pago = 3 THEN 'CHEQUE'
      	 WHEN tipo_pago = 4 THEN 'TRANSFERENCIA'
      	 WHEN tipo_pago = 5 THEN 'COMBINADO'
      	 ELSE 'N/A'
      	 END AS FORMA_DE_PAGO,
       	 numero_factura AS NRO_COMPRA,
      	 0				    AS NRO_OP,
      	 total_venta	 AS MONTO_TOTAL,
       	 0              AS SALDO_FACTURA,
       	 id_cliente     AS ID_PROVEEDOR,
         fecha_factura     AS FECHA
	FROM compra
	WHERE estado_factura != 10
	 AND tipo_pago NOT IN (0,5)
	GROUP BY tipo_pago
UNION /*op*/
   SELECT 'OPAGO' AS TIPO,
       CASE 
		 WHEN tipo_pago = 1 THEN 'EFECTIVO'
       WHEN tipo_pago = 2 THEN 'TARJETA'
       WHEN tipo_pago = 3 THEN 'CHEQUE'
       WHEN tipo_pago = 4 THEN 'TRANSFERENCIA'
       WHEN tipo_pago = 5 THEN 'COMBINADO'
       ELSE 'N/A'
       END AS FORMA_DE_PAGO,
       numero_venta	 AS NRO_COMPRA,
       numero_factura AS NRO_OP,
       total_venta    AS MONTO_TOTAL,
       0              AS SALDO_FACTURA,
       id_cliente     AS ID_PROVEEDOR,
       fecha_factura     AS FECHA
  FROM op
 WHERE condiciones != 999
;COMMIT;
 GRANT SELECT ON detalle_cuenta_proveedor TO USERS;
 COMMIT;  
