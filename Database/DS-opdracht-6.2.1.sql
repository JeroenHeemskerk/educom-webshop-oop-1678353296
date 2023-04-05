SELECT DATE_FORMAT(joindate, "%d.%m.%Y") joindate, id ID from mhl_suppliers sup
-- WHERE joindate <= DATE_ADD(CURRENT_DATE(), INTERVAL -7 DAY)
-- WHERE monthname(joindate) = 'February'
WHERE DAY(joindate) >= 23