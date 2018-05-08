<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Evaluate_model extends CI_Model {
  public function save_evaluation($user_id,$clean,$traffic,$manage,$facility,$house_id,$order_num){
    $this -> db -> insert('t_order_evaluation', array(
      'user_id' => $user_id,
      'clean_val' => $clean,
      'traffic_val' => $traffic,
      'manage_val' => $manage,
      'facility_val' => $facility,
      'house_id' => $house_id,
      'order_num' => $order_num,
    ));
    return $this -> db -> affected_rows();
  }

  public function get_evaluation($order_num){
    return $this -> db -> get_where('t_order_evaluation', array(
      'order_num' => $order_num      
    )) -> row();
  }







}