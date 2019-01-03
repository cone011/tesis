/*Venta*/
CREATE OR REPLACE VIEW detalle_cuenta_cliente AS 
SELECT 'FACTURA' AS TIPO,
       CASE 
		 WHEN tipo_pago = 1 THEN 'EFECTIVO'
       WHEN tipo_pago = 2 THEN 'TARJETA'
       WHEN tipo_pago = 3 THEN 'CHEQUE'
       WHEN tipo_pago = 4 THEN 'TRANSFERENCIA'
       WHEN tipo_pago = 5 THEN 'COMBINADO'
       ELSE 'N/A'
       END AS FORMA_DE_PAGO,
       numero_factura AS NRO_FACTURA,
       0				    AS NRO_PAGO,
       CONVERT(total_venta,INTEGER)    AS MONTO_TOTAL,
       saldo_factura  AS SALDO_FACTURA,
       id_cliente     AS ID_CLIENTE
  FROM venta
 WHERE total_venta > 0
	AND condiciones != '999'
UNION /*cobranza*/
   SELECT 'PAGO' AS TIPO,
       CASE 
		 WHEN tipo_pago = 1 THEN 'EFECTIVO'
       WHEN tipo_pago = 2 THEN 'TARJETA'
       WHEN tipo_pago = 3 THEN 'CHEQUE'
       WHEN tipo_pago = 4 THEN 'TRANSFERENCIA'
       WHEN tipo_pago = 5 THEN 'COMBINADO'
       ELSE 'N/A'
       END AS FORMA_DE_PAGO,
       numero_venta   AS NRO_FACTURA,
       numero_factura AS NRO_PAGO,
       efectivo       AS MONTO_TOTAL,
       0              AS SALDO_FACTURA,
       id_cliente     AS ID_CLIENTE
  FROM cobranza
 WHERE condiciones != 999
;COMMIT;
 GRANT SELECT ON detalle_cuenta_cliente TO USERS;
 COMMIT;  
