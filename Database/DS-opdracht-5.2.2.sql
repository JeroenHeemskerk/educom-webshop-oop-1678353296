SELECT  city.name Stad, 
		count(if(memtype.name = 'Gold', 1, NULL)) gold, 
		count(if(memtype.name = 'Silver', 1, NULL)) silver, 
        count(if(memtype.name = 'Bronze', 1, NULL)) bronze, 
		count(if(memtype.name NOT IN ('Gold', 'Silver', 'Bronze'), 1, NULL)) others 
FROM mhl_suppliers sup
LEFT JOIN mhl_cities city
ON sup.city_ID = city.id
LEFT JOIN mhl_membertypes memtype ON 
	sup.membertype = memtype.id
GROUP BY Stad
ORDER BY gold DESC, silver DESC, bronze DESC, others DESC
