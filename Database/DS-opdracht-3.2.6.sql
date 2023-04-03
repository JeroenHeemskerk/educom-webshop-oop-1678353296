SELECT name as naam, straat, huisnr, postcode FROM mhl_suppliers
WHERE huisnr BETWEEN 10 AND 20 OR huisnr > 100;