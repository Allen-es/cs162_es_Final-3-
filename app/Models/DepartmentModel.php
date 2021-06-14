<?php

namespace App\Models;

use CodeIgniter\Model;

class DepartmentModel extends Model
{
    //attributes
    protected $table = 'department';
    protected $db;
    protected $allowedFields = ['name', 'description'];


    //constructor
    public function __construct(){
        parent::__construct();
        $this->db = \Config\Database::connect();
    }

    public function insert_department($department = array()){

    }

    public function delete_department($name = false){

    }

    public function update_department($department = array()){

    }

    public function get_department($name = false){
        if(!$name){
            //if $id is false get all employees
            $sql = "SELECT * FROM " . $this->table;
            $query = $this->db->query($sql);
            return $query->getResult();
        }
        else{
            //otherwise get department by id
            $sql = "SELECT * FROM " . $this->table . " WHERE name='".$name."'";
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