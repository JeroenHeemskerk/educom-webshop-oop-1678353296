SELECT if(isnull(r1.name), r2.name, concat_ws(' - ', r1.name, r2.name)) name, N.numsupp, N.hc
FROM mhl_rubrieken r1
RIGHT JOIN mhl_rubrieken r2
ON r2.parent=r1.id
RIGHT JOIN (
SELECT r.id, IFNULL(COUNT(s.id), 0) numsupp, SUM(hitcount) hc from mhl_rubrieken r
JOIN mhl_suppliers_mhl_rubriek_view rv
ON r.id = rv.mhl_rubriek_view_ID
JOIN mhl_suppliers s
ON rv.mhl_suppliers_ID = s.id
JOIN mhl_hitcount h
ON s.id = h.supplier_ID
GROUP BY r.id
) N
on N.id = r2.id
ORDER BY name
