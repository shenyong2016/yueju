<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class User_model extends CI_Model{

  public function check_username($username){
    return $this -> db -> get_where('t_user', array(
      'username' => $username
    )) -> row();
  }

  public function check_password($password){
    return $this -> db -> get_where('t_user', array(
      'password' => $password
    )) -> row();
  }

  public function check_login($username, $password){
    return $this -> db -> get_where('t_user', array(
      'username' => $username, 
      'password' => $password
    )) -> row();
  }

  public function save_user($username, $password){
    $this -> db -> insert('t_user', array(
      'username' => $username,
      'password' => $password
    ));
    return $this -> db -> affected_rows();
  }

  public function update_user($user_id,$real_name,$sex,$ID,$head_img){
    $this -> db -> where('user_id', $user_id);
        $this -> db -> update('t_user', array(
          'real_name' => $real_name,
          'sex' => $sex,
          'ID_number' => $ID,
          'head_img' => $head_img,
        ));
    return $this -> db -> affected_rows();
  }
  
  public function get_user_by_user_id($user_id){
    return $this -> db -> get_where('t_user', array(
      'user_id' => $user_id
    )) -> row();
  }

  public function update_pass_by_user_id($new_pass,$user_id){
    $this -> db -> where('user_id', $user_id);
        $this -> db -> update('t_user', array(
          'password' => $new_pass
        ));
    return $this -> db -> affected_rows();
  }

  // 查询悦居信息
  public function get_yueju(){
    return $this -> db -> get_where('t_yueju', array(
      'yueju_id' => 1
    )) -> row();
  }







}