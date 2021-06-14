<?php

namespace App\Models;

use CodeIgniter\Model;

class AddressModel extends Model
{
    //attributes
    protected $table = 'address';
    protected $db;
    protected $allowedFields = ['address_id', 'line1', 'line2', 'city', 'state', 'zip'];


    //constructor
    public function __construct(){
        parent::__construct();
        $this->db = \Config\Database::connect();
    }

    public function insert_address($address = array()){

    }

    public function delete_address($address_id = false){

    }

    public function update_address($address = array()){

    }

    public function get_address($address_id = false){
        if(!$address_id){
            //if $id is false get all employees
            $sql = "SELECT * FROM " . $this->table;
            $query = $this->db->query($sql);
            return $query->getResult();
        }
        else{
            //otherwise get employee by id
            $sql = "SELECT * FROM " . $this->table . " WHERE address_id='".$address_id."'";
            $query = $this->db->query($sql);
            //SELECT * FROM employee WHERE id='1'
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