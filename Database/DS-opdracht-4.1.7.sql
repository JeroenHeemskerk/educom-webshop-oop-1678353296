SELECT C1.name as 'C1.name', C2.name as 'C2.name', C1.id as 'C1.id', C2.id as 'C2.id',
C1.commune_ID as 'C1.commune_id', C2.commune_ID as 'C2.commune_id' 
FROM mhl_cities C1
JOIN mhl_cities C2
ON C2.NAME = C1.name AND C2.id = C1.id + 1
ORDER BY C1.name