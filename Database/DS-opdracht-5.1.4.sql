SELECT sup.name, SUM(hc.hitcount), COUNT(hc.month), ROUND(AVG(hc.hitcount), 0) avgpermonth
FROM mhl_hitcount hc
LEFT JOIN mhl_suppliers sup
ON sup.id = hc.supplier_ID
GROUP BY sup.name
ORDER BY avgpermonth DESC