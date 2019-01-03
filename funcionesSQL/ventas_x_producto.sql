CREATE OR REPLACE VIEW ventas_x_producto AS
SELECT a.fecha       				  AS FECHA,
       a.id_producto 				  AS ID_PRODUCTO,
		 b.nombre_producto 			  AS PRODUCTO,
		 a.cantidad     			     AS CANTIDAD,
		 a.precio_venta   			  AS PRECIO_UNITARIO,
		 a.numero_factura   			  AS NUMERO_VENTA,
		 CASE
		 WHEN tipo != 1 THEN
		 a.cantidad * a.precio_venta
		 WHEN tipo = 1  THEN
		 0 
		 END AS TOTAL
  FROM detalle_venta a
  JOIN productos b
    ON a.id_producto = b.id_producto
 WHERE fecha != '000000'
 ORDER BY id_producto
;COMMIT;
 GRANT SELECT ON ventas_x_producto TO USERS;
 COMMIT;  
