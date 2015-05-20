CREATE OR REPLACE PROCEDURE get_categories(
  category_list_out OUT pack.my_targets) 
IS

BEGIN
  OPEN category_list_out FOR
    SELECT category_id, category_url 
    FROM CATEGORY 
    ORDER BY category_url;
END;
/
show errors