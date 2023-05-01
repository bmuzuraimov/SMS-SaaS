<?php
namespace application\models;

use application\core\Model;

class Admin extends Model
{
    public function block_doctor($doctorid)
    {
        $params = [
            'doctorid' => $doctorid,
        ];
        $result = $this->db->query('UPDATE doctor_users SET valid = (1-valid) WHERE id = :doctorid', $params);
        return $result;
    }
    public function delete_hospital($hospitalid)
    {
        $params = [
            'hospitalid' => $hospitalid,
        ];
        $result = $this->db->query('DELETE FROM hospitals_database WHERE id = :hospitalid', $params);
        $this->db->query('DELETE FROM doctor_users WHERE hospitalid = :hospitalid', $params);
        return $result;
    }
    public function get_doctors_by_hospital($hospitalid)
    {
        $params = [
            'hospitalid' => $hospitalid,
        ];
        $result = $this->db->rows('SELECT id, valid, isHead, fname, lname, phone FROM doctor_users WHERE hospitalid = :hospitalid', $params);
        return $result;
    }
    public function total_hospitals(){
        $result = $this->db->row('SELECT COUNT(*) FROM hospitals_database');
        return $result[0];
    }
    public function total_patients(){
        $result = $this->db->row('SELECT COUNT(*) FROM patients_database');
        return $result[0];
    }
    public function get_patient_growth()
    {
        $result = $this->db->rows('SELECT * FROM ( SELECT patients_database.id, DATE_FORMAT(DATE( patients_database.sickDate ), "%d-%m-%Y") as day, COUNT( patients_database.id ) AS patient FROM patients_database GROUP BY DATE( patients_database.sickDate ) ORDER BY day DESC LIMIT 7 ) sub ORDER BY day ASC');
        return $result;
    }
    public function add_post($title, $author, $profile_imgage, $text, $category)
    {
        $params = [
            'title'       => $title,
            'author'      => $author,
            'profile_img' => $profile_imgage,
            'text'        => $text,
            'category'    => $category,
        ];
        $result = $this->db->query('INSERT INTO articles(title, author, profile_img, text, category) VALUES (:title, :author, :profile_img, :text, :category)', $params);
        return $result;
    }
    public function update_post($postid, $title, $author, $profile_img, $text, $category)
    {
        if (is_null($profile_img)) {
            $params = [
                'postid'  => $postid,
                'title'    => $title,
                'author'   => $author,
                'text'     => $text,
                'category' => $category,
            ];
            $result = $this->db->query('UPDATE articles SET title = :title, author = :author, text = :text, category = :category WHERE id = :postid', $params);
        } else {
            $params = [
                'postid'     => $postid,
                'title'       => $title,
                'author'      => $author,
                'profile_img' => $profile_img,
                'text'        => $text,
                'category'    => $category,
            ];
            $result = $this->db->query('UPDATE articles SET title = :title, author = :author, profile_img = :profile_img, text = :text, category = :category WHERE id = :postid', $params);
        }
        return $result;
    }
    public function delete_post($postid)
    {
        $params = [
            'id' => $postid,
        ];
        $result = $this->db->query('DELETE FROM articles WHERE id = :id', $params);
        return $result;
    }
    public function publish_post($postid, $publish)
    {
        $params = [
            'id'      => $postid,
            'publish' => $publish,
        ];
        $result = $this->db->query('UPDATE articles SET published = :publish WHERE id = :id', $params);
        return $result;
    }
    public function get_inbox()
    {
        $result = $this->db->rows('SELECT id, phone, message, date, ip_address FROM inbox ORDER BY date ASC');
        return $result;
    }
    public function block_user($userid, $block)
    {
        $params = [
            'user_id' => $userid,
            'valid'   => $block,
        ];
        $result = $this->db->query('UPDATE admin SET valid = :valid WHERE id=:user_id', $params);
        return $result;
    }
    public function delete_user($userid)
    {
        $params = [
            'userid' => $userid,
        ];
        $this->db->query('DELETE FROM admin WHERE id=:userid', $params);
    }
    public function add_user($super, $valid, $username, $temp_password, $password)
    {
        $params = [
            'super'         => $super,
            'valid'         => $valid,
            'username'      => $username,
            'temp_password' => $temp_password,
            'password'      => $password,
        ];
        $result = $this->db->query('INSERT INTO admin (super, valid, username, temp_password, password) VALUES (:super, :valid, :username, :temp_password, :password)', $params);
        return $result;
    }
    public function get_users()
    {
        $result = $this->db->rows('SELECT id, super, valid, username, temp_password FROM admin WHERE valid = 1');
        return $result;
    }
    public function get_user_requests()
    {
        $result = $this->db->rows('SELECT id, super, username, temp_password FROM admin WHERE valid = 0');
        return $result;
    }
    public function get_posts($postid = null)
    {
        if (!is_null($postid)) {
            $params = [
                'postid' => $postid,
            ];
            $result = $this->db->row('SELECT id, published, category, visited, date, author, profile_img, title, text FROM articles WHERE id=:postid', $params);
        } else {
            $result = $this->db->rows('SELECT id, published, category, visited, date, author, profile_img, title, text FROM articles');
        }
        return $result;
    }
    public function get_user($id)
    {
        $params = [
            'id' => $id,
        ];
        $result = $this->db->row('SELECT id, super, username, temp_password FROM admin WHERE id = :id', $params);
        return $result;
    }
    public function add_message($carrier, $phone, $sms)
    {
        $params = [
            'carrier' => $carrier,
            'phone'   => $phone,
            'sms'     => $sms,
        ];
        $result = $this->db->rows('INSERT INTO message (carrier, phone, sms) VALUES (:carrier, :phone, :sms)', $params);
        return $result;
    }
    public function get_valid_hospitals($valid)
    {
        if ($valid === true) {
            $result = $this->db->rows('SELECT * FROM hospitals_database WHERE valid = 1');
        } else {
            $result = $this->db->rows('SELECT * FROM hospitals_database WHERE valid = 0');
        }
        return $result;
    }
    public function validate_hospital($hospitalid)
    {
        $params = [
            'hospitalid' => $hospitalid,
        ];
        $this->db->query('UPDATE hospitals_database SET valid = NOT valid WHERE id = :hospitalid', $params);
        $this->db->query('UPDATE doctor_users SET valid = 1 WHERE hospitalid = :hospitalid', $params);
    }
}
