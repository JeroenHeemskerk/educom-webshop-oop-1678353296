-- Requirement 'beneden de grote rivieren' was onduidelijk, 
-- ik heb Zeeland, Noord-Brabant en Limburg aangehouden

SELECT hc.hitcount, S.name as 'leverancier', city.name as 'stad', commune.name as 'gemeente', district.name as 'provincie' FROM mhl_suppliers S
JOIN mhl_hitcount hc
ON hc.supplier_ID = S.id
JOIN mhl_cities city
ON city.id = S.city_ID
JOIN mhl_communes commune
ON commune.id = city.commune_ID
JOIN mhl_districts district
ON district.id = commune.district_ID
WHERE district.name IN ('Zeeland', 'Noord-Brabant', 'Limburg') AND
(hc.year = 2014 AND hc.month = 1)

