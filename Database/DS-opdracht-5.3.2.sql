CREATE VIEW v_verzendlijst
AS
SELECT sup.id, 
	   if(p_address="", concat(straat, " ", huisnr), p_address) adres,
       if(p_postcode="", postcode, p_postcode) postcode,
       city.name stad
FROM mhl_suppliers sup
LEFT JOIN mhl_cities city
ON IF(p_address="", city_ID, p_city_ID)=city.id