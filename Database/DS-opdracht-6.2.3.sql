SELECT DAYNAME(joindate) day, COUNT(name) 
FROM mhl_suppliers sup
GROUP BY DAYNAME(joindate)
ORDER BY dayofweek(joindate)
