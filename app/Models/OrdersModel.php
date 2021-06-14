<?php

namespace App\Models;

use CodeIgniter\Model;

class OrdersModel extends Model
{
    //attributes
    protected $table = 'orders';
    protected $db;
    protected $allowedFields = ['order_id', 'customer_id', 'order_date', 'paid', 'order_status'];


    //constructor
    public function __construct(){
        parent::__construct();
        $this->db = \Config\Database::connect();
    }

    public function insert_orders($orders = array()){

    }

    public function delete_orders($id = false){

    }

    public function update_orders($orders = array()){

    }

    public function get_orders($id = false){
        if(!$id){
            //if $id is false get all orders
            $sql = "SELECT * FROM " . $this->table;
            $query = $this->db->query($sql);
            return $query->getResult();
        }
        else{
            //otherwise get order by id
            $sql = "SELECT * FROM " . $this->table . " WHERE id='".$id."'";
            $query = $this->db->query($sql);
            //SELECT * FROM order WHERE id='1'
            return $query->getResult();
        }
    }

    public function get_columnNames(){
        //information we know
        /*
        -names of the columns
        -number of columns
        -we know how to write SQL select

        */
        //information we don't know
        /*
        -get the names of all table columns
        */
        return $this->db->getFieldNames($this->table);
    }
}