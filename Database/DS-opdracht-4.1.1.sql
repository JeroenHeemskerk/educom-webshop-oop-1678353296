-- SELECT name as naam, straat, huisnr, postcode FROM mhl_suppliers 
-- WHERE city_id = (select id from mhl_cities where name = 'Amsterdam');

-- OOK MOGELIJK:
SELECT sup.name as naam, straat, huisnr, postcode FROM mhl_suppliers sup
LEFT JOIN mhl_cities city
ON city.id = sup.city_ID
WHERE city.name =  'Amsterdam';
