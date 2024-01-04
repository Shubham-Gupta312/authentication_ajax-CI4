<?php

namespace App\Controllers;

use App\Libraries\Hash;

class HomeController extends BaseController
{
    public function index(): string
    {
        return view('welcome_message');
    }

    public function register()
    {
        // echo"Register page";
        if ($this->request->getMethod() == 'get') {
            return view('register');
        } elseif ($this->request->getMethod() == 'post') {
            $validation = $this->validate([
                // validation rules
                'username' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Your Name is required',
                    ]
                ],
                'name' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Your Name is required'
                    ]
                ],
                'email' => [
                    'rules' => 'required|valid_email',
                    'errors' => [
                        'required' => 'Your Email is required',
                        'valid_email' => 'You must enter a valid email'
                    ]
                ],
                'phone' => [
                    'rules' => 'required|numeric|max_length[10]|min_length[10]',
                    'errors' => [
                        'required' => 'Contact No. is Required',
                        'numeric' => 'Your Contact No. must be a number',
                        'min_length' => 'Your Contact No. must have 10 digits number',
                        'max_length' => 'Your Contact No. must have 10 digits number'
                    ]
                ],
                'password' => [
                    'rules' => 'required|min_length[5]|max_length[10]',
                    'errors' => [
                        'required' => 'Password is required',
                        'min_length' => 'Password must have atleast 5 characters in length',
                        'max_length' => 'Password must not have more that 10 characters in length',
                    ]
                ],
                'confirmPassword' => [
                    'rules' => 'required|min_length[5]|max_length[10]|matches[password]',
                    'errors' => [
                        'required' => 'Confirm Password is required',
                        'min_length' => 'Password must have atleast 5 characters in length',
                        'max_length' => 'Password must not have more that 10 characters in length',
                        'matches' => 'Your password should be match with entered Password'
                    ]
                ],
            ]);

            // check validation condition
            if (!$validation) {
                $validation = \Config\Services::validation();
                $errors = $validation->getErrors();
                echo json_encode(['status' => 'error', 'data' => 'Validate form', 'errors' => $errors]);
            } else {
                // echo "form submit";
                $username = $this->request->getPost('username');
                $name = $this->request->getPost('name');
                $email = $this->request->getPost('email');
                $phone = $this->request->getPost('phone');
                $password = $this->request->getPost('password');

                $value = [
                    'username' => $username,
                    'name' => $name,
                    'email' => $email,
                    'phone' => $phone,
                    'password' => Hash::pass_enc($password)
                ];

                // calling model to submit data to database
                $registerModel = new \App\Models\RegisterModel();
                $query = $registerModel->insert($value);

                if (!$query) {
                    $message = ['status' => 'error', 'message' => 'Something went Wrong!'];
                    return $this->response->setJSON($message);
                } else {
                    $message = ['status' => 'success', 'message' => 'Data Added Successfully!'];
                    return $this->response->setJSON($message);
                }

                // echo json_encode(['status' => 'success', 'data' => 'Data Inserted Successfully', 'errors' => []]);
            }
        }
    }
    public function login()
    {
        // echo"Login page";
        if ($this->request->getMethod() == 'get') {
            return view('login');
        } elseif ($this->request->getMethod() == 'post') {
            $validation = $this->validate([
                'email' => [
                    'rules' => 'required|valid_email',
                    'errors' => [
                        'required' => 'Your Email is required',
                        'valid_email' => 'You must enter a valid email'
                    ]
                ],
                'password' => [
                    'rules' => 'required|min_length[5]|max_length[10]',
                    'errors' => [
                        'required' => 'Password is required',
                        'min_length' => 'Password must have atleast 5 characters in length',
                        'max_length' => 'Password must not have more that 10 characters in length',
                    ]
                ],
            ]);
            // check validation condition
            if (!$validation) {
                $validation = \Config\Services::validation();
                $errors = $validation->getErrors();
                echo json_encode(['status' => 'error', 'data' => 'Validate form', 'errors' => $errors]);
            } else {
                // echo "Login";
                $email = $this->request->getPost('email');
                $password = $this->request->getPost('password');

                // fetching databse to check user
                $loginModel = new \App\Models\RegisterModel();
                $user_data = $loginModel->where('email', $email)->first();
                $check_password = Hash::verify_pass($password, $user_data['password']);

                if (!$check_password) {
                    $message = ['status' => 'error', 'message' => 'You Entered wrong password!'];
                    return $this->response->setJSON($message);
                } else {
                    if (!is_null($user_data)) {
                        $session_data = [
                            'id' => $user_data['id'],
                            'name' => $user_data['name'],
                            'email' => $user_data['email'],
                            'loggedin' => 'loggedin'
                        ];
                        // filter data from database according to roles and send the user to their destination page 
                        session()->set($session_data);
                    }
                    $message = ['status' => 'success', 'message' => 'Logged in Successfully!'];
                    return $this->response->setJSON($message);
                    // return redirect()->to(base_url());
                }
            }
        }
    }

    public function logout()
    {
        session_unset();
        session()->destroy();
        return redirect()->to(base_url('login'));
    }
}
