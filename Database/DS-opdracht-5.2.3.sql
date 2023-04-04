SELECT	year Jaar,  
		SUM(if(month IN (1,2,3), hitcount, 0)) as 'Eerste kwartaal', 
		SUM(if(month IN (4,5,6), hitcount, 0)) as 'Tweede kwartaal',
		SUM(if(month IN (7,8,9), hitcount, 0)) as 'Derde kwartaal',
		SUM(if(month IN (10,11,12), hitcount, 0)) as 'Vierde kwartaal',
		SUM(hitcount) Totaal
FROM mhl_hitcount
GROUP BY Jaar