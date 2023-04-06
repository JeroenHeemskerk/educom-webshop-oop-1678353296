SELECT DAYNAME(CONCAT(joindate)) 'Dag van de week' FROM mhl_suppliers
JOIN mhl_hitcount
ORDER BY 'Dag van de week'
