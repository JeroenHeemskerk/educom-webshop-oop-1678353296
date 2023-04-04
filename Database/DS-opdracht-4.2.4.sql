-- not working
SELECT sup.name as naam, proptype.name as 'mhl_propertytypes.name', ifnull(ynprop.content, 'NOT SET') AS 'value'
FROM mhl_suppliers sup
LEFT JOIN mhl_cities city
ON city.id = sup.city_ID
LEFT JOIN mhl_properties properties
ON properties.supplier_ID = sup.id
LEFT JOIN mhl_yn_properties ynprop
ON ynprop.supplier_ID = sup.id
LEFT JOIN mhl_propertytypes proptype
ON proptype.id = ynprop.propertytype_ID
WHERE city.name = 'Amsterdam' AND proptype = 'A';

