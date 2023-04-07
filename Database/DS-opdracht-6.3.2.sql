SELECT name,
HTML_UnEncode(name) nice_name
FROM mhl_suppliers
WHERE name LIKE '%&%;%'
ORDER BY name
LIMIT 25