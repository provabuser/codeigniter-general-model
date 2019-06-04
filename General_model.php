<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Model for All kind of generalised query
 * @author Himanshu Sharma
 * contact Number +91-881-883-1288
 * contact email : Learndphere@gmail.comd
 */
class General_model extends CI_Model
{

    /*
        * Insert query with dynamic parameters are as follows    
        * $table - table name    
        * $data - an array of field value pair which will insert directly in DB     
        * Return - last insert id    
        *
        * Sample query- INSERT INTO `quotation`($data->keys) VALUES ($data-values)
    */
    public function insert($table,$data){
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }

    /*
        * Update query with dynamic parameters as follows
        * $table - name of table
        * $data - Data in array format for update
        * $id - value of the field for where clouse 
        * $where_id - field name in case if your primary key is other then id 
        * Return - boolean value whether query run successfully or not
        *
        * Sample query - UPDATE `quotation` SET $data->key =$data->values  WHERE $where_id = $id
    */
    public function update($table, $data, $id, $where_id = 'id'){
        $this->db->where($where_id, $id);
        $rs = $this->db->update($table, $data);
        if($rs)
            return true;
        return false;
    }

    /*
        * Delete Query with dynamic parameters are as follows
        * $table - name of the table
        * $where - array of key value pair for WHERE caluse, $where is string then $id_column will be the field name
        * $id_column - in case where is strong then you can pass Any field name on which it will check and delete record default is `id`
        * Return - return boolean value whether query is successfully run or not
        *
        * Sample query - DELETE FROM $table WHERE $where
    */
    public function delete($table, $where, $id_column = 'id')
    {
        /* Where condition check*/
        if(is_array($where))
        {
            $this->db->where($where);
            $rs = $this->db->delete($table);
        }else{
            $this->db->where($id_column,$where);
            $rs = $this->db->delete($table);
        }
        if($rs)
            return true;
        return false;
        
    }

    /*
        * Select Query for MULTIPLE results in array form with dynamic patameters are as follows
        * $table - TABLE name
        * $where - array of key value pair for WHERE caluse , in case if its string then it will compair its value only with `id` 
        * order_field - ORDER BY valuse field name
        * order_type - ORDER BY type 
        * $select - default is * in case if you want selected fields then put name
        * limit - if you only want LIMIT then pass string and if you want LIMIT and OFFSET both then pass array 
        Like array('limit'=>value, 'offset'=> value)
        * return - multi-dimentional array with all data
        *
        * Sample query : SELECT $select FROM $table WHERE $where $order $limit
    */
    public function get_all($table, $where=null, $order_field = null, $order_type='ASC', $select = '*' , $limit = null)
    {
        /*Select Statement, Default is `*` */
        $this->db->select($select);

        /*Where Condition if its array then it will be multiple conditions otherwise only taking on the basis of id */
        if($where != null):
            if(is_array($where))
                $this->db->where($where);
            else
                $this->db->where('id',$where);
        endif;

        /* Order By */
        if($order != null)
            $this->db->order_by($order_field,$order_type);
        

        /*Limits and offset*/
        if($limit != null){
            if(is_array($limit))
                $this->db->limit($limit['limit'], $limit['offset']);
            else
                $this->db->limit($limit['limit']);
        }

        return $this->db->get($table)->result_array();
    }

    /*
        * Select Query for SINGLE results in array form with dynamic patameters are as follows
        * $table - TABLE name
        * $where - array of key value pair for WHERE caluse , in case if its string then it will compair its value only with `id` 
        * $select - default is * in case if you want selected fields then put name
        * limit - if you only want LIMIT then pass string and if you want LIMIT and OFFSET both then pass array 
        Like array('limit'=>value, 'offset'=> value)
        * return - one-dimentional array with single row data
        *
        * Sample query : SELECT $select FROM $table WHERE $where $order $limit
        * additional Points if you want Sum of any field then in select parameter pass SUM(amount) as sum and get value in sum key
    */
    public function get_one($table, $where=null, $select = '*',$limit = null)
    {
        /*Select Statement, Default is `*` */
        $this->db->select($select);

        /*Where Condition if its array then it will be multiple conditions otherwise only taking on the basis of id */
        if($where != null):
            if(is_array($where))
                $this->db->where($where);
            else
                $this->db->where('id',$where);
        endif;

        /*Limits and offset*/
        if($limit != null){
            if(is_array($limit))
                $this->db->limit($limit['limit'], $limit['offset']);
            else
                $this->db->limit($limit['limit']);
        }
        return $this->db->get($table)->row_array();
    }

    /*
        * Select Query for get Count with dynamic patameters are as follows
        * $table - TABLE name
        * $where - array of key value pair for WHERE caluse , in case if its string then it will compair its value only with `id` 
        * return - COUNT of all the results
        *
        * Sample query : SELECT COUNT($select) as count FROM $table WHERE $where $order $limit
    */
    public function get_count($table, $where=null)
    {
        
        /*Where Condition if its array then it will be multiple conditions otherwise only taking on the basis of id */
        if($where != null):
            if(is_array($where))
                $this->db->where($where);
            else
                $this->db->where('id',$where);
        endif;

        $this->db->get($table);
        return $this->db->count_all_results();
    }

}

?>