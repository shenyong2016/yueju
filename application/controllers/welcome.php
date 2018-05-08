<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {
  public function __construct(){
        parent::__construct();
        $this -> load -> model('user_model');
        $this -> load -> model('tour_model');
  }
  // 首页
	public function index(){
    $tour_list = $this -> tour_model -> get_tour_list_limit();
		$this -> load -> view('index', array(
      'tour_list' => $tour_list
    ));
  }
 

  // 检测用户名
  public function check_register(){
    $username = $this -> input -> get('username');
    $row = $this -> user_model -> check_username($username);
    if($row){
      echo 'success';
    }else{
      echo 'fail';
    }
  }

  // 注册用户
  public function register(){
    $username = $this -> input -> post('username');
    $password = $this -> input -> post('password');
    $row = $this -> user_model -> save_user($username, $password);
    if($row){
      $result = $this -> user_model -> check_login($username, $password);
      if($result){
        $this -> session -> set_userdata('loginedUser', $result);
        redirect('welcome/index');
      }  
    }else{
      echo 'fail';
    }
    
  }



  // 用户登录
  public function login(){
    $username = $this -> input -> post('username');
    $password = $this -> input -> post('password');
    
    $row = $this -> user_model -> check_login($username, $password);
    if($row){
      $this -> session -> set_userdata('loginedUser', $row);
      echo 'success';
    }else{
      echo 'fail';
    }
  }

  // 用户注销
  public function logout(){
    $this -> session -> unset_userdata('loginedUser');
    redirect('welcome/index');
  }

  // 用户中心
  public function user(){
    $this -> load -> view('person_center');
  }

  // 完善个人信息
  public function update_user_info(){
    $user_id = $this -> session -> userdata('loginedUser') -> user_id;
    $real_name = $this -> input -> get('realName');
    $sex = $this -> input -> get('sex');
    $ID = $this -> input -> get('ID');
    $head_img = $this -> input -> get('headImg');
    $row = $this -> user_model -> update_user($user_id,$real_name,$sex,$ID,$head_img);
    if($row > 0){
      $user = $this -> session -> userdata('loginedUser');
      $user -> real_name = $real_name;
      $user -> sex = $sex;
      $user -> ID_number = $ID;
      $user -> head_img = $head_img;
      $this -> session -> set_userdata('loginedUser', $user);
      echo 'success';
    }else{
      echo 'fail';
    }
  }

  // 获取登录人信息
  public function get_user_info(){
    $user_id = $this -> session -> userdata('loginedUser') -> user_id;
    $user = $this -> user_model -> get_user_by_user_id($user_id);    
    echo json_encode($user);
  }

  // 修改密码
  public function update_pass(){
    $new_pass = $this -> input -> get('newPass');
    $user_id = $this -> session -> userdata('loginedUser')->user_id;
    $row = $this -> user_model -> update_pass_by_user_id($new_pass,$user_id);
    if($row > 0){
      $user = $this -> session -> userdata('loginedUser');
      $user -> password = $new_pass;
      $this -> session -> set_userdata('loginedUser', $user);
      echo 'success';
    }else{
      echo 'fail';
    }
  }

  // 关于悦居
  public function about(){
    $yueju_info = $this -> user_model -> get_yueju();
    $this -> load -> view('about_yueju', array(
      'yueju_info' => $yueju_info
    ));
  }


}
