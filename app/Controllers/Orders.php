<?php

namespace App\Controllers;
use App\Models\OrdersModel;

class Orders extends BaseController
{
    private $ordersModel;
    private $ordersFields;
    //$data['orderFields'] = $orderFields; <- used for passing into a view
    
    public function __construct(){
        $this->ordersModel = new OrdersModel();
        $this->ordersFields = $this->ordersModel->get_columnNames();
    }

    public function view($seg1 = false){
        $data['pageTitle'] = "View Orders";
        $orderss = $this->ordersModel->get_orders($seg1);
        $data['orderss'] = $orderss;

        echo view('templates/header.php', $data);
        echo view('orders/view.php', $data);
        echo view('templates/footer.php');
    }

    public function create(){
        $data['pageTitle'] = "Create Order";
        $data['formFields'] = $this->ordersFields;

        echo view('templates/header.php', $data);

        if($this->request->getMethod() === 'post' && $this->validate([
            'order_id' => 'required|min_length[1]|max_length[30]',
            'customer_id' => 'required|min_length[1]|max_length[30]',
            'order_date' => 'required',
            'paid' => 'required',
            'order_status' => 'required'
        ])){
            $this->ordersModel->save(
                [
                    'order_id' => $this->request->getPost('order_id'),
                    'customer_id' => $this->request->getPost('customer_id'),
                    'order_date' => $this->request->getPost('order_date'),
                    'paid' => $this->request->getPost('paid'),
                    'order_status' => $this->request->getPost('order_status') ///// might need stuff!!!!!
                ]
            );
            $data['message'] = $this->request->getPost('order_id') . ' was created successfully.';
            $data['callback_link'] = '/orders/create';
            echo view('templates/success_message.php', $data);
            
            //echo ($this->request->getPost('firstName') . ' was created successfully.');
        }
        else{
            echo view('orders/create.php');
        }
        
        echo view('templates/footer.php');
    }

    public function update($seg1 = false){
        $data['pageTitle'] = "Update Orders";
        $data['formFields'] = $this->ordersFields;

        echo view('templates/header.php', $data);

        if(!$seg1) {
            //reject navigation to this page if an employee isn't selected
            $data['message'] = "An order must be selected.";
            $data['callback_link'] = "/orders";
            echo view('templates/error_message.php', $data);
        }
        else{
            //if employee was selected, get it from db and send to update view
            if($this->request->getMethod() === 'post' && $this->validate([
                'order_id' => 'required|min_length[1]|max_length[30]',
                'customer_id' => 'required|min_length[1]|max_length[30]',
                'order_date' => 'required', 
                'paid' => 'required',
                'order_status' => 'required'
            ])){
                $this->ordersModel->save(
                    [
                        'order_id' => $this->request->getPost('order_id'),
                        'customer_id' => $this->request->getPost('customer_id'),
                        'order_date' => $this->request->getPost('order_date'),
                        'paid' => $this->request->getPost('paid'),
                        'order_status' => $this->request->getPost('order_status')
                    ]
                );
                echo ("Order was saved!");
            } else {
                $data['orders'] = $this->ordersModel->get_order($seg1);
                echo view('orders/update.php', $data);
            }
        }

        echo view('templates/footer.php');
    }

    public function delete($seg1 = false, $seg2 = false){
        $data['pageTitle'] = "Delete orders";

        echo view('templates/header.php', $data);
        if(!$seg1){
            $data['message'] = "Please select a valid order.";
            $data['callback_link'] = "/orders";
            echo view('templates/error_message.php', $data);
        }
        else{
            $order = $this->ordersModel->get_orders($seg1);
            if($seg2 == 1){
                $data['callback_link'] = "/orders";
                if($this->ordersModel->delete($seg1)){
                    $data['message'] = "The order was successfully deleted.";
                    echo view('templates/success_message.php', $data);
                }
                else{
                    $data['message'] = "The order could not be deleted.";
                    echo view('templates/error_message.php', $data);
                }
            }
            else{
                $data['confirm'] = "Do you want to delete " . $order[0]->order_id;
                $data['confirm_link'] = "/orders/delete/". $seg1 ."/1";
                echo view('orders/delete.php', $data);
            }
            
        }
        echo view('templates/footer.php');
    }
}