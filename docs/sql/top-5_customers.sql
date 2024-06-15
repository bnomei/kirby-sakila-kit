SELECT customer.first_name, customer.last_name, COUNT(rental.rental_id) AS rental_count
FROM customer
         INNER JOIN rental ON customer.customer_id = rental.customer_id
GROUP BY customer.customer_id
ORDER BY rental_count DESC
LIMIT 5;
