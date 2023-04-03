SELECT sup.name as naam, straat, huisnr, postcode, city.name FROM mhl_suppliers sup
LEFT JOIN mhl_cities city
ON city.id = sup.city_ID
LEFT JOIN mhl_communes com
ON com.id = city.commune_ID
WHERE com.name = 'Steenwijkerland';

