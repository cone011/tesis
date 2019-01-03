CREATE OR REPLACE VIEW cierre_totales AS (
SELECT SUM(a.total_venta) AS total,
       tipo_pago,
       CASE 
		 WHEN tipo_pago = 1 THEN 'EFECTIVO'
       WHEN tipo_pago = 2 THEN 'TARJETA'
       WHEN tipo_pago = 3 THEN 'CHEQUE'
       WHEN tipo_pago = 4 THEN 'TRANSFERENCIA'
       END
  FROM venta a
  WHERE numero_factura BETWEEN 
      (SELECT factura_incial
			FROM cierre
			ORDER BY id_cierre DESC
			LIMIT 1) 
	AND (SELECT factura_final
			FROM cierre
			ORDER BY id_cierre DESC
			LIMIT 1)
	AND tipo_pago != 5
 GROUP BY tipo_pago
 ) 
;COMMIT;
 GRANT SELECT ON cierre_totales TO USERS;
 COMMIT;

CREATE OR REPLACE	 VIEW cierre_ingreso_caja AS (
SELECT ((SELECT total
           FROM cierre_totales 
			 WHERE tipo_pago = 1 )+
                 (SELECT SUM(efectivo)
  		            FROM venta
						WHERE tipo_pago = 5
						AND efectivo != 0
						AND numero_factura BETWEEN 
					      (SELECT factura_incial
								FROM cierre
					    	 ORDER BY id_cierre DESC
							LIMIT 1) 
			    			AND (SELECT factura_final
									FROM cierre
		    					ORDER BY id_cierre DESC
								LIMIT 1))) AS TOTAL_EFECTIVO,
		((SELECT total
           FROM cierre_totales 
			 WHERE tipo_pago = 2 )+
                 (SELECT SUM(tarjeta)
  		            FROM venta
						WHERE tipo_pago = 5
						AND efectivo != 0
						AND numero_factura BETWEEN 
					      (SELECT factura_incial
								FROM cierre
					    	 ORDER BY id_cierre DESC
							LIMIT 1) 
			    			AND (SELECT factura_final
									FROM cierre
		    					ORDER BY id_cierre DESC
								LIMIT 1))) AS TOTAL_TARJETA,
		((SELECT total
           FROM cierre_totales 
			 WHERE tipo_pago = 3 )+
                 (SELECT SUM(cheque)
  		            FROM venta
						WHERE tipo_pago = 5
						AND efectivo != 0
						AND numero_factura BETWEEN 
					      (SELECT factura_incial
								FROM cierre
					    	 ORDER BY id_cierre DESC
							LIMIT 1) 
			    			AND (SELECT factura_final
									FROM cierre
		    					ORDER BY id_cierre DESC
								LIMIT 1))) AS TOTAL_CHEQUE,
		 ((SELECT total
           FROM cierre_totales 
			 WHERE tipo_pago = 4 )+
                 (SELECT SUM(transferencia)
  		            FROM venta
						WHERE tipo_pago = 5
						AND efectivo != 0
						AND numero_factura BETWEEN 
					      (SELECT factura_incial
								FROM cierre
					    	 ORDER BY id_cierre DESC
							LIMIT 1) 
			    			AND (SELECT factura_final
									FROM cierre
		    					ORDER BY id_cierre DESC
								LIMIT 1))) AS TOTAL_TRANSFERENCIA,
		 (SELECT SUM(a.total_venta) AS saldo_cobrado
  			FROM cobranza a
 		  WHERE numero_factura BETWEEN 
    			  (SELECT cobranza_inicial
				  	  FROM cierre
		   	    ORDER BY id_cierre DESC
			   	 LIMIT 1) 
	 		AND (SELECT cobranza_final
					FROM cierre
			ORDER BY id_cierre DESC
			LIMIT 1)) AS SALDO_COBRADO
  FROM dual
  )
 ;COMMIT;
 
 GRANT SELECT ON cierre_ingreso_caja TO USERS;
 COMMIT;


      