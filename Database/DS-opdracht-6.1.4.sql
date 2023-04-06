SELECT concat_ws(' - ', r1.name, r2.name) name, H.hit
FROM mhl_rubrieken r2
LEFT JOIN mhl_rubrieken r1
ON r1.id=r2.parent
LEFT JOIN (
SELECT r.id, r.name, IFNULL(SUM(hitcount), 'Geen hits') hit
FROM mhl_suppliers_mhl_rubriek_view rv
LEFT JOIN mhl_hitcount hc
ON hc.supplier_ID = rv.mhl_suppliers_ID
RIGHT JOIN mhl_rubrieken r
ON r.id = rv.mhl_rubriek_view_ID
GROUP BY r.id
) H
ON H.id = r2.id
ORDER BY name
