<?php

namespace App\Controllers;
use App\Models\CustomerModel;

class Customer extends BaseController
{
    private $customerModel;
    private $customerFields;
    //$data['employeeFields'] = $employeeFields; <- used for passing into a view
    
    public function __construct(){
        $this->customerModel = new CustomerModel();
        $this->customerFields = $this->customerModel->get_columnNames();
    }

    public function view($seg1 = false){
        $data['pageTitle'] = "View Customers";
        $customers = $this->customerModel->get_customer($seg1);
        $data['customers'] = $customers;

        echo view('templates/header.php', $data);
        echo view('customer/view.php', $data);
        echo view('templates/footer.php');
       // return()
        
    }

    public function create(){
        $data['pageTitle'] = "Create Customer";
        $data['formFields'] = $this->customerFields;

        echo view('templates/header.php', $data);

        if($this->request->getMethod() === 'post' && $this->validate([
            'customer_id'=> 'required',
            'first_name' => 'required|min_length[3]|max_length[30]',
            'last_name' => 'required|min_length[3]|max_length[30]',
            'email' => 'required',
            'phone'=> 'required',
            'dob'=> 'required', 
            'shipment_address'=> 'required'
        ])){
            $this->customerModel->save(
                [
                    'customer_id' => $this->request->getPost('customer_id'),
                    'first_name' => $this->request->getPost('first_name'),
                    'last_name' => $this->request->getPost('last_name'),
                    'email' => $this->request->getPost('email'),
                    'phone' => $this->request->getPost('phone'), 
                    'dob' => $this->request->getPost('dob'), 
                    'shipment_address' => $this->request->getPost('shipment_address')
                ]
            );
            $data['message'] = $this->request->getPost('first_name') . ' was created successfully.';
            $data['callback_link'] = '/customer/create';
            echo view('templates/success_message.php', $data);
            
            //echo ($this->request->getPost('first_name') . ' was created successfully.');
        }
        else{
            echo view('customer/create.php');
        }
        
        echo view('templates/footer.php');
    }

    public function update($seg1 = false){
        $data['pageTitle'] = "Update Customer";
        $data['formFields'] = $this->customerFields;

        echo view('templates/header.php', $data);

        if(!$seg1) {
            //reject navigation to this page if an employee isn't selected
            $data['message'] = "An customer must be selected.";
            $data['callback_link'] = "/customer";
            echo view('templates/error_message.php', $data);
        }
        else{
            //if employee was selected, get it from db and send to update view
            if($this->request->getMethod() === 'post' && $this->validate([
                'customer_id'=> 'required',
                'first_name' => 'required|min_length[3]|max_length[30]',
                'last_name' => 'required|min_length[3]|max_length[30]',
                'email' => 'required',
                'phone'=> 'required',
                'dob'=> 'required', 
                'shipment_address'=> 'required'
            ])){
                $this->customerModel->save(
                    [
                    'customer_id' => $this->request->getPost('customer_id'),
                    'first_name' => $this->request->getPost('first_name'),
                    'last_name' => $this->request->getPost('last_name'),
                    'email' => $this->request->getPost('email'),
                    'phone' => $this->request->getPost('phone'), 
                    'dob' => $this->request->getPost('dob'), 
                    'shipment_address' => $this->request->getPost('shipment_address')
                    ]
                );
                echo ("Customer was saved!");
            } else {
                $data['customer'] = $this->customerModel->get_customer($seg1);
                echo view('customer/update.php', $data);
            }
        }

        echo view('templates/footer.php');
    }

    public function delete($seg1 = false, $seg2 = false){
        $data['pageTitle'] = "Delete Customer";

        echo view('templates/header.php', $data);
        if(!$seg1){
            $data['message'] = "Please select a valid customer.";
            $data['callback_link'] = "/customer";
            echo view('templates/error_message.php', $data);
        }
        else{
            $customer = $this->customerModel->get_customer($seg1);
            if($seg2 == 1){
                $data['callback_link'] = "/customer";
                if($this->customerModel->delete($seg1)){
                    $data['message'] = "The customer was successfully deleted.";
                    echo view('templates/success_message.php', $data);
                }
                else{
                    $data['message'] = "The customer could not be deleted.";
                    echo view('templates/error_message.php', $data);
                }
            }
            else{
                $data['confirm'] = "Do you want to delete " . $customer[0]->first_name;
                $data['confirm_link'] = "/customer/delete/". $seg1 ."/1";
                echo view('customer/delete.php', $data);
            }
            
        }
        echo view('templates/footer.php');
    }
}