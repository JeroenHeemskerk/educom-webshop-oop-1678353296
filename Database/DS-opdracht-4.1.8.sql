SELECT C1.name as 'name', C1.id as 'cid1', C2.id as 'cid2',
C1.commune_ID as 'gid1', C2.commune_ID as 'gid2',
commune1.name as 'gemeente_1', commune2.name as 'gemeente_2'
FROM mhl_cities C1
  INNER JOIN (
    SELECT MIN(id) AS id FROM mhl_cities GROUP BY name
  ) maxid ON C1.id = maxid.id
JOIN mhl_cities C2
ON C2.NAME = C1.name 
JOIN mhl_communes commune1
ON commune1.id = C1.commune_ID
JOIN mhl_communes commune2
ON commune2.id = C2.commune_ID
WHERE C1.id <> C2.id AND NOT C2.commune_ID = 0
ORDER BY C1.name