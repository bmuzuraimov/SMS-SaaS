<?php
namespace application\models;

use application\core\Model;

class Sign extends Model
{
    public function isExist($userid, $isAdmin)
    {
        $params = [
            'userid'  => $userid,
            'isAdmin' => $isAdmin,
        ];
        $result = $this->db->row('SELECT EXISTS(SELECT * FROM user_sessions WHERE userid = :userid AND isAdmin = :isAdmin)', $params);
        return $result[0];
    }

    public function setKey($userid, $keyAuth, $isAdmin, $log_ip)
    {
        $params = [
            'userid'  => $userid,
            'keyAuth' => $keyAuth,
            'isAdmin' => $isAdmin,
            'log_ip'  => $log_ip,
        ];
        $result = $this->db->query('INSERT INTO user_sessions (isAdmin, userid, authKey, log_ip) VALUES (:isAdmin, :userid, :keyAuth, :log_ip)', $params);
        return $result;
    }

    public function updateKey($userid, $keyAuth, $isAdmin, $log_ip)
    {
    //both
        $params = [
            'isAdmin' => $isAdmin,
            'keyAuth' => $keyAuth,
            'userid'  => $userid,
            'log_ip'  => $log_ip,
        ];
        $result = $this->db->query('UPDATE user_sessions SET isAdmin = :isAdmin, authKey = :keyAuth, log_ip = :log_ip WHERE userid = :userid', $params);
        return $result;
    }
    public function isValid($hospitalid)
    {
        $params = [
            'hospitalid' => $hospitalid,
        ];
        $result = $this->db->row('SELECT valid FROM hospitals_database WHERE id = :hospitalid', $params);
        return $result;
    }
    public function customer_exists($id=null, $phone=null)
    {
        if (!is_null($id)) {
            $params = [
                'id' => $id,
            ];
            $result = $this->db->row('SELECT EXISTS(SELECT * FROM customers WHERE id = :id AND valid = 0)', $params);
            return $result[0];
        } elseif (!is_null($phone)) {
            $params = [
                'phone' => $phone,
            ];
            $result = $this->db->row('SELECT EXISTS(SELECT * FROM customers WHERE phone = :phone)', $params);
            return $result[0];
        } else {
            return true; 
        }
    }
    public function add_customer($api_key, $verification_code, $fname, $lname, $website, $phone, $password, $ip)
    {
        $password = password_hash($password, PASSWORD_DEFAULT);
        $params   = [
            'api_key' => $api_key,
            'verification_code' => $verification_code,
            'fname'             => $fname,
            'lname'             => $lname,
            'website'           => $website,
            'phone'             => $phone,
            'password'          => $password,
            'ip'                => $ip,
        ];
        $this->db->query('INSERT INTO customers (api_key, verification_code, fname, lname, website, phone, password, ip) VALUES (:api_key, :verification_code, :fname, :lname, :website, :phone, :password, :ip)', $params);
        $param = [
            'phone' => $phone,
        ];
        $id = $this->db->row_no_num('SELECT id FROM customers WHERE phone = :phone', $param);
        return $id['id'];
    }
    public function validate_user($customerid, $verification_code)
    {
        $params = [
            'id' => $customerid,
            'verification_code' => $verification_code,
        ];
        $result = $this->db->row_no_num('SELECT EXISTS(SELECT * FROM customers WHERE id = :id AND verification_code = :verification_code) as isValid', $params);
        if ($result['isValid']==1) {
            $params1 = [
                'id' => $customerid,
            ];
            $this->db->query('UPDATE `customers` SET `valid`= 1 WHERE id = :id', $params1);
        }
        return $result['isValid'];
    }
}
