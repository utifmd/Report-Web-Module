CREATE PROCEDURE filldates(dateStart DATE, dateEnd DATE)
BEGIN
DECLARE adate date;
    WHILE dateStart <= dateEnd DO
        SET adate = (SELECT mydate FROM MyDates WHERE mydate = dateStart);
        IF adate IS NULL THEN BEGIN
            INSERT INTO MyDates (mydate) VALUES (dateStart);
        END; END IF;
        SET dateStart = date_add(dateStart, INTERVAL 1 DAY);
    END WHILE;
END;

-- WORKS
/*
SELECT
reg_periksa.tgl_registrasi,
COUNT(poliklinik.nm_poli) AS reg_poli_count
FROM poliklinik 
INNER JOIN reg_periksa ON reg_periksa.kd_poli = poliklinik.kd_poli

WHERE EXTRACT(YEAR FROM reg_periksa.tgl_registrasi) = '2020'
AND EXTRACT(MONTH FROM reg_periksa.tgl_registrasi) = '11'

GROUP BY reg_periksa.tgl_registrasi
*/

/*
SELECT 
poliklinik.nm_poli,

(
SELECT
  COUNT(reg_periksa.kd_poli) AS poli_counts
FROM reg_periksa

WHERE 
	EXTRACT(YEAR FROM reg_periksa.tgl_registrasi) = '2021' AND 
    EXTRACT(MONTH FROM reg_periksa.tgl_registrasi) = '07' AND
    EXTRACT(DAY FROM reg_periksa.tgl_registrasi) = '28' AND
    reg_periksa.kd_poli = 'U0003'
    
GROUP BY EXTRACT(DAY FROM reg_periksa.tgl_registrasi)
) AS total_in_day,

COUNT(poliklinik.nm_poli) as total_complete
FROM poliklinik
INNER JOIN reg_periksa ON reg_periksa.kd_poli = poliklinik.kd_poli
GROUP BY poliklinik.nm_poli
*/

/*
SELECT
  EXTRACT(DAY FROM reg_periksa.tgl_registrasi) AS day,
  COUNT(reg_periksa.kd_poli) AS poli_counts
FROM reg_periksa
WHERE 
	EXTRACT(YEAR FROM reg_periksa.tgl_registrasi) = '2021' AND 
    EXTRACT(MONTH FROM reg_periksa.tgl_registrasi) = '5'
GROUP BY EXTRACT(DAY FROM reg_periksa.tgl_registrasi);
*/
/*
SELECT
  EXTRACT(MONTH FROM reg_periksa.tgl_registrasi) AS month,
  COUNT(reg_periksa.kd_poli) AS poli_counts
FROM reg_periksa
WHERE EXTRACT(YEAR FROM reg_periksa.tgl_registrasi) = '2021'
GROUP BY EXTRACT(MONTH FROM reg_periksa.tgl_registrasi);
*/
-- WORKS

/*
SELECT
	poliklinik.nm_poli,
    (
        -- SELECT
        -- EXTRACT(year FROM transaction_date) AS year,
        -- SUM(money) AS money_earned
        -- FROM data
        -- GROUP BY EXTRACT(year FROM transaction_date)
        
        SELECT
        poliklinik.nm_poli
        FROM reg_periksa
        INNER JOIN poliklinik ON reg_periksa.kd_poli = poliklinik.kd_poli
        WHERE EXTRACT(year FROM tgl_registrasi) = '2020'
        GROUP BY poliklinik.nm_poli
    ) AS night,
    
    COUNT(poliklinik.nm_poli) AS total
FROM reg_periksa
INNER JOIN poliklinik ON reg_periksa.kd_poli=poliklinik.kd_poli
GROUP BY poliklinik.nm_poli
*/

/*SELECT
	reg_periksa.*,
    poliklinik.*
FROM reg_periksa
INNER JOIN poliklinik ON reg_periksa.kd_poli=poliklinik.kd_poli

*/

/*
SELECT
  EXTRACT(year FROM transaction_date) AS year,
  SUM(money) AS money_earned
FROM data
GROUP BY EXTRACT(year FROM transaction_date);

SELECT
  transaction_date AS transaction_date,
  EXTRACT(year FROM transaction_date) AS year,
  SUM(money) OVER(PARTITION BY EXTRACT(year FROM transaction_date)) AS money_earned
FROM data;

SELECT
  year,
  SUM(money) AS money_earned
FROM data
GROUP BY year;
*/

/*
select 
poliklinik.nm_poli,
count(poliklinik.nm_poli) as jumlah
from reg_periksa 
inner join poliklinik on reg_periksa.kd_poli=poliklinik.kd_poli
where tgl_registrasi between '"+Valid.SetTgl(Tanggal1.getSelectedItem()+"")+"' and '"+Valid.SetTgl(Tanggal2.getSelectedItem()+"")+"' group by poliklinik.nm_poli
*/

/*
SELECT 
COUNT(reg_periksa.kd_poli) AS jumlah,
reg_periksa.kd_poli AS poli FROM reg_periksa
WHERE tgl_registrasi LIKE "%2020%" GROUP BY reg_periksa.kd_poli
*/

/*
SELECT 
COUNT(reg_periksa.kd_poli) AS jumlah,
reg_periksa.kd_poli AS poli FROM reg_periksa
WHERE tgl_registrasi LIKE "%2020%" GROUP BY reg_periksa.kd_poli
*/


/*
* Date Column With Value
* */
/*
SELECT
reg_periksa.tgl_registrasi,
COUNT(poliklinik.nm_poli) AS reg_poli_count
FROM poliklinik 
INNER JOIN reg_periksa ON reg_periksa.kd_poli = poliklinik.kd_poli

WHERE EXTRACT(YEAR FROM reg_periksa.tgl_registrasi) = '2020'
AND EXTRACT(MONTH FROM reg_periksa.tgl_registrasi) = '10'

GROUP BY reg_periksa.tgl_registrasi
*/

-- SELECT
-- 	'Poli Obgyn' AS nm_poli,
-- 	MAX(CASE WHEN day = '1' THEN poli_counts END) day_1,
-- 	MAX(CASE WHEN day = '2' THEN poli_counts END) day_2,
-- 	MAX(CASE WHEN day = '3' THEN poli_counts END) day_3,
-- 	MAX(CASE WHEN day = '4' THEN poli_counts END) day_4,
--     MAX(CASE WHEN day = '5' THEN poli_counts END) day_5,
--     MAX(CASE WHEN day = '6' THEN poli_counts END) day_6,
--     MAX(CASE WHEN day = '7' THEN poli_counts END) day_7,
--     MAX(CASE WHEN day = '8' THEN poli_counts END) day_8,
--     MAX(CASE WHEN day = '9' THEN poli_counts END) day_9,
--     MAX(CASE WHEN day = '10' THEN poli_counts END) day_10,
--     MAX(CASE WHEN day = '11' THEN poli_counts END) day_11,
--     MAX(CASE WHEN day = '12' THEN poli_counts END) day_12,
--     MAX(CASE WHEN day = '13' THEN poli_counts END) day_13,
--     MAX(CASE WHEN day = '14' THEN poli_counts END) day_14,
--     MAX(CASE WHEN day = '15' THEN poli_counts END) day_15,
-- 	MAX(CASE WHEN day = '16' THEN poli_counts END) day_16,
-- 	MAX(CASE WHEN day = '17' THEN poli_counts END) day_17,
-- 	MAX(CASE WHEN day = '18' THEN poli_counts END) day_18,
-- 	MAX(CASE WHEN day = '19' THEN poli_counts END) day_19,
--     MAX(CASE WHEN day = '20' THEN poli_counts END) day_20,
--     MAX(CASE WHEN day = '21' THEN poli_counts END) day_21,
--     MAX(CASE WHEN day = '22' THEN poli_counts END) day_22,
--     MAX(CASE WHEN day = '23' THEN poli_counts END) day_23,
--     MAX(CASE WHEN day = '24' THEN poli_counts END) day_24,
--     MAX(CASE WHEN day = '25' THEN poli_counts END) day_25,
--     MAX(CASE WHEN day = '26' THEN poli_counts END) day_26,
--     MAX(CASE WHEN day = '27' THEN poli_counts END) day_27,
--     MAX(CASE WHEN day = '28' THEN poli_counts END) day_28,
--     MAX(CASE WHEN day = '29' THEN poli_counts END) day_29,
--     MAX(CASE WHEN day = '30' THEN poli_counts END) day_30,
--     MAX(CASE WHEN day = '31' THEN poli_counts END) day_31

-- FROM tb_aggregate;

SELECT 
	poliklinik.nm_poli AS nama_poli,
	MAX(CASE WHEN day = '1' THEN poli_counts END) day_1,
	MAX(CASE WHEN day = '2' THEN poli_counts END) day_2,
	MAX(CASE WHEN day = '3' THEN poli_counts END) day_3,
	MAX(CASE WHEN day = '4' THEN poli_counts END) day_4,
    MAX(CASE WHEN day = '5' THEN poli_counts END) day_5,
    MAX(CASE WHEN day = '6' THEN poli_counts END) day_6,
    MAX(CASE WHEN day = '7' THEN poli_counts END) day_7,
    MAX(CASE WHEN day = '8' THEN poli_counts END) day_8,
    MAX(CASE WHEN day = '9' THEN poli_counts END) day_9,
    MAX(CASE WHEN day = '10' THEN poli_counts END) day_10,
    MAX(CASE WHEN day = '11' THEN poli_counts END) day_11,
    MAX(CASE WHEN day = '12' THEN poli_counts END) day_12,
    MAX(CASE WHEN day = '13' THEN poli_counts END) day_13,
    MAX(CASE WHEN day = '14' THEN poli_counts END) day_14,
    MAX(CASE WHEN day = '15' THEN poli_counts END) day_15,
	MAX(CASE WHEN day = '16' THEN poli_counts END) day_16,
	MAX(CASE WHEN day = '17' THEN poli_counts END) day_17,
	MAX(CASE WHEN day = '18' THEN poli_counts END) day_18,
	MAX(CASE WHEN day = '19' THEN poli_counts END) day_19,
    MAX(CASE WHEN day = '20' THEN poli_counts END) day_20,
    MAX(CASE WHEN day = '21' THEN poli_counts END) day_21,
    MAX(CASE WHEN day = '22' THEN poli_counts END) day_22,
    MAX(CASE WHEN day = '23' THEN poli_counts END) day_23,
    MAX(CASE WHEN day = '24' THEN poli_counts END) day_24,
    MAX(CASE WHEN day = '25' THEN poli_counts END) day_25,
    MAX(CASE WHEN day = '26' THEN poli_counts END) day_26,
    MAX(CASE WHEN day = '27' THEN poli_counts END) day_27,
    MAX(CASE WHEN day = '28' THEN poli_counts END) day_28,
    MAX(CASE WHEN day = '29' THEN poli_counts END) day_29,
    MAX(CASE WHEN day = '30' THEN poli_counts END) day_30,
    MAX(CASE WHEN day = '31' THEN poli_counts END) day_31
FROM poliklinik
INNER JOIN reg_periksa ON reg_periksa.kd_poli = poliklinik.kd_poli

/*
* Date Column With Value
* */
/*
SELECT
reg_periksa.tgl_registrasi,
COUNT(poliklinik.nm_poli) AS reg_poli_count
FROM poliklinik 
INNER JOIN reg_periksa ON reg_periksa.kd_poli = poliklinik.kd_poli

WHERE EXTRACT(YEAR FROM reg_periksa.tgl_registrasi) = '2020'
AND EXTRACT(MONTH FROM reg_periksa.tgl_registrasi) = '10'

GROUP BY reg_periksa.tgl_registrasi
*/

SELECT 
	poliklinik.nm_poli AS nm_poli,
	MAX(CASE WHEN EXTRACT(DAY FROM reg_periksa.tgl_registrasi) = '1' 
        AND EXTRACT(MONTH FROM reg_periksa.tgl_registrasi) = '10'
        AND EXTRACT(YEAR FROM reg_periksa.tgl_registrasi) = '2021'
            THEN 
                
            END) day_1,
	MAX(CASE WHEN EXTRACT(DAY FROM reg_periksa.tgl_registrasi) = '2' 
        AND EXTRACT(MONTH FROM reg_periksa.tgl_registrasi) = '10'
        AND EXTRACT(YEAR FROM reg_periksa.tgl_registrasi) = '2021'
            THEN 
                
            END) day_2,
	MAX(CASE WHEN EXTRACT(DAY FROM reg_periksa.tgl_registrasi) = '3' 
        AND EXTRACT(MONTH FROM reg_periksa.tgl_registrasi) = '10'
        AND EXTRACT(YEAR FROM reg_periksa.tgl_registrasi) = '2021'
            THEN 
                
            END) day_3,
	MAX(CASE WHEN EXTRACT(DAY FROM reg_periksa.tgl_registrasi) = '4' 
        AND EXTRACT(MONTH FROM reg_periksa.tgl_registrasi) = '10'
        AND EXTRACT(YEAR FROM reg_periksa.tgl_registrasi) = '2021'
            THEN 
                
            END) day_4,
    MAX(CASE WHEN EXTRACT(DAY FROM reg_periksa.tgl_registrasi) = '5' 
        AND EXTRACT(MONTH FROM reg_periksa.tgl_registrasi) = '10'
        AND EXTRACT(YEAR FROM reg_periksa.tgl_registrasi) = '2021'
            THEN 
                
            END) day_5,
    MAX(CASE WHEN EXTRACT(DAY FROM reg_periksa.tgl_registrasi) = '6' 
        AND EXTRACT(MONTH FROM reg_periksa.tgl_registrasi) = '10'
        AND EXTRACT(YEAR FROM reg_periksa.tgl_registrasi) = '2021'
            THEN 
                
            END) day_6,
    MAX(CASE WHEN EXTRACT(DAY FROM reg_periksa.tgl_registrasi) = '7' 
        AND EXTRACT(MONTH FROM reg_periksa.tgl_registrasi) = '10'
        AND EXTRACT(YEAR FROM reg_periksa.tgl_registrasi) = '2021'
            THEN 
                
            END) day_7,
    MAX(CASE WHEN EXTRACT(DAY FROM reg_periksa.tgl_registrasi) = '8' 
        AND EXTRACT(MONTH FROM reg_periksa.tgl_registrasi) = '10'
        AND EXTRACT(YEAR FROM reg_periksa.tgl_registrasi) = '2021'
            THEN 
                
            END) day_8,
    MAX(CASE WHEN EXTRACT(DAY FROM reg_periksa.tgl_registrasi) = '9' 
        AND EXTRACT(MONTH FROM reg_periksa.tgl_registrasi) = '10'
        AND EXTRACT(YEAR FROM reg_periksa.tgl_registrasi) = '2021'
            THEN 
                
            END) day_9,
    MAX(CASE WHEN EXTRACT(DAY FROM reg_periksa.tgl_registrasi) = '10' 
        AND EXTRACT(MONTH FROM reg_periksa.tgl_registrasi) = '10'
        AND EXTRACT(YEAR FROM reg_periksa.tgl_registrasi) = '2021'
            THEN 
                
            END) day_10,
    MAX(CASE WHEN EXTRACT(DAY FROM reg_periksa.tgl_registrasi) = '11' 
        AND EXTRACT(MONTH FROM reg_periksa.tgl_registrasi) = '10'
        AND EXTRACT(YEAR FROM reg_periksa.tgl_registrasi) = '2021'
            THEN 
                
            END) day_11,
    MAX(CASE WHEN EXTRACT(DAY FROM reg_periksa.tgl_registrasi) = '12' 
        AND EXTRACT(MONTH FROM reg_periksa.tgl_registrasi) = '10'
        AND EXTRACT(YEAR FROM reg_periksa.tgl_registrasi) = '2021'
            THEN 
                
            END) day_12,
    MAX(CASE WHEN EXTRACT(DAY FROM reg_periksa.tgl_registrasi) = '13' 
        AND EXTRACT(MONTH FROM reg_periksa.tgl_registrasi) = '10'
        AND EXTRACT(YEAR FROM reg_periksa.tgl_registrasi) = '2021'
            THEN 
                
            END) day_13,
    MAX(CASE WHEN EXTRACT(DAY FROM reg_periksa.tgl_registrasi) = '14' 
        AND EXTRACT(MONTH FROM reg_periksa.tgl_registrasi) = '10'
        AND EXTRACT(YEAR FROM reg_periksa.tgl_registrasi) = '2021'
            THEN 
                
            END) day_14,
    MAX(CASE WHEN EXTRACT(DAY FROM reg_periksa.tgl_registrasi) = '15' 
        AND EXTRACT(MONTH FROM reg_periksa.tgl_registrasi) = '10'
        AND EXTRACT(YEAR FROM reg_periksa.tgl_registrasi) = '2021'
            THEN 
                
            END) day_15,
	MAX(CASE WHEN EXTRACT(DAY FROM reg_periksa.tgl_registrasi) = '16' 
        AND EXTRACT(MONTH FROM reg_periksa.tgl_registrasi) = '10'
        AND EXTRACT(YEAR FROM reg_periksa.tgl_registrasi) = '2021'
            THEN 
                
            END) day_16,
	MAX(CASE WHEN EXTRACT(DAY FROM reg_periksa.tgl_registrasi) = '17' 
        AND EXTRACT(MONTH FROM reg_periksa.tgl_registrasi) = '10'
        AND EXTRACT(YEAR FROM reg_periksa.tgl_registrasi) = '2021'
            THEN 
                
            END) day_17,
	MAX(CASE WHEN EXTRACT(DAY FROM reg_periksa.tgl_registrasi) = '18' 
        AND EXTRACT(MONTH FROM reg_periksa.tgl_registrasi) = '10'
        AND EXTRACT(YEAR FROM reg_periksa.tgl_registrasi) = '2021'
            THEN 
                
            END) day_18,
	MAX(CASE WHEN EXTRACT(DAY FROM reg_periksa.tgl_registrasi) = '19' 
        AND EXTRACT(MONTH FROM reg_periksa.tgl_registrasi) = '10'
        AND EXTRACT(YEAR FROM reg_periksa.tgl_registrasi) = '2021'
            THEN 
                
            END) day_19,
    MAX(CASE WHEN EXTRACT(DAY FROM reg_periksa.tgl_registrasi) = '20' 
        AND EXTRACT(MONTH FROM reg_periksa.tgl_registrasi) = '10'
        AND EXTRACT(YEAR FROM reg_periksa.tgl_registrasi) = '2021'
            THEN 
                
            END) day_20,
    MAX(CASE WHEN EXTRACT(DAY FROM reg_periksa.tgl_registrasi) = '21' 
        AND EXTRACT(MONTH FROM reg_periksa.tgl_registrasi) = '10'
        AND EXTRACT(YEAR FROM reg_periksa.tgl_registrasi) = '2021'
            THEN 
                
            END) day_21,
    MAX(CASE WHEN EXTRACT(DAY FROM reg_periksa.tgl_registrasi) = '22' 
        AND EXTRACT(MONTH FROM reg_periksa.tgl_registrasi) = '10'
        AND EXTRACT(YEAR FROM reg_periksa.tgl_registrasi) = '2021'
            THEN 
                
            END) day_22,
    MAX(CASE WHEN EXTRACT(DAY FROM reg_periksa.tgl_registrasi) = '23' 
        AND EXTRACT(MONTH FROM reg_periksa.tgl_registrasi) = '10'
        AND EXTRACT(YEAR FROM reg_periksa.tgl_registrasi) = '2021'
            THEN 
                
            END) day_23,
    MAX(CASE WHEN EXTRACT(DAY FROM reg_periksa.tgl_registrasi) = '24' 
        AND EXTRACT(MONTH FROM reg_periksa.tgl_registrasi) = '10'
        AND EXTRACT(YEAR FROM reg_periksa.tgl_registrasi) = '2021'
            THEN 
                
            END) day_24,
    MAX(CASE WHEN EXTRACT(DAY FROM reg_periksa.tgl_registrasi) = '25' 
        AND EXTRACT(MONTH FROM reg_periksa.tgl_registrasi) = '10'
        AND EXTRACT(YEAR FROM reg_periksa.tgl_registrasi) = '2021'
            THEN 
                
            END) day_25,
    MAX(CASE WHEN EXTRACT(DAY FROM reg_periksa.tgl_registrasi) = '26' 
        AND EXTRACT(MONTH FROM reg_periksa.tgl_registrasi) = '10'
        AND EXTRACT(YEAR FROM reg_periksa.tgl_registrasi) = '2021'
            THEN 
                
            END) day_26,
    MAX(CASE WHEN EXTRACT(DAY FROM reg_periksa.tgl_registrasi) = '27' 
        AND EXTRACT(MONTH FROM reg_periksa.tgl_registrasi) = '10'
        AND EXTRACT(YEAR FROM reg_periksa.tgl_registrasi) = '2021'
            THEN 
                
            END) day_27,
    MAX(CASE WHEN EXTRACT(DAY FROM reg_periksa.tgl_registrasi) = '28' 
        AND EXTRACT(MONTH FROM reg_periksa.tgl_registrasi) = '10'
        AND EXTRACT(YEAR FROM reg_periksa.tgl_registrasi) = '2021'
            THEN 
                
            END) day_28,
    MAX(CASE WHEN EXTRACT(DAY FROM reg_periksa.tgl_registrasi) = '29' 
        AND EXTRACT(MONTH FROM reg_periksa.tgl_registrasi) = '10'
        AND EXTRACT(YEAR FROM reg_periksa.tgl_registrasi) = '2021'
            THEN 
                
            END) day_29,
    MAX(CASE WHEN EXTRACT(DAY FROM reg_periksa.tgl_registrasi) = '30' 
        AND EXTRACT(MONTH FROM reg_periksa.tgl_registrasi) = '10'
        AND EXTRACT(YEAR FROM reg_periksa.tgl_registrasi) = '2021'
            THEN 
                
            END) day_30,
    MAX(CASE WHEN EXTRACT(DAY FROM reg_periksa.tgl_registrasi) = '31' 
        AND EXTRACT(MONTH FROM reg_periksa.tgl_registrasi) = '10'
        AND EXTRACT(YEAR FROM reg_periksa.tgl_registrasi) = '2021'
            THEN 
                
            END) day_31
FROM poliklinik
INNER JOIN reg_periksa ON reg_periksa.kd_poli = poliklinik.kd_poli
GROUP BY poliklinik.nm_poli
