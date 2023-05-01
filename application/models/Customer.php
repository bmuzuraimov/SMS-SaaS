<?php
namespace application\models;

use application\core\Model;

class Customer extends Model
{
    public function get_customer_info($customerid)
    {
        $params = [
            'customerid' => $customerid,
        ];
        $result = $this->db->row('SELECT `api_key`, `fname`, `lname`, `email`, `company`, `website`, `address`, `postcode`, `city`, `state`, `phone` FROM customers WHERE id = :customerid', $params);
        return $result;
    }
    public function get_contacts($customerid, $contactid = null)
    {
        if (!is_null($contactid)) {
            $params = [
                'contactid'  => $contactid,
            ];
            $result = $this->db->row('SELECT * FROM `contacts` WHERE id=:contactid', $params);
        } else {
            $params = [
                'customerid' => $customerid,
            ];
            $result = $this->db->rows('SELECT * FROM `contacts` WHERE customerid = :customerid', $params);
        }
        return $result;
    }
    public function add_group($customerid, $group_key, $group_name, $group_notes)
    {
        $params = [
            'customerid'  => $customerid,
            'group_key'   => $group_key,
            'group_name'  => $group_name,
            'group_notes' => $group_notes,
        ];
        $this->db->query('INSERT INTO `groups`(`customerid`, `group_key`, `name`, `notes`) VALUES (:customerid, :group_key, :group_name, :group_notes)', $params);
    }
    public function add_contact($customerid, $groupid, $fname, $lname, $phone)
    {
        $params = [
            'customerid' => $customerid,
            'groupid'    => $groupid,
            'fname'      => $fname,
            'lname'      => $lname,
            'phone'      => $phone,
        ];
        $this->db->query('INSERT INTO `contacts`(`customerid`, `groupid`, `fname`, `lname`, `phone`) VALUES (:customerid, :groupid, :fname, :lname, :phone)', $params);
    }
    public function transaction_exists($customerid)
    {
        $params = [
            'customerid' => $customerid,
        ];
        $result = $this->db->row('SELECT id FROM transactions WHERE `customerid`=:customerid AND status = "incomplete"', $params);
        return $result;
    }
    public function verify_transaction()
    {
    }
    public function add_new_transaction($customerid, $product, $amount, $status)
    {
        $params = [
            'customerid' => $customerid,
            'product'    => $product,
            'amount'     => $amount,
            'status'     => $status,
        ];
        $transactionid = $this->db->query_lastid('INSERT INTO `transactions`(`customerid`, `product`, `amount`, `status`) VALUES (:customerid, :product, :amount, :status)', $params);
        return $transactionid;
    }
    public function update_transaction($transactionid, $product, $amount, $created_at)
    {
        $params = [
            'transactionid' => $transactionid,
            'product'       => $product,
            'amount'        => $amount,
            'created_at'    => $created_at,
        ];
        $this->db->query('UPDATE `transactions` SET `product`=:product,`amount`=:amount,`created_at`=:created_at WHERE id=:transactionid', $params);
    }
    public function update_account($customerid, $email, $fname, $lname, $address, $postcode, $city, $state, $company, $website)
    {
        $params = [
            'fname'      => $fname,
            'lname'      => $lname,
            'email'      => $email,
            'company'    => $company,
            'website'    => $website,
            'address'    => $address,
            'postcode'   => $postcode,
            'city'       => $city,
            'state'      => $state,
            'customerid' => $customerid,
        ];
        $this->db->query('UPDATE `customers` SET `fname`=:fname,`lname`=:lname,`email`=:email,`company`=:company,`website`=:website,`address`=:address,`postcode`=:postcode,`city`=:city,`state`=:state WHERE `id`=:customerid', $params);
    }
    public function add_new_subscription($customerid, $transactionid, $subscription_type, $deviceid, $month_requests, $month_price, $year_price, $from_date, $to_date)
    {
        $params = [
            'customerid'        => $customerid,
            'transactionid'     => $transactionid,
            'subscription_type' => $subscription_type,
            'deviceid'          => $deviceid,
            'month_requests'    => $month_requests,
            'month_price'       => $month_price,
            'year_price'        => $year_price,
            'from_date'         => $from_date,
            'to_date'           => $to_date,
        ];
        $result = $this->db->query_lastid('INSERT INTO `subscriptions`(`customerid`, `transactionid`, `subscription_type`, `deviceid`, `month_requests`, `month_price`, `year_price`, `from_date`, `to_date`) VALUES (:customerid, :transactionid, :subscription_type, :deviceid, :month_requests, :month_price, :year_price, :from_date, :to_date)', $params);
        return $result;
    }
    public function update_subscription($zero = false, $customerid = null, $transactionid = null, $subscription_type = null, $deviceid = null, $month_requests = null, $month_price = null, $year_price = null, $from_date = null, $to_date = null)
    {
        if ($zero == false) {
            $params = [
                'transactionid'     => $transactionid,
                'subscription_type' => $subscription_type,
                'deviceid'          => $deviceid,
                'month_requests'    => $month_requests,
                'month_price'       => $month_price,
                'year_price'        => $year_price,
                'from_date'         => $from_date,
                'to_date'           => $to_date,
            ];
            $this->db->query('UPDATE `subscriptions` SET `subscription_type`=:subscription_type,`deviceid`=:deviceid, `month_requests`=:month_requests, `month_price`=:month_price,`year_price`=:year_price,`from_date`=:from_date,`to_date`=:to_date WHERE transactionid=:transactionid', $params);
            $params = [
                'customerid'    => $customerid,
                'transactionid' => $transactionid,
            ];
            $result = $this->db->row('SELECT `id` FROM `subscriptions` WHERE customerid = :customerid AND transactionid = :transactionid', $params);
            return $result['id'];
        } else {
            $params = [
                'customerid' => $customerid,
                'status'     => "incomplete",
            ];
            $this->db->query('DELETE transactions, subscriptions FROM transactions INNER JOIN subscriptions WHERE transactions.id = subscriptions.transactionid AND transactions.customerid = :customerid AND transactions.status = :status', $params);
        }
    }
    public function contact_to_group($contactid, $group_key)
    {
        $params = [
            'contactid' => $contactid,
        ];
        $result = $this->db->row('SELECT `groupid` FROM `contacts` WHERE id = :contactid', $params);
        if (isset($result['groupid'])) {
            $groups = explode(",", $result['groupid']);
            if (in_array($group_key, $groups)) {
                $groupid = $result['groupid'];
                $params  = [
                    'contactid' => $contactid,
                    'groupid'   => $groupid,
                ];
            } else {
                $groupid = $result['groupid'] . "," . $group_key;
                $params  = [
                    'contactid' => $contactid,
                    'groupid'   => $groupid,
                ];
            }
        } else {
            $params = [
                'contactid' => $contactid,
                'groupid'   => $group_key,
            ];
        }
        $result = $this->db->query('UPDATE `contacts` SET `groupid`=:groupid WHERE id = :contactid', $params);
    }
    public function get_groups($customerid, $groupid)
    {
        if (!is_null($groupid)) {
            $params = [
                'groupid' => $groupid,
            ];
            $result = $this->db->row('SELECT * FROM `groups` WHERE id = :groupid', $params);
        } else {
            $params = [
                'customerid' => $customerid,
            ];
            $result = $this->db->rows('SELECT * FROM `groups` WHERE customerid = :customerid', $params);
        }
        return $result;
    }
    public function get_subscription_info($customerid)
    {
        $params = [
            'customerid' => $customerid,
        ];
        $result = $this->db->row('SELECT `subscription_type`, `deviceid`, `total_requests`, `month_requests`, `used_requests`, `month_price`, `year_price`, `from_date`, `to_date` FROM subscriptions WHERE customerid = :customerid ORDER BY id DESC LIMIT 1', $params);
        return $result;
    }
    public function get_tariffs($tariffid = null)
    {
        if (is_null($tariffid)) {
            $result = $this->db->rows('SELECT * FROM `tariffs`');
            return $result;
        } else {
            $params = [
                'tariffid' => $tariffid,
            ];
            $result = $this->db->row('SELECT * FROM `tariffs` WHERE id=:tariffid', $params);
            return $result;
        }
    }
    public function get_customer_messages($customerid, $from_date)
    {
        $params = [
            'customerid' => $customerid,
            'from_date'  => $from_date,
        ];
        $result = $this->db->rows('SELECT `phone`, `sms`, `created_date` FROM `messages` WHERE `customerid`=:customerid AND `created_date`>:from_date', $params);
        return $result;
    }
    public function get_transaction_history($customerid, $full = true)
    {
        if ($full === true) {
            $params = [
                'customerid' => $customerid,
            ];
            $result = $this->db->rows('SELECT transactions.*, tariffs.id as tariffid, tariffs.monthly_price, tariffs.yearly_discount FROM transactions INNER JOIN tariffs ON transactions.product = tariffs.name WHERE transactions.customerid = :customerid AND transactions.status IN ("success", "incomplete")', $params);
        } else {
            $params = [
                'customerid' => $customerid,
            ];
            $result = $this->db->row_no_num('SELECT * FROM transactions WHERE customerid=:customerid', $params);
        }
        return $result;
    }
}
