<?php
namespace application\models;

use application\core\Model;

class Main extends Model
{
    public function available_sms()
    {
        $result          = $this->db->row_no_num('SELECT `id`, `carrier`, `phone`, `sms` FROM `messages` WHERE sent=0 AND `created_date`<= NOW() ORDER BY id ASC LIMIT 1');
        $speed           = $this->db->row_no_num('SELECT COUNT(*) as speed FROM `messages` WHERE sent = 0');
        $speed           = ($speed['speed'] > 5) ? "100" : "500";
        $result['speed'] = $speed;
        return $result;
    }
    public function send_sms($id)
    {

        $params = [
            'id' => $id,
        ];
        $this->db->query('UPDATE messages SET sent = 1, sent_date = now() WHERE id = :id', $params);
    }
    public function is_sms_exists($id)
    {
        $params = [
            'id' => $id,
        ];
        $result = $this->db->row('SELECT EXISTS(SELECT * FROM messages WHERE id = :id)', $params);
        return $result[0];
    }
    public function transaction_exists($phone, $transactionid)
    {
        $params = [
            'phone'         => $phone,
            'transactionid' => $transactionid,
        ];
        $result = $this->db->row('SELECT `id`, `amount`, `paid_amount` FROM transactions WHERE phone = :phone AND transactionid = :transactionid', $params);
        return $result;
    }
    public function add_transaction($phone, $paid_amount, $currency, $transactionid, $status, $created_at)
    {
        $params = [
            'phone'         => $phone,
            'paid_amount'   => $paid_amount,
            'currency'      => $currency,
            'transactionid' => $transactionid,
            'status'        => $status,
            'created_at'    => $created_at,
        ];
        $this->db->query('INSERT INTO `transactions`(`phone`, `paid_amount`, `currency`, `transactionid`, `status`, `created_at`) VALUES (:phone, :paid_amount, :currency, :transactionid, :status, :created_at)', $params);
    }
    public function verify_transaction($id, $paid_amount, $status, $verified_at)
    {
        $params = [
            'id'          => $id,
            'paid_amount' => $paid_amount,
            'status'      => $status,
            'verified_at' => $verified_at,
        ];
        $this->db->query('UPDATE `transactions` SET `paid_amount` = `paid_amount`+:paid_amount, `status` = :status, `verified_at` = :verified_at WHERE `id` = :id AND `customerid` IS NOT NULL`', $params);
    }
}
