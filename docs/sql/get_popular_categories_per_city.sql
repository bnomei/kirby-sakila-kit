
/*Popular Genres:
Determine the top three most rented film categories for each city, based on the total number of rentals.
Include cities with fewer than three film categories rented out.*/

use sakila;

with popular_film_categories_by_city as
(
SELECT 
    ct.city_id,
    ca.name AS category_name,
    COUNT(r.rental_id) AS rental_counts,
    row_number()over(partition by ct.city_id order by COUNT(r.rental_id) desc) as category_rank
FROM
    city ct
        left JOIN
    address a ON ct.city_id = a.city_id
    left join 
    customer cu on cu.address_id=a.address_id
    left join
   rental r on r.customer_id=cu.customer_id
    left join
    inventory i on i.inventory_id=r.inventory_id
    left join
    film_category fc on fc.film_id=i.film_id
    left join
    category ca on ca.category_id=fc.category_id
group by ct.city_id,ca.name
)
select 
city_id,
category_name,
rental_counts
from popular_film_categories_by_city
where category_rank <=3
or category_rank is null
;

