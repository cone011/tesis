/*Venta*/
CREATE OR REPLACE VIEW cierre_detalle AS 
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
       0				    AS NRO_COMPRA,
       0				    AS NRO_PAGO,
       0				    AS NRO_NC,
       CAST(total_venta as UNSIGNED )AS MONTO_TOTAL,
       saldo_factura  AS SALDO_FACTURA
  FROM venta
 WHERE /* numero_factura BETWEEN 
    	 (SELECT factura_incial
	  	    FROM cierre
			ORDER BY id_cierre DESC
		   LIMIT 1) 
	AND (SELECT factura_final
			FROM cierre
	     ORDER BY id_cierre DESC
		  LIMIT 1)
	AND */ total_venta > 0
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
       0				    AS NRO_COMPRA,
       numero_factura AS NRO_PAGO,
       0				    AS NRO_NC,
       efectivo       AS MONTO_TOTAL,
       0              AS SALDO_FACTURA
  FROM cobranza
 WHERE /* numero_factura BETWEEN 
    	 (SELECT cobranza_inicial
	  	    FROM cierre
			ORDER BY id_cierre DESC
		   LIMIT 1) 
	AND (SELECT cobranza_final
			FROM cierre
	     ORDER BY id_cierre DESC
		  LIMIT 1)
	AND */ condiciones != 999
UNION /*compra*/
   SELECT 'COMPRA' AS TIPO,
          CASE 
		    WHEN tipo_pago = 1 THEN 'EFECTIVO'
       	 WHEN tipo_pago = 2 THEN 'TARJETA'
    	    WHEN tipo_pago = 3 THEN 'CHEQUE'
      	 WHEN tipo_pago = 4 THEN 'TRANSFERENCIA'
      	 WHEN tipo_pago = 5 THEN 'COMBINADO'
      	 ELSE 'N/A'
      	 END AS FORMA_DE_PAGO,
        	 0					 AS NRO_FACTURA,
       	 numero_factura AS NRO_COMPRA,
       	 0     		    AS NRO_PAGO,
      	 0				    AS NRO_NC,
      	 total_venta	 AS MONTO_TOTAL,
       	 0              AS SALDO_FACTURA
	FROM compra
	WHERE condiciones != 999
	  /* AND numero_factura BETWEEN 
         (SELECT compra_inicial
			   FROM cierre
		  	ORDER BY id_cierre DESC
			LIMIT 1) 
	 AND (SELECT compra_final
			FROM cierre
			ORDER BY id_cierre DESC
			LIMIT 1) */
	 AND tipo_pago NOT IN (0,5)
	GROUP BY tipo_pago
;COMMIT;
 GRANT SELECT ON cierre_detalle TO USERS;
 COMMIT;  
