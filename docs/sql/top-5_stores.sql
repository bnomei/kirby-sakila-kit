SELECT store.store_id, COUNT(rental.rental_id) AS rental_count
FROM store
         INNER JOIN inventory ON store.store_id = inventory.store_id
         INNER JOIN rental ON inventory.inventory_id = rental.inventory_id
GROUP BY store.store_id
ORDER BY rental_count DESC
LIMIT 5;
