SELECT sup.name as naam, straat, huisnr, postcode FROM mhl_suppliers sup
LEFT JOIN mhl_cities city
ON city.id = sup.city_ID
LEFT JOIN mhl_cities city2
ON city2.id = sup.p_city_ID
WHERE city.name = 'Amsterdam' AND NOT city2.name = 'Amsterdam';
