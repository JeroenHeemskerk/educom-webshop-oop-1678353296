SELECT DATE_FORMAT(joindate, "%d.%m.%Y") joindate, id ID from mhl_suppliers sup
WHERE DAY(joindate) >= 23