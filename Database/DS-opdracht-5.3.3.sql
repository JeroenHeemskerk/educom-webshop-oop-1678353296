SELECT sup.name, 
	   if(isnull(contact), 'tav de directie', contact) contact, 
       adres, verzend.postcode, verzend.stad 
FROM mhl_suppliers sup
LEFT JOIN v_directie dir
ON dir.ID = sup.id
JOIN v_verzendlijst verzend
ON verzend.id = sup.id