CREATE VIEW mhl.v_DIRECTIE
AS
SELECT supplier_ID ID, contact.name contact, contact.contacttype functie, Dep.name department
FROM mhl_contacts contact
LEFT JOIN mhl_departments Dep 
ON Dep.id = contact.department
WHERE department = 'Directie' OR 
	  contact.contacttype LIKE '%directeur%'
