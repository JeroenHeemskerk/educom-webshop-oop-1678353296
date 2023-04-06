SELECT id ID, joindate, DATEDIFF(curdate(), joindate) dagen_lid
FROM mhl_suppliers
ORDER BY dagen_lid ASC