CREATE OR REPLACE VIEW cierre_totales_2 AS (
SELECT SUM(a.total_venta) AS total,
       tipo_pago,
       CASE 
		WHEN tipo_pago = 1 THEN 'EFECTIVO'
		WHEN tipo_pago = 2 THEN 'TARJETA'
		WHEN tipo_pago = 3 THEN 'CHEQUE'
		WHEN tipo_pago = 4 THEN 'TRANSFERENCIA'
       END
  FROM compra a
  WHERE numero_factura BETWEEN 
      (SELECT compra_inicial
			FROM cierre
			ORDER BY id_cierre DESC
			LIMIT 1) 
	AND (SELECT compra_final
			FROM cierre
			ORDER BY id_cierre DESC
			LIMIT 1)
	AND tipo_pago NOT IN (0,5)
	GROUP BY tipo_pago)
;COMMIT;
 GRANT SELECT ON cierre_totales_2 TO USERS
 ;COMMIT;
 
 CREATE OR REPLACE VIEW cierre_egreso_caja AS (
 SELECT (SELECT total
           FROM cierre_totales_2 
          WHERE tipo_pago = 1) AS TOTAL_EFECTIVO,
        (SELECT total
           FROM cierre_totales_2 
          WHERE tipo_pago = 2) AS TOTAL_TARJETA,
        (SELECT total
           FROM cierre_totales_2 
          WHERE tipo_pago = 3) AS TOTAL_CHEQUE,
        (SELECT total
           FROM cierre_totales_2 
          WHERE tipo_pago = 3) AS TOTAL_TRANSFERENCIA,
        ((SELECT SUM(a.total_venta) AS saldo_cobrado
  			FROM op a
 		  WHERE numero_factura BETWEEN 
    			  (SELECT op_inicial
				  	  FROM cierre
		   	    ORDER BY id_cierre DESC
			   	 LIMIT 1) 
	 		AND (SELECT op_final
					FROM cierre
			ORDER BY id_cierre DESC
			LIMIT 1))) AS SALDO_PAGADO
  FROM dual
)
;COMMIT;
 GRANT SELECT ON cierre_egreso_caja TO USERS;
 COMMIT;  
