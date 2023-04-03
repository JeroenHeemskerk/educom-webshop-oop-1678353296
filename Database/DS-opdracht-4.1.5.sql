SELECT S.name as 'S.naam', straat, huisnr, postcode, pc.lat, pc.lng FROM mhl_suppliers S
LEFT JOIN pc_lat_long pc
ON pc.pc6 = S.postcode
ORDER BY pc.lat DESC, pc.lng DESC
LIMIT 5;
