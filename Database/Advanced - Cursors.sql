DROP PROCEDURE IF EXISTS `p_get_total_order_by_customer_name`;

DELIMITER $$
CREATE PROCEDURE `p_get_total_order_by_customer_name`(IN custName varchar(50))
BEGIN
    
    CREATE TABLE TemporaryTable (naam VARCHAR(255), totaal INT); 
    INSERT INTO TemporaryTable    
    SELECT c.customerName, COUNT(o.customerNumber) total     
    FROM orders o   
	JOIN customers c
	ON o.customerNumber = c.customerNumber
    WHERE customerName = custName;
    
    SELECT * from TemporaryTable;
    
    
END$$
DELIMITER ;