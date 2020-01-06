<?php

if(!function_exists('db_last_insert_id')) {
    function db_last_insert_id($table, $field)
    {
        $sql = \DB::table($table)->MAX($field) + 1;
        if ($sql < 1) {
            return 1;
        } else return $sql;
    }
}

// DB::select('select * from users where id = :id', ['id' => 1]);
if(!function_exists('select_option')) {
    function select_option($table, $option_id, $option_name, $condition )
    {

        $sql = \DB::select("select $option_id , $option_name  from $table  where $condition");
        return $sql;

    }
}

if(!function_exists('find_all_field')) {
    function find_all_field($table, $field, $codition) {
        $data = \DB::select("select $field from $table where $codition");
        return $data;
    }   

}



if(!function_exists('present_stock')) {
    function present_stock($itemId, $warehouseId) {
        $data1 = \DB::table('warehouse_other_receive_detail')->where([
            ['item_id', $itemId],
            ['warehouse_id',$warehouseId]
            ])->sum('qty');

        $data2 = \DB::table('warehouse_other_issue_detail')->where([
            ['item_id', $itemId],
            ['warehouse_id', $warehouseId]
            ])->sum('qty');

        // $data2 = \DB::select("select sum(qty) from warehouse_other_issue_detail where item_id = 91");
        $data = $data1 - $data2;
        return $data;
    }
}



