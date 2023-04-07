DROP PROCEDURE IF EXISTS `p_get_total_order_by_customer_name`;

DELIMITER $$
CREATE PROCEDURE `p_get_total_order_by_customer_name`()
BEGIN
	DECLARE finished INTEGER DEFAULT 0;
	DECLARE naam VARCHAR(50);
    DECLARE totaal INT;
    
    DECLARE cur_customer CURSOR FOR
    SELECT c.customerName, COUNT(o.customerNumber) total     
    FROM orders o   
	JOIN customers c
	ON o.customerNumber = c.customerNumber
    GROUP BY c.customerName;
    
	DECLARE CONTINUE HANDLER 
        FOR NOT FOUND SET finished = 1;
        
    OPEN cur_customer;
    
    getNameAndTotal: LOOP
        FETCH cur_customer INTO naam, totaal;
        INSERT INTO customer_reporting(`naam`, `totaal`) VALUES (naam, totaal);
        IF finished = 1 THEN 
            LEAVE getNameAndTotal;
        END IF;       
    END LOOP getNameAndTotal;
   
    CLOSE cur_customer;
    
    
    
    
END$$
DELIMITER ;