SELECT sup.name as naam, proptype.name as 'mhl_propertytypes.name', ifnull(ynprop.content, 'NOT SET') AS 'value'
FROM mhl_suppliers sup
LEFT JOIN mhl_cities city
ON city.id = sup.city_ID
CROSS JOIN mhl_propertytypes proptype
LEFT JOIN mhl_yn_properties ynprop
ON ynprop.supplier_ID = sup.id AND ynprop.propertytype_ID = proptype.id
WHERE city.name = 'Amsterdam' AND proptype.proptype = 'A';

