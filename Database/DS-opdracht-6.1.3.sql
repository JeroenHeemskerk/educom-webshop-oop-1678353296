SELECT concat_ws(' - ', r1.name, r2.name) name, N.numsupp 
FROM mhl_rubrieken r1
RIGHT JOIN mhl_rubrieken r2
ON r2.parent=r1.id
JOIN (
SELECT r.id, COUNT(mhl_suppliers_ID) numsupp from mhl_rubrieken r
LEFT JOIN mhl_suppliers_mhl_rubriek_view rv
ON r.id = rv.mhl_rubriek_view_ID
GROUP BY r.id
) N
on N.id = r2.id
ORDER BY name