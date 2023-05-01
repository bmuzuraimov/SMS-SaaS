<?php
namespace application\core;

use application\lib\Db;

abstract class Model
{
    public $db;

    public function __construct()
    {
        $this->db = new Db;
    }
    public function get_client_ip()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }
    public function delete_key($userid, $isAdmin)
    {
        $params = [
            'userid'  => $userid,
            'isAdmin' => $isAdmin,
        ];
        $result = $this->db->query('DELETE FROM user_sessions WHERE userid = :userid AND isAdmin = :isAdmin', $params);
        return $result;
    }

    public function get_key($userid, $isAdmin)
    {
        $params = [
            'userid'  => $userid,
            'isAdmin' => $isAdmin,
        ];
        $result = $this->db->row('SELECT userid, isAdmin, authKey FROM user_sessions WHERE userid = :userid AND isAdmin = :isAdmin', $params);
        return $result;
    }
    public function validate_api($api_key)
    {
        $params = [
            'api_key'  => $api_key,
        ];
        $result = $this->db->row('SELECT customers.id, subscriptions.month_requests, subscriptions.used_requests FROM customers INNER JOIN subscriptions ON customers.id = subscriptions.customerid WHERE customers.api_key = :api_key', $params);
        return $result;
    }
    public function add_message($customerid = null, $carrier, $phone, $message, $created_date = null)
    {
        $params = [
            'customerid' => $customerid,
            'carrier' => $carrier,
            'phone'   => $phone,
            'sms' => $message,
        ];
        $this->db->row('INSERT INTO `messages`(`customerid`, `carrier`, `phone`, `sms`) VALUES (:customerid, :carrier, :phone, :sms)', $params);
        if (is_numeric($customerid)) {
            $params = [
                'customerid' => $customerid,
            ];
            $this->db->row('UPDATE `subscriptions` SET total_requests=total_requests+1, used_requests=used_requests+1 WHERE customerid=:customerid', $params);
        }
    }  
    public function get_carrier($phone)
    {
        $extention = substr($phone, 0, 4);
        $beeline   = array('0770', '0771', '0772', '0773', '0774', '0775', '0776', '0777', '0778', '0779', '0220', '0221', '0222', '0225', '0227');
        $megacom   = array('0999', '0755', '0550', '0551', '0552', '0553', '0554', '0555', '0556', '0557', '0559');
        $o         = array('0500', '0501', '0502', '0504', '0505', '0507', '0508', '0509', '0700', '0701', '0702', '0703', '0704', '0705', '0706', '0707', '0708', '0709');
        if (in_array($extention, $beeline)) {
            return '1';
        }
        else if (in_array($extention, $megacom)) {
            return '2';
        }
        else if (in_array($extention, $o)) {
            return '3';
        }
        else {
            return false;
        }
    }
}
