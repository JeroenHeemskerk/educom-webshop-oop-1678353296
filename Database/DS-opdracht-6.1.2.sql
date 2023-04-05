SELECT com.name gemeente, sup.name leverancier, 
	   SUM(hitcount) total_hitcount, 
       G.average average_hitcount
FROM mhl_suppliers sup
LEFT JOIN mhl_cities cit
ON cit.id = sup.city_ID
LEFT JOIN mhl_communes com
ON cit.commune_ID = com.id
LEFT JOIN mhl_hitcount hit
ON hit.supplier_ID = sup.id
JOIN (
SELECT com.id id, com.name gemeente, SUM(hitcount) total, AVG(hitcount) average
FROM mhl_suppliers s
LEFT JOIN mhl_hitcount h
ON h.supplier_ID=s.id
LEFT JOIN mhl_cities cit 
ON cit.id=s.city_ID
LEFT JOIN mhl_communes com
ON com.id=cit.commune_ID
GROUP BY gemeente
) G
ON G.id=com.id
GROUP BY gemeente, leverancier
ORDER BY com.name, (SUM(hitcount) - average_hitcount) DESC
