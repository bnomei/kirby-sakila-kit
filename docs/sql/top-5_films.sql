SELECT film.title, COUNT(rental.rental_id) AS rental_count
FROM film
         INNER JOIN inventory ON film.film_id = inventory.film_id
         INNER JOIN rental ON inventory.inventory_id = rental.inventory_id
GROUP BY film.title
ORDER BY rental_count DESC
    LIMIT 5;
