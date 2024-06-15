SELECT category.name, COUNT(film_category.film_id) AS film_count
FROM category
         INNER JOIN film_category ON category.category_id = film_category.category_id
GROUP BY category.category_id
ORDER BY film_count DESC
LIMIT 5;
