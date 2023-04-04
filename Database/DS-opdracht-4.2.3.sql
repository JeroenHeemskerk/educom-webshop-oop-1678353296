-- als rubriek.name null is betekent dat dat er geen parent is, en neem je dus de subrubriek.name als hoofdrubriek
SELECT subrubriek.id as 'ID', ifnull(rubriek.name, subrubriek.name) AS hoofdrubriek,
if(isnull(rubriek.name), '', subrubriek.name) AS subrubriek
FROM mhl_rubrieken rubriek
-- right outer neemt alle subrubriek categorieen, ook die geen parent hebben
RIGHT OUTER JOIN mhl_rubrieken subrubriek
ON subrubriek.parent = rubriek.id
ORDER by hoofdrubriek, subrubriek
