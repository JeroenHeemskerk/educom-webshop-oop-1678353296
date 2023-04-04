SELECT sup.name leverancier, ifnull(contact.name, 't.a.v. de directie') aanhef,
IF(sup.p_address<>"",sup.p_address, concat(sup.straat, " ", sup.huisnr)) adres, 
IF(sup.p_address<>"", sup.p_postcode, sup.postcode) postcode, 
IF(sup.p_address<>"", city2.name, city.name) stad,
IF(sup.p_address<>"", district2.name, district.name) provincie
FROM mhl_suppliers sup
LEFT JOIN mhl_contacts contact 
ON contact.supplier_ID = sup.id 
LEFT JOIN mhl_cities city
ON city.id = sup.city_ID
LEFT JOIN mhl_communes commune
ON commune.id = city.commune_ID
LEFT JOIN mhl_districts district
ON district.id = commune.district_ID
LEFT JOIN mhl_cities city2 
ON sup.p_city_ID=city2.id
LEFT JOIN mhl_communes commune2 
ON city2.commune_ID=commune2.id
LEFT JOIN mhl_districts district2 
ON commune2.district_ID=district2.id
WHERE postcode <> ""
ORDER BY provincie, stad, leverancier