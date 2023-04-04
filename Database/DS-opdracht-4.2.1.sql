SELECT city.name, commune_ID from mhl_cities city
LEFT JOIN mhl_communes commune
ON commune.id = city.commune_ID
WHERE commune.id IS NULL;
