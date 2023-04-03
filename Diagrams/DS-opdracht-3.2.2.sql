UPDATE mhl_membertypes
SET name = 'GEEN INTERESSE' WHERE id = 8;

SELECT sup.name, straat, huisnr, postcode, mem.name as membertype FROM mhl_suppliers sup
LEFT JOIN mhl_membertypes mem
ON mem.id=sup.membertype
WHERE mem.name in ('Gold', 'Silver', 'Bronze', 'GEEN INTERESSE');

