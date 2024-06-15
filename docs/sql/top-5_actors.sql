SELECT actor.first_name, actor.last_name, COUNT(film_actor.film_id) AS film_count
FROM actor
         INNER JOIN film_actor ON actor.actor_id = film_actor.actor_id
GROUP BY actor.actor_id
ORDER BY film_count DESC
LIMIT 5;
