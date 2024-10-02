DELIMITER //

CREATE TRIGGER actualizar_valoracion_media
AFTER INSERT ON valoraciones
FOR EACH ROW
BEGIN
    DECLARE promedio DECIMAL(3,2);
    
    SELECT AVG(puntuacion) INTO promedio
    FROM valoracions
    WHERE id_producto = NEW.id_producto;

    UPDATE productos
    SET valoracion_media = promedio
    WHERE id = NEW.id_producto;
END

DELIMITER ;