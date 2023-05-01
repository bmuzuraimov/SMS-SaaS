<?php
namespace application\controllers;

use application\core\Controller;

class MainController extends Controller
{
    public function indexAction()
    {
        $vars = [
        ];
        $this->view->render($vars);
    }
    public function documentationAction()
    {
        $vars = [
        ];
        $this->view->render($vars);
    }
    public function checkAction()
    {
        $check = array('success' => true, 'status' => 'ok', 'message' => 'ok');
        echo json_encode($check);
    }
    public function send_messageAction()
    {
        $response = array(
            '100' => array('success' => false, 'message' => array('code' => '100', 'type' => 'invalid_access_key', 'info' => 'No API Key was specified or an invalid API Key was specified.')),
            '101' => array('success' => false, 'message' => array('code' => '101', 'type' => 'invalid_receiver', 'info' => 'No receiver (phone, contact, group) was specified')),
            '102' => array('success' => false, 'message' => array('code' => '102', 'type' => 'no_message', 'info' => 'No message was specified.')),
            '103' => array('success' => false, 'message' => array('code' => '103', 'type' => 'message_length', 'info' => 'The length of message exceeds max length of 72 characters.')),
            '104' => array('success' => false, 'message' => array('code' => '104', 'type' => 'usage_limit_reached', 'info' => 'The maximum allowed amount of monthly API requests has been reached.')),
            '105' => array('success' => false, 'message' => array('code' => '105', 'type' => 'incorrect_carrier', 'info' => 'The carrier of phone is incorrect.')),
            '106' => array('success' => false, 'message' => array('code' => '106', 'type' => 'incorrect_date_format', 'info' => 'The format of the date is incorrect.')),
        );
        $auth_key = filter_input(INPUT_GET, 'access_key');
        $phone    = filter_input(INPUT_GET, 'phone');
        $contact  = filter_input(INPUT_GET, 'contact');
        $group    = filter_input(INPUT_GET, 'group');
        $message  = filter_input(INPUT_GET, 'message');
        $date     = filter_input(INPUT_GET, 'date');
        $api_info = $this->model->validate_api($auth_key);
        $carrier  = $this->model->get_carrier($phone);
        if (!$api_info) {
            echo json_encode($response['100']);
            return;
        }
        if (empty($phone) && empty($contact) && empty($group)) {
            echo json_encode($response['101']);
            return;
        }
        if (empty($message)) {
            echo json_encode($response['102']);
            return;
        }
        if (mb_strlen($message, 'UTF-8') > 72) {
            echo json_encode($response['103']);
            return;
        }
        if (($api_info['month_requests'] - $api_info['used_requests']) == 0) {
            echo json_encode($response['104']);
            return;
        }
        echo $api_info['month_requests'];
        /*if(validateDate($date, 'Y-m-d H:i:s')){
            echo json_encode($response['106']);
            return;            
        }*/
        //check incomplete payments
        if (!empty($phone)) {
            $phone_ext = substr($phone, 0, 4);
            if ($carrier === false) {
                echo json_encode($response['105']);
                return;
            }
            $this->model->add_message($api_info['id'], $carrier, $phone, $message, null);
        } elseif (!empty($contact)) {
            # contact
            //is contact exists from api
            //send sms to contact
        } elseif (!empty($group)) {
            # group
            //is group exists from api
            // get all contacts in group
            //use iteration to send each
        } else {
            # Undefined error
        }

    }
    public function get_smsAction()
    {
        $key  = filter_input(INPUT_GET, 'auth');
        $type = filter_input(INPUT_GET, 'type');
        if ($key === '34f47de7-843d-4bf2-942b-136a4ab64244') {
            if ($type === 'message') {
                $message = $this->model->available_sms();
                echo (json_encode($message, JSON_UNESCAPED_UNICODE));
            } elseif ($type === 'send') {
                $id         = filter_input(INPUT_GET, 'id');
                $isIdExists = (isset($id)) ? $this->model->is_sms_exists($id) : false;
                if (!$isIdExists == false) {
                    $this->model->send_sms($id);
                } else {
                    echo '0';
                }
            } else {
                $this->view->errorCode(403);
            }
        } else {
            $this->view->errorCode(403);
        }
    }
    public function elsom_billAction()
    {
        $key = filter_input(INPUT_POST, 'api_key');
        if ($key === '34f24he5-4p1d-4vf0-w42b-1t3a0ab6p24g') {
            $bill          = filter_input(INPUT_POST, 'bill');
            $bill          = explode(" ", $bill);
            $phone         = $bill[4];
            $currency      = preg_replace('/[^A-Za-z0-9\-]/', '', $bill[7]);
            $transactionid = $bill[8];
            $isTsExists    = $this->model->transaction_exists($phone, $transactionid);
            $today         = date('Y-m-d H:i:s');
            if ($isTsExists == false) {
                $this->model->add_transaction($phone, $paid_amount, $currency, $transactionid, "incomplete", $today);
            } else {
                $status = ($isTsExists['amount'] <= ($isTsExists['paid_amount'] + $paid_amount) && $isTsExists['amount'] != 0) ? "success" : "incomplete";
                $this->model->verify_transaction();
            }

        } else {
            $this->view->errorCode(403);
        }
    }
}
