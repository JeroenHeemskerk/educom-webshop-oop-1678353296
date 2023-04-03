SELECT rubriek.name as 'R.naam', S.name as 'S.naam', straat, huisnr, postcode, rubriek.name as 'R.naam' FROM mhl_suppliers S
LEFT JOIN mhl_cities city
ON city.id = S.city_ID
LEFT JOIN mhl_suppliers_mhl_rubriek_view rubriekview
ON rubriekview.mhl_suppliers_ID = S.id
LEFT JOIN mhl_rubrieken rubriek
ON rubriek.id = rubriekview.mhl_rubriek_view_ID
LEFT JOIN mhl_rubrieken rubriek2
ON rubriek2.id = rubriek.parent
WHERE city.name = 'Amsterdam' AND (rubriek.name = 'drank' OR rubriek2.name = 'drank')
ORDER by rubriek.name, S.name;