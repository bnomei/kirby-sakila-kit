/*Actor Collaboration:
Identify pairs of actors who have appeared together in more than one film.
List the actor pairs along with the number of films they have collaborated on.
*/

use sakila;
SELECT f.actor_id  AS actor_1,
       f1.actor_id AS actor_2,
       COUNT(*)    AS times_collaborated
FROM film_actor f
         INNER JOIN
     film_actor f1 ON f.film_id = f1.film_id
         AND f.actor_id < f1.actor_id
GROUP BY f.actor_id, f1.actor_id
HAVING times_collaborated > 1
ORDER BY times_collaborated DESC;

/* Julia McQueen and Henry Berry have collaborated the most
This can signify a successful duo in films*/
