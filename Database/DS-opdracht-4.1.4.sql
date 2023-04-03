SELECT S.name as 'S.naam', straat, huisnr, postcode FROM mhl_suppliers S
LEFT JOIN mhl_yn_properties prop
ON prop.supplier_ID = S.id
LEFT JOIN mhl_propertytypes proptype
ON proptype.id = prop.propertytype_ID
WHERE proptype.name in ('specialistische leverancier', 'ook voor particulieren');