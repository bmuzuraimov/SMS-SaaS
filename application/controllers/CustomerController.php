<?php
namespace application\controllers;

use application\core\Controller;

class CustomerController extends Controller
{
    protected $id;
    const ISADMIN = 0;
    private function isLogin()
    {
        $this->id = (isset($_SESSION['user'])) ? $_SESSION['user'] : false;
        $auth     = $this->model->get_key($this->id, self::ISADMIN);
        if ($this->id === false || $_SESSION['authkey'] != $auth['authKey'] || $auth['isAdmin'] != self::ISADMIN) {
            $this->model->delete_key($this->id, self::ISADMIN);
            session_destroy();
            $this->view->redirect('/');
        }
    }
    public function indexAction()
    {
        $this->isLogin();
        $customer     = $this->model->get_customer_info($this->id);
        $subscription = $this->model->get_subscription_info($this->id);
        $transaction  = $this->model->get_transaction_history($this->id, false);
        if ($transaction['status'] == 'success') {
            $status_color   = 'green';
            $account_status = 'Активированный';
            $due_amount     = 0;
        } else {
            $status_color   = 'red';
            $account_status = 'Неактивированный';
            $due_amount     = $transaction['amount'];
        }
        $vars = [
            'customer'       => $customer,
            'subscription'   => $subscription,
            'account_status' => $account_status,
            'status_color'   => $status_color,
            'due_amount'     => $due_amount,
        ];
        $this->view->render($vars);
    }
    public function accountAction()
    {
        $this->isLogin();
        $customer = $this->model->get_customer_info($this->id);
        $vars     = [
            'customer' => $customer,
        ];
        $this->view->render($vars);
    }
    public function contactsAction()
    {
        $this->isLogin();
        $contacts = $this->model->get_contacts($this->id, null);
        $groups   = $this->model->get_groups($this->id, null);
        $vars     = [
            'contacts' => $contacts,
            'groups'   => $groups,
        ];
        $this->view->render($vars);
    }
    private function group_key_generator()
    {
        $alphabet    = '1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass        = array();
        $alphaLength = strlen($alphabet) - 1;
        for ($i = 0; $i < 8; $i++) {
            $n      = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }
    public function create_groupAction()
    {
        $this->isLogin();
        if ('POST' === $_SERVER['REQUEST_METHOD']) {
            if (!empty($_POST['group_name'])) {
                $group_name     = filter_input(INPUT_POST, 'group_name');
                $group_notes    = filter_input(INPUT_POST, 'notes');
                $group_contacts = $_POST['group_contacts'];
                $group_key      = $this->group_key_generator();
                $this->model->add_group($this->id, $group_key, $group_name, $group_notes);
                foreach ($group_contacts as $contactid) {
                    $this->model->contact_to_group($contactid, $group_key);
                }
                echo "success";
            } else {
                echo "empty";
            }
        }
    }
    public function add_contactAction()
    {
        $this->isLogin();
        if ('POST' === $_SERVER['REQUEST_METHOD']) {
            if (!empty($_POST['fname']) && !empty($_POST['phone'])) {
                $fname     = filter_input(INPUT_POST, 'fname');
                $lname     = filter_input(INPUT_POST, 'lname');
                $phone     = filter_input(INPUT_POST, 'phone');
                $group_key = '';
                if (!empty($_POST['contact_groups'])) {
                    foreach ($_POST['contact_groups'] as $group) {
                        $group_key = $group_key . $group . ',';
                    }
                }
                $this->model->add_contact($this->id, $group_key, $fname, $lname, $phone);
                echo "success";
            } else {
                echo "empty";
            }
        }
    }
    public function group_infoAction()
    {
        $this->isLogin();
        if ('POST' === $_SERVER['REQUEST_METHOD']) {
            $group_id = filter_input(INPUT_POST, 'groupid');
            $group    = $this->model->get_groups($this->id, $group_id);
            $contact  = $this->model->get_contacts($this->id, null);
            $participants = 10;
            echo '<h3 class="page-title">' . $group['name'] . '</h3>
                <h4 class="page-title">' . $group['notes'] . '</h4><hr>
                <div class="content-info">
                    <a href="http://sanarip.biz.kg/send_sms?access_key=somerandomapikey&groupkey=' . $group['group_key'] . '&message=" title="Кликните чтобы скопировать ссылку" target="_blank">http://sanarip.biz.kg/send_sms?access_key=somerandomapikey&groupkey=' . $group['group_key'] . '&message=</a>
                </div><hr>
                <h5>' . $participants . ' участников</h5>';
        }
    }
    public function contact_infoAction()
    {
        $this->isLogin();
        if ('POST' === $_SERVER['REQUEST_METHOD']) {
            $contact_id    = filter_input(INPUT_POST, 'contactid');
            $contact       = $this->model->get_contacts($this->id, $contact_id);
            $groups        = $this->model->get_groups($this->id, null);
            echo '<h3 class="page-title">' . $contact['fname'] . ' ' . $contact['lname'] . '</h3>
                <h4 class="page-title">' . $contact['phone'] . '</h4>
                <hr>
                <h4 class="page-title">Группы</h4>
                    <p>' . $group['name'] . '</p>
                    <div class="content-info">
                        <a href="http://sanarip.biz.kg/send_sms?access_key=somerandomapikey&phone=&message=" title="Кликните чтобы скопировать ссылку" target="_blank">http://sanarip.biz.kg/send_sms?access_key=somerandomapikey&phone= ' . $contact['phone'] . '&message=</a>
                    </div>
                    <form action="/send_sms" method="GET">
                        <div>
                            <input type="hidden" name="access_key" value="">
                            <input type="hidden" name="phone" value="">
                            <label>Сообщение</label>
                            <input type="text" class="text-input" name="message">
                        </div>
                        <div class="animated-submit">
                            <button type="submit" class="btn btn-big" id="contact-message-btn">Отправить</button>
                        </div>
                    </form>
                    ';
        }
    }
    public function update_accountAction()
    {
        $this->isLogin();
        if ('POST' === $_SERVER['REQUEST_METHOD']) {
            if (!empty($_POST['email'])) {
                $email    = filter_input(INPUT_POST, 'email');
                $fname    = filter_input(INPUT_POST, 'fname');
                $lname    = filter_input(INPUT_POST, 'lname');
                $address  = filter_input(INPUT_POST, 'address');
                $postcode = filter_input(INPUT_POST, 'postcode');
                $city     = filter_input(INPUT_POST, 'city');
                $state    = filter_input(INPUT_POST, 'state');
                $company  = filter_input(INPUT_POST, 'company');
                $website  = filter_input(INPUT_POST, 'website');
                $this->model->update_account($this->id, $email, $fname, $lname, $address, $postcode, $city, $state, $company, $website);
                echo "success";
            } else {
                echo "empty_email";
            }
        }
    }
    public function messagesAction()
    {
        $this->isLogin();
        //$customer   = $this->model->get_customer_info($this->id);
        $vars = [
            //   'customer' => $customer,
        ];
        $this->view->render($vars);
    }
    public function subscriptionAction()
    {
        $this->isLogin();
        $customer     = $this->model->get_customer_info($this->id);
        $subscription = $this->model->get_subscription_info($this->id);
        $tariffs      = $this->model->get_tariffs();
        $vars         = [
            'customer'     => $customer,
            'subscription' => $subscription,
            'tariffs'      => $tariffs,
        ];
        $this->view->render($vars);
    }
    public function usageAction()
    {
        $this->isLogin();
        $subscription = $this->model->get_subscription_info($this->id);
        $messages     = $this->model->get_customer_messages($this->id, $subscription['from_date']);
        $vars         = [
            'subscription' => $subscription,
            'messages'     => $messages,
        ];
        $this->view->render($vars);
    }
    public function upgradeAction()
    {
        $this->isLogin();
        $payment_type = filter_input(INPUT_GET, 'payment_type');
        $tariffid     = filter_input(INPUT_GET, 'tariff');
        $amount       = filter_input(INPUT_GET, 'amount');
        if (empty($payment_type) || empty($tariffid) && empty($amount)) {
            $this->view->errorCode(403);
        } else {
            $tariff = $this->model->get_tariffs($tariffid);
            if ($tariff['monthly_price'] == 0 && empty($amount)) {
                $this->model->update_subscription(true, $this->id);
                $this->view->redirect('/customer/subscription');
            }
            $from_date  = date('Y-m-d H:i:s');
            $year_price = ($tariff['monthly_price'] * 0.12) * (100 - $tariff['yearly_discount']);
            if ($payment_type === 'monthly') {
                $due_price = $tariff['monthly_price'];
                $to_date   = date('Y-m-d H:i:s', strtotime("+1 month $from_date"));
            } else if ($payment_type === 'remaining' && is_numeric($amount)) {
                $due_price = $amount;
                echo "heelo";
            } else if ($payment_type === 'annually') {
                $due_price = $year_price;
                $to_date   = date('Y-m-d H:i:s', strtotime("+12 months $from_date"));
            } else {
                $this->view->errorCode(403);
            }
            $device_type = ($tariff['device_type'] == 'Общее') ? 1 : 2;
            //pick the best device function
            $isTsExists = $this->model->transaction_exists($this->id);
            if (!$isTsExists) {
                $transactionid  = $this->model->add_new_transaction($this->id, $tariff['name'], $due_price, "incomplete");
                $subscriptionid = $this->model->add_new_subscription($this->id, $transactionid, $tariff['name'], $device_type, $tariff['sms_quantity'], $tariff['monthly_price'], $year_price, $from_date, $to_date);
            } else {
                $transactionid = $isTsExists['id'];
                $this->model->update_transaction($transactionid, $tariff['name'], $due_price, $from_date);
                $subscriptionid = $this->model->update_subscription(false, $this->id, $transactionid, $tariff['name'], $device_type, $tariff['sms_quantity'], $tariff['monthly_price'], $year_price, $from_date, $to_date);
            }
            $vars = [
                'tariff'         => $tariff,
                'transactionid'  => $transactionid,
                'subscriptionid' => $subscriptionid,
                'due_price'      => $due_price,
                'from_date'      => $from_date,
                'to_date'        => $to_date,
            ];
            $this->view->render($vars);
        }
    }
    public function paymentAction()
    {
        $this->isLogin();
        $transaction_history = $this->model->get_transaction_history($this->id, true);
        $vars                = [
            'transaction_history' => $transaction_history,
        ];
        $this->view->render($vars);
    }
    public function verify_transactionAction()
    {
        $this->isLogin();
        $tsid          = filter_input(INPUT_POST, 'tsid');
        $sbid          = filter_input(INPUT_POST, 'sbid');
        $phone         = filter_input(INPUT_POST, 'phone');
        $amount        = filter_input(INPUT_POST, 'amount');
        $transactionid = filter_input(INPUT_POST, 'transactionid');
        $isVerified    = $this->model->verify_transaction();
        echo $isVerified;
    }
    public function quickstartAction()
    {
        $this->isLogin();
        $customer = $this->model->get_customer_info($this->id);
        $vars     = [
            'customer' => $customer,
        ];
        $this->view->render($vars);
    }
    public function supportAction()
    {
        $this->isLogin();
        //$customer   = $this->model->get_customer_info($this->id);
        $vars = [
            //   'customer' => $customer,
        ];
        $this->view->render($vars);
    }
    public function logoutAction()
    {
        $this->model->delete_key($this->id, self::ISADMIN);
        session_destroy();
        $this->view->redirect('/');
    }
}
