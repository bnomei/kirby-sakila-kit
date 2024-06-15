/*Inventory Replenishment:
Find the films that are currently out of stock and have been rented out more than twice in the past month.
Provide recommendations for restocking these films based on rental demand.*/

use sakila;

#(A) get out of stock films
SELECT 
    f.film_id
FROM
    film f
        LEFT JOIN
    inventory i ON f.film_id = i.film_id
WHERE
    i.inventory_id IS NULL
;

#(B) further get films rented > 2 times
SELECT 
    f.film_id
FROM
    film f
        JOIN
    inventory i ON f.film_id = i.film_id
        JOIN
    rental r ON r.inventory_id = i.inventory_id
WHERE
   r.rental_date >= DATE_SUB('2006-02-01', INTERVAL 1 MONTH)
    AND r.rental_date < '2006-02-01'
GROUP BY f.film_id
HAVING COUNT(r.rental_id) > 2
;

#(C) combine the queries to get our desired results
SELECT 
    f.film_id
FROM
    film f
        LEFT JOIN
    inventory i ON f.film_id = i.film_id
WHERE
    i.inventory_id IS NULL 
UNION ALL SELECT 
    f.film_id
FROM
    film f
        JOIN
    inventory i ON f.film_id = i.film_id
        JOIN
    rental r ON r.inventory_id = i.inventory_id
WHERE
    r.rental_date >= DATE_SUB('2006-02-01', INTERVAL 1 MONTH)
        AND r.rental_date < '2006-02-01'
GROUP BY f.film_id
HAVING COUNT(r.rental_id) > 2
;

#we have 42 films currently out of stock which have been ordered more than twice in the last 1 month.
/*RECOMMENDATIONS
1. Replenish the 42 films as soon as possible
2. Improve the inventory management system to avoid future stockouts
3. Analyse trends to explain the demand despite the stockouts
4. Communicate to customers on the stockouts and recommend similar films or offer pre-orders once replenished
5. Discount other similar films to encourage their renting
*/