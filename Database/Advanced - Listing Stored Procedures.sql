-- SELECT  routine_name
-- FROM information_schema.routines
-- WHERE routine_type = 'PROCEDURE'
--   AND routine_schema = 'sales';

-- SHOW PROCEDURE STATUS WHERE Name like '%cust%';
SHOW  PROCEDURE STATUS WHERE year(Created) = 2023;
  
