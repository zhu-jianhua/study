create or replace procedure get_cat_header(
    category_id_in INTEGER,
    cat_header_out OUT pack.my_targets,
    cat_attrib_out OUT pack.my_targets,
IS
    v_action VARCHAR2(2) := '01';
BEGIN
    IF category_id_in is NULL THEN
	     OPEN cat_header_out for select NULL from DUAL;
	     OPEN cat_attrib_out for select NULL from DUAL;
    END IF;

    open cat_header_out for 
	     SELECT
	     column_name, 
	     column_display_name,
	     column_order
     	FROM
	     event_table_columns
     	WHERE
	     table_name = 'product'
	     ORDER BY column_order;
	
   open cat_attrib_out for 
	    SELECT attribute_id, attribute_name 
     FROM attribute
	    WHERE category_id = category_id_in;
END;
/
show errors