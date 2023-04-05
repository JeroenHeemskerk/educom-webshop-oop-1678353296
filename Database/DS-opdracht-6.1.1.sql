SET lc_time_names = 'nl_NL';
SELECT year jaar, 
	   MONTHNAME(CONCAT('2023-',month,'-01')) maand,
	   COUNT(supplier_ID) AS 'aantal leveranciers', 
       MIN(hitcount) AS 'minimaal aantal hits',
       MAX(hitcount) AS 'maximaal aantal hits',
       AVG(hitcount) AS 'gemiddeld aantal hits',
	   SUM(hitcount) AS 'totaal aantal hits'       
FROM mhl_hitcount 
GROUP by jaar, maand
ORDER BY year DESC;

SET lc_time_names = 'en_US';