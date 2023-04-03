-- 3.2.1 Selecteer naam, straat, huisnummer en postcode van alle leveranciers uit 'Amsterdam'.
SELECT name as naam, straat, huisnr, postcode FROM mhl_suppliers 
WHERE city_id = (select id from mhl_cities where name = 'Amsterdam');