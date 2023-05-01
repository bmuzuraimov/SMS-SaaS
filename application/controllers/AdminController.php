<?php
namespace application\controllers;

use application\core\Controller;

if (isset($_SESSION['user'])) {
    $GLOBALS['$ID'] = $_SESSION['user'];
} else {
    $GLOBALS['$ID'] = false;
}

class AdminController extends Controller
{
    protected $id;
    const ISADMIN = 1;
    private function setId()
    {
        if ($GLOBALS['$ID'] === false) {
            $this->model->delete_key($this->id, self::ISADMIN);
            session_destroy();
            $this->view->redirect('/');
        } else {
            $this->id = $GLOBALS['$ID'];
        }
    }
    private function isLogin()
    {
        $this->setId();
        $auth = $this->model->get_key($this->id, self::ISADMIN);
        if ($this->id != $auth['userid'] || $_SESSION['authkey'] != $auth['authKey'] || $auth['isAdmin'] != self::ISADMIN) {
            $this->model->delete_key($this->id, self::ISADMIN);
            session_destroy();
            $this->view->redirect('/');
        }
    }
    public function homeAction()
    {
        $this->isLogin();
        $user            = $this->model->get_user($this->id);
        $total_hospitals = $this->model->total_hospitals();
        $total_patients = $this->model->total_patients();
        $patients_growth = $this->model->get_patient_growth();
        $daily_patients = end($patients_growth);
        $daily_patients = $daily_patients['patient'];
        $vars            = [
            'user'            => $user,
            'total_hospitals' => $total_hospitals,
            'total_patients' => $total_patients,
            'patients_growth' => $patients_growth,
            'daily_patients' => $daily_patients,
        ];
        $this->view->render($vars);
    }
    public function hospitalsAction()
    {
        $this->isLogin();
        $user              = $this->model->get_user($this->id);
        $hospitals         = $this->model->get_valid_hospitals(true);
        $unvalid_hosptials = $this->model->get_valid_hospitals(false);
        $vars              = [
            'user'              => $user,
            'hospitals'         => $hospitals,
            'unvalid_hosptials' => $unvalid_hosptials,
        ];
        $this->view->render($vars);
    }
    public function view_hospitalAction()
    {
        $this->isLogin();
        $hospitalid = filter_input(INPUT_GET, 'hospitalid');
        if (isset($hospitalid)) {
            $hospital    = $this->model->get_hospital_info($hospitalid, null);
            if (!empty($hospital)) {
                $user    = $this->model->get_user($this->id);
                $doctors = $this->model->get_doctors_by_hospital($hospitalid);
                //$patients = $this->model->get_patients_by_hospital($hospitalid);
                $vars = [
                    'hospital' => $hospital,
                    'doctors'  => $doctors,
                    //'patients'  => $patients,
                    'user'     => $user,
                ];
                $this->view->render($vars);
            } else {
                $this->view->redirect('/admin/hospitals');
            }

        } else {
            $this->view->redirect('/admin/hospitals');
        }
    }
    public function edit_hospitalAction()
    {
        $this->isLogin();
        $user = $this->model->get_user($this->id);
        $hospitalid = filter_input(INPUT_GET, 'hospitalid');
        if (isset($hospitalid)) {
            $hospital    = $this->model->get_hospital_info($hospitalid, null);
            if (!empty($hospital)) {
                $user = $this->model->get_user($this->id);
                $vars = [
                    'hospital' => $hospital,
                    'user'     => $user,
                ];
                $this->view->render($vars);
            } else {
                $this->view->redirect('/admin/hospitals');
            }

        } else {
            $this->view->redirect('/admin/hospitals');
        }
    }
    public function update_hospitalAction()
    {
        $this->isLogin();
        if (isset($_POST)) {
            $uik_id    = filter_input(INPUT_POST, 'uik_id');
            $territory = filter_input(INPUT_POST, 'territory');
            $uik_name  = filter_input(INPUT_POST, 'uik_name');
            $number    = filter_input(INPUT_POST, 'number');
            $address   = filter_input(INPUT_POST, 'address');
            $voters    = filter_input(INPUT_POST, 'voters');
            $this->model->update_uik($uik_id, $territory, $uik_name, $number, $address, $voters);
            $this->view->redirect('/admin/edit_uik?uik_id=' . $uik_id . '&status=saved');
        } else {
            $this->view->redirect('/admin/uiks');
        }
    }
    public function approve_hospitalAction()
    {
        $this->isLogin();
        $hospitalid = filter_input(INPUT_GET, 'hospitalid');
        if (isset($hospitalid)) {
            $this->model->validate_hospital($hospitalid);
            $this->view->redirect('/admin/hospitals');
        } else {
            $this->view->redirect('/admin/hospitals');
        }
    }
    public function delete_hospitalAction()
    {
        $this->isLogin();
        $hospitalid = filter_input(INPUT_GET, 'hospitalid');
        if (isset($hospitalid)) {
            $this->model->delete_hospital($hospitalid);
            $this->view->redirect('/admin/hospitals');
        } else {
            $this->view->redirect('/admin/hospitals');
        }
    }
    public function delete_patientAction()
    {
        $this->isLogin();
        $patientid = filter_input(INPUT_GET, 'patientid');
        if (isset($patientid)) {
            $this->model->delete_patient($patientid);
            $this->view->redirect('/admin/patients');
        } else {
            $this->view->redirect('/admin/hospitals');
        }
    }
    public function postsAction()
    {
        $this->isLogin();
        $user  = $this->model->get_user($this->id);
        $posts = $this->model->get_posts();
        $vars  = [
            'posts' => $posts,
            'user'  => $user,
        ];
        $this->view->render($vars);
    }
    public function edit_postAction()
    {
        $this->isLogin();
        $postid = filter_input(INPUT_GET, 'postid');
        if (isset($postid)) {
            $post    = $this->model->get_posts($postid);
            if ($post != false) {
                $user = $this->model->get_user($this->id);
                $vars = [
                    'post' => $post,
                    'user' => $user,
                ];
                $this->view->render($vars);
            } else {
                $this->view->redirect('/admin/posts');
            }
        } else {
            $this->view->redirect('/admin/posts');
        }
    }
    public function update_postAction()
    {
        $this->isLogin();
        if (isset($_POST)) {
            $postid  = filter_input(INPUT_POST, 'postid');
            $title    = filter_input(INPUT_POST, 'title');
            $author   = filter_input(INPUT_POST, 'author');
            $text     = filter_input(INPUT_POST, 'body');
            $category = filter_input(INPUT_POST, 'category');
            if ($_FILES["profile_image"]["name"] != '') {
                $allowed_ext = array("jpg", "png");
                $tmp         = explode('.', $_FILES["profile_image"]["name"]);
                $ext         = end($tmp);
                $ext = strtolower($ext);
                if (in_array($ext, $allowed_ext)) {
                    $image_name  = md5(rand()) . "." . $ext;
                    $image_path  = "/public/images/posts/" . $image_name;
                    $target_path = "/xampp/htdocs/public/images/posts/" . $image_name;
                    move_uploaded_file($_FILES["profile_image"]['tmp_name'], $target_path);
                    $this->model->update_post($postid, $title, $author, $image_path, $text, $category);
                } else {
                    $this->model->update_post($postid, $title, $author, null, $text, $category);
                }

            } else {
                $this->model->update_post($postid, $title, $author, null, $text, $category);
            }
            $this->view->redirect('/admin/posts');
        } else {
            $this->view->redirect('/admin/posts');
        }
    }
    public function delete_postAction()
    {
        $this->isLogin();
        $postid = filter_input(INPUT_GET, 'postid');
        if (isset($postid)) {
            $this->model->delete_post($postid);
            $this->view->redirect('/admin/posts');
        } else {
            $this->view->redirect('/admin/posts');
        }
    }
    public function publish_postAction()
    {
        $this->isLogin();
        $postid    = filter_input(INPUT_GET, 'postid');
        $published = filter_input(INPUT_GET, 'published');
        if (isset($postid) && isset($published)) {
            $this->model->publish_post($postid, $published);
            $this->view->redirect('/admin/posts');
        } else {
            $this->view->redirect('/admin/posts');
        }
    }
    public function create_postAction()
    {
        $this->isLogin();
        if (isset($_POST)) {
            $title  = filter_input(INPUT_POST, 'title');
            $author = filter_input(INPUT_POST, 'author');
            if ($_FILES["profile_image"]["name"] != '') {
                $allowed_ext = array("jpg", "png");
                $tmp         = explode('.', $_FILES["profile_image"]["name"]);
                $ext         = end($tmp);
                $ext = strtolower($ext);
                if (in_array($ext, $allowed_ext)) {
                    $image_name = md5(rand()) . "." . $ext;
                    $image_path = "/public/images/posts/" . $image_name;
                    $target_path = "/xampp/htdocs/public/images/posts/" . $image_name;
                    move_uploaded_file($_FILES["profile_image"]["tmp_name"], $target_path);
                } else {
                    $image_path = "/public/images/posts/article_profile.jpg";
                }

            } else {
                $image_path = "/public/images/posts/article_profile.jpg";
            }
            $text     = filter_input(INPUT_POST, 'body');
            $category = filter_input(INPUT_POST, 'category');
            $result   = $this->model->add_post($title, $author, $image_path, $text, $category);
        }
        $user = $this->model->get_user($this->id);
        $vars = [
            'user' => $user,
        ];
        $this->view->render($vars);
    }
    public function usersAction()
    {
        $this->isLogin();
        $user          = $this->model->get_user($this->id);
        $users         = $this->model->get_users();
        $user_requests = $this->model->get_user_requests();
        $vars          = [
            'user'          => $user,
            'users'         => $users,
            'user_requests' => $user_requests,
        ];
        $this->view->render($vars);
    }
    public function block_userAction()
    {
        $this->isLogin();
        $userid = filter_input(INPUT_GET, 'userid');
        if (isset($userid)) {
            $block   = filter_input(INPUT_GET, 'block');
            if (isset($block)) {
                $this->model->block_user($userid, $block);
                $this->view->redirect('/admin/users');
            } else {
                $this->view->redirect('/admin/users');
            }
        } else {
            $this->view->redirect('/admin/users');
        }
    }
    public function delete_userAction()
    {
        $this->isLogin();
        $userid = filter_input(INPUT_GET, 'userid');
        if (isset($userid)) {
            $this->model->delete_user($userid);
            $this->view->redirect('/admin/users');
        } else {
            $this->view->redirect('/admin/users');
        }
    }
    public function create_userAction()
    {
        $this->isLogin();
        if (isset($_POST)) {
            $username      = filter_input(INPUT_POST, 'username');
            $super         = filter_input(INPUT_POST, 'super');
            $temp_password = $this->model->get_random_passwd();
            $password      = password_hash($temp_password, PASSWORD_DEFAULT);
            $result        = $this->model->add_user($super, 1, $username, $temp_password, $password);
        }
        $user = $this->model->get_user($this->id);
        $vars = [
            'user' => $user,
        ];
        $this->view->render($vars);
    }
    public function message_referalsAction()
    {
        $this->isLogin();
        if (isset($_POST)) {
            $message = filter_input(INPUT_POST, 'message');
            $message = mb_strtolower($message);
            //$referal_info = $this->model->get_referal_phones();
            foreach ($referal_info as $info) {
                $extention = substr($info['phone'], 0, 4);
                $beeline   = array('0770', '0771', '0772', '0773', '0774', '0775', '0776', '0777', '0778', '0779', '0220', '0221', '0222', '0225', '0227');
                $megacom   = array('0999', '0755', '0550', '0551', '0552', '0553', '0554', '0555', '0556', '0557', '0559');
                $o         = array('0500', '0501', '0502', '0504', '0505', '0507', '0508', '0509', '0700', '0701', '0702', '0703', '0704', '0705', '0706', '0707', '0708', '0709');
                if (in_array($extention, $beeline)) {
                    $carrier = 1;
                } elseif (in_array($extention, $megacom)) {
                    $carrier = 2;
                } else {
                    $carrier = 3;
                }
                $sms = $info['fname'] . " " . $info['lname'] . ", " . $message;
                $this->model->add_message($carrier, $info['phone'], $sms);
            }
        }
        $user = $this->model->get_user($this->id);
        $vars = [
            'user' => $user,
        ];
        $this->view->render($vars);
    }
    public function message_votersAction()
    {
        $this->isLogin();
        if (isset($_POST)) {
            $message      = filter_input(INPUT_POST, 'message');
            $message      = mb_strtolower($message);
            $referal_info = $this->model->get_voter_phones();
            foreach ($referal_info as $info) {
                $extention = substr($info['phone'], 0, 4);
                $beeline   = array('0770', '0771', '0772', '0773', '0774', '0775', '0776', '0777', '0778', '0779', '0220', '0221', '0222', '0225', '0227');
                $megacom   = array('0999', '0755', '0550', '0551', '0552', '0553', '0554', '0555', '0556', '0557', '0559');
                $o         = array('0500', '0501', '0502', '0504', '0505', '0507', '0508', '0509', '0700', '0701', '0702', '0703', '0704', '0705', '0706', '0707', '0708', '0709');
                if (in_array($extention, $beeline)) {
                    $carrier = 1;
                } elseif (in_array($extention, $megacom)) {
                    $carrier = 2;
                } else {
                    $carrier = 3;
                }
                $sms = $info['fname'] . " " . $info['lname'] . ", " . $message;
                $this->model->add_message($carrier, $info['phone'], $sms);
            }
        }
        $user = $this->model->get_user($this->id);
        $vars = [
            'user' => $user,
        ];
        $this->view->render($vars);
    }
    public function inboxAction()
    {
        $this->isLogin();
        $messages = $this->model->get_inbox();
        $user     = $this->model->get_user($this->id);
        $vars     = [
            'user'     => $user,
            'messages' => $messages,
        ];
        $this->view->render($vars);
    }
    public function logoutAction()
    {
        $this->setId();
        $this->model->delete_key($this->id, self::SERVICE);
        session_destroy();
        $this->view->redirect('/');
    }
}
