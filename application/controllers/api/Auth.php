<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

// Load the Rest Controller library
require APPPATH . '/libraries/REST_Controller.php';

class Auth extends REST_Controller {

    public function __construct() { 
        parent::__construct();
        
        // Load the user model
        $this->load->model('User');
    }
    
    public function login_post() {
        // Get the post data
        $username = $this->post('username');
        $password = $this->post('password');
        
        // Validate the post data
        if(!empty($username) && !empty($password)){
            
            // Check if any user exists with the given credentials
            $con['returnType'] = 'single';
            $con['conditions'] = array(
                'username' => $username,
                'kontak' => $username,
                'password' => $password);
            $user = $this->User->getRows($con);
            
            
            if($user){
                
                $user['id'] = $user['id_user'];
                $user['role'] = "admin";
                // Set the response and exit
                $this->response([
                    'success' => TRUE,
                    'message' => 'User login successful.',
                    'data' => $user
                ], REST_Controller::HTTP_OK);
            }else{
                $con['table'] = "anak_kos";
                $con['conditions'] = array(
                    'nama' => $username,
                    'kontak' => $username,
                    'password' => $password);
                $user = $this->User->getRows($con);
                
                if($user){
                    $user['role'] = "anak kos";
                    $user['id'] = $user['id_anak_kos'];
                    // Set the response and exit
                    $this->response([
                        'success' => TRUE,
                        'message' => 'User login successful.',
                        'data' => $user
                    ], REST_Controller::HTTP_OK);
                }else{
                     // Set the response and exit
                    //BAD_REQUEST (400) being the HTTP response code
                    $this->response([
                        'success' => FALSE,
                        'message' => "Wrong email or password."
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
               
            }
        }else{
            // Set the response and exit
            $this->response([
                'success' => FALSE,
                'message' => "Provide email and password."
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
    
    

}