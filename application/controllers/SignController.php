<?php
namespace application\controllers;

use application\core\Controller;

class SignController extends Controller
{
    protected $db;
    private function connectDb()
    {
        $config   = require 'application/config/db.php';
        $this->db = mysqli_connect($config['host'], $config['user'], $config['password'], $config['dbname']);
        if (mysqli_connect_errno()) {
            exit('Failed to connect to MySQL: ' . mysqli_connect_error());
        }
    }
    private function api_key_generator($session = false)
    {
        $alphabet    = '4z803dlnt282w5ibsq5o11p096xvuc64fym9h7j3aer7kg';
        $alphaLength = strlen($alphabet) - 1;
        $cycle       = array();
        if ($session === false) {
            $cycles = array(8, 4, 4, 4, 12);
            shuffle($cycles);
            $api_key = "";
            for ($i = 0; $i < 5; $i++) {
                for ($j = 0; $j < $cycles[$i]; $j++) {
                    $n         = rand(0, $alphaLength);
                    $cycle[$j] = $alphabet[$n];
                }
                if (empty($api_key)) {
                    $api_key .= implode($cycle);
                } else {
                    $api_key .= "-" . implode($cycle);
                }
                $cycle = array();
            }
            return $api_key;
        } else {
            $cycles = array(8, 4, 12);
            shuffle($cycles);
            $session_key = "";
            for ($i = 0; $i < 3; $i++) {
                for ($j = 0; $j < $cycles[$i]; $j++) {
                    $n         = rand(0, $alphaLength);
                    $cycle[$j] = $alphabet[$n];
                }
                if (empty($session_key)) {
                    $session_key .= implode($cycle);
                } else {
                    $session_key .= "-" . implode($cycle);
                }
                $cycle = array();
            }
            return $session_key;
        }
    }
    public function signinAction()
    {
        $vars = [
        ];
        $this->view->render($vars);
    }
    public function signupAction()
    {
        $vars = [
        ];
        $this->view->render($vars);
    }
    private function send_verification($phone, $message)
    {
        $carrier = $this->model->get_carrier($phone);
        $this->model->add_message(null, $carrier, $phone, $message, null);
    }
    public function verificationAction()
    {
        $customer_id     = filter_input(INPUT_GET, "customerid");
        $customer_exists = $this->model->customer_exists($customer_id, null);
        if ($customer_exists == true) {
            $vars = [
                'customer_id' => $customer_id,
            ];
            $this->view->render($vars);
        } else {
            $this->view->redirect('/');
        }
    }
    public function verifyAction()
    {
        if ('POST' === $_SERVER['REQUEST_METHOD']) {
            $customerid        = filter_input(INPUT_POST, 'customerid');
            $verification_code = filter_input(INPUT_POST, 'verification_code');
            $isValid           = $this->model->validate_user($customerid, $verification_code);
            echo $isValid;
        }
    }
    public function registerAction()
    {
        if ('POST' === $_SERVER['REQUEST_METHOD']) {
            if (!empty($_POST['phone']) && !empty($_POST['password'])) {
                $fname           = filter_input(INPUT_POST, 'fname');
                $lname           = filter_input(INPUT_POST, 'lname');
                $website         = filter_input(INPUT_POST, 'website');
                $phone           = filter_input(INPUT_POST, 'phone');
                $password        = filter_input(INPUT_POST, 'password');
                $customer_exists = $this->model->customer_exists(null, $phone);
                if ($customer_exists != true) {
                    $ip                = $this->model->get_client_ip();
                    $verification_code = str_pad(rand(0, pow(10, 4) - 1), 4, '0', STR_PAD_LEFT);
                    $message           = "Код потверждения: " . $verification_code;
                    $this->send_verification($phone, $message);
                    $api_key     = $this->api_key_generator();
                    $customer_id = $this->model->add_customer($api_key, $verification_code, $fname, $lname, $website, $phone, $password, $ip);
                    echo json_encode(array('success' => true, 'link' => "verification?customerid=$customer_id", 'message' => 'Ваш аккаунт успешно создан!'), JSON_UNESCAPED_UNICODE);
                } else {
                    echo json_encode(array('success' => false, 'link' => null, 'message' => 'Такой номер телефона уже существует!'), JSON_UNESCAPED_UNICODE);
                }
            } else {
                echo json_encode(array('success' => false, 'link' => null, 'message' => 'Заполните все поля!'), JSON_UNESCAPED_UNICODE);
            }
        }
    }
    public function authenticateAction()
    {
        if ('POST' === $_SERVER['REQUEST_METHOD']) {
            if (!empty($_POST['phone']) && !empty($_POST['password'])) {
                $sign_phone    = filter_input(INPUT_POST, 'phone');
                $sign_password = filter_input(INPUT_POST, 'password');
                $this->connectDb();
                if (is_numeric($sign_phone)) {
                    $stmt    = $this->db->prepare('SELECT `id`, `valid`, `fname`, `lname`, `phone`, `password` FROM `customers` WHERE `phone` = ?');
                    $isAdmin = 0;
                } else {
                    $stmt    = $this->db->prepare('SELECT `id`, `username`, `password` FROM `admin` WHERE `username` = ?');
                    $isAdmin = 1;
                }
                if ($stmt) {
                    $stmt->bind_param('s', $sign_phone);
                    $stmt->execute();
                    $stmt->store_result();
                    if ($stmt->num_rows > 0) {
                        if ($isAdmin === 1) {
                            $stmt->bind_result($id, $username, $password);
                        } else {
                            $stmt->bind_result($id, $valid, $fname, $lname, $username, $password);
                        }
                        $stmt->fetch();
                        if (password_verify($sign_password, $password)) {
                            $key = $this->api_key_generator(true);
                            $ip  = $this->model->get_client_ip();
                            if ($this->model->isExist($id, $isAdmin)) {
                                $this->model->updateKey($id, $key, $isAdmin, $ip);
                                if ($isAdmin === 1) {
                                    session_regenerate_id();
                                    $_SESSION['authkey'] = $key;
                                    $_SESSION['user']    = $id;
                                    $_SESSION['isAdmin'] = $isAdmin;
                                    echo json_encode(array('success' => true, 'link' => 'admin', 'message' => 'Выполняется вход...'), JSON_UNESCAPED_UNICODE);
                                } else {
                                    if ($valid === 1) {
                                        session_regenerate_id();
                                        $_SESSION['name']    = $fname . " " . $lname;
                                        $_SESSION['authkey'] = $key;
                                        $_SESSION['user']    = $id;
                                        $_SESSION['isAdmin'] = $isAdmin;
                                        echo json_encode(array('success' => true, 'link' => 'customer', 'message' => 'Выполняется вход...'), JSON_UNESCAPED_UNICODE);
                                    } else {
                                        echo json_encode(array('success' => false, 'link' => null, 'message' => 'Ваш аккаунт еще не подтвержден'), JSON_UNESCAPED_UNICODE);
                                    }
                                }
                            } else {
                                $this->model->setKey($id, $key, $isAdmin, $ip);
                                if ($isAdmin === 1) {
                                    session_regenerate_id();
                                    $_SESSION['authkey'] = $key;
                                    $_SESSION['user']    = $id;
                                    $_SESSION['isAdmin'] = $isAdmin;
                                    echo json_encode(array('success' => true, 'links' => 'admin', 'message' => 'Выполняется вход...'), JSON_UNESCAPED_UNICODE);
                                } else {
                                    if ($valid === 1) {
                                        session_regenerate_id();
                                        $_SESSION['name']    = $fname . " " . $lname;
                                        $_SESSION['authkey'] = $key;
                                        $_SESSION['user']    = $id;
                                        $_SESSION['isAdmin'] = $isAdmin;
                                        echo json_encode(array('success' => true, 'links' => 'customer', 'message' => 'Выполняется вход...'), JSON_UNESCAPED_UNICODE);
                                    } else {
                                        echo json_encode(array('success' => false, 'links' => null, 'message' => 'Ваш аккаунт еще не подтвержден'), JSON_UNESCAPED_UNICODE);
                                    }
                                }
                            }
                        } else {
                            echo json_encode(array('success' => false, 'links' => null, 'message' => 'Неверный номер или пароль'), JSON_UNESCAPED_UNICODE);
                        }
                    } else {
                        echo json_encode(array('success' => false, 'links' => null, 'message' => 'Неверный номер или пароль'), JSON_UNESCAPED_UNICODE);
                    }
                    $stmt->close();
                }
            } else {
                echo json_encode(array('success' => false, 'link' => null, 'message' => 'Заполните все поля!'), JSON_UNESCAPED_UNICODE);
            }
        }
    }

}
