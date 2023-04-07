DELIMITER $$

CREATE PROCEDURE p_get_total_order_by_customer(IN custNum int)
BEGIN
    
    DECLARE totalOrder INT DEFAULT 0;
    
    SELECT COUNT(*)
    INTO totalOrder
    FROM orders
    WHERE customerNumber = custNum;
    
    SELECT totalOrder;
END$$

DELIMITER ;