

/* 1. Calculate the average number of days between consecutive rentals for each customer who has rented at least five films.
Identify customers who have shown consistent rental activity and those who have irregular rental patterns.*/

use sakila;

#(A) get customers with > 5 rentals
SELECT 
    customer_id
FROM
    rental
GROUP BY customer_id
HAVING COUNT(rental_id) > 5
;

#(B) we'll calculate the number of days between consecutive rentals for each customer.
SELECT 
    customer_id,
    round(abs(DATEDIFF(MIN(return_date), MAX(rental_date)) / NULLIF(COUNT(*) - 1, 0)),1) AS avg_number_of_days_btwn_rentals
FROM
    rental
WHERE
    customer_id IN (SELECT 
            customer_id
        FROM
            rental
        GROUP BY customer_id
        HAVING COUNT(rental_id) > 5)
GROUP BY customer_id ;

#(C) Identify customers who have shown consistent rental activity and those who have irregular rental patterns
SELECT customer_id, 
case
when  avg_number_of_days_btwn_rentals <=7 then 'Regular'
when  avg_number_of_days_btwn_rentals <=14 then 'Moderate'
else 'Irregular'
end as rental_behavior
from
(
SELECT 
    customer_id,
    abs(DATEDIFF(MIN(return_date), MAX(rental_date)) / NULLIF(COUNT(*) - 1, 0)) AS avg_number_of_days_btwn_rentals
FROM
    rental
WHERE
    customer_id IN (SELECT 
            customer_id
        FROM
            rental
        GROUP BY customer_id
        HAVING COUNT(rental_id) > 5)
GROUP BY customer_id)
as avg_rental_duration_days ;
