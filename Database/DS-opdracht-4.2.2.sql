SELECT city.name as 'name', ifnull(commune.name, "INVALID") from mhl_cities city
LEFT JOIN mhl_communes commune
ON commune.id = city.commune_ID