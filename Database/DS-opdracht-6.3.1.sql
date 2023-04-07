SELECT name, 
CASE
 WHEN name like "'%" THEN concat(lcase(substring(name,1,2)), ucase(substring(name,3,2)), SUBSTRING(name,5))
 ELSE concat(ucase(substring(name,1,1)), substring(name,2)) 
END AS nice_name 
FROM mhl_cities
ORDER BY name