SELECT year(joindate) jaar, MONTHNAME(joindate) maand, COUNT(name) 
FROM mhl_suppliers sup
GROUP BY year(joindate), month(joindate)
