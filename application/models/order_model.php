<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Order_model extends CI_Model {

  public function get_finished_order($user_id,$offset,$limit){
    $sql = "select o.order_num,o.start_time,o.end_time, h.house_id,
            h.house_name,h.village_name,h.house_address,i.img_src
            from t_order o, t_house_info h, t_house_img i 
            where o.house_id = h.house_id and h.house_id = i.house_id 
            and i.is_main = 1 and o.is_finished = 1 and o.is_delete = 0 
            and o.user_id = $user_id limit $offset,$limit";
    return $this -> db -> query($sql) -> result();
  }

  public function get_finished_order_count($user_id){
    $sql = "select o.order_num,o.start_time,o.end_time, h.house_id,
            h.house_name,h.village_name,h.house_address,i.img_src
            from t_order o, t_house_info h, t_house_img i 
            where o.house_id = h.house_id and h.house_id = i.house_id 
            and i.is_main = 1 and o.is_finished = 1 and o.is_delete = 0 
            and o.user_id = $user_id";
    return $this -> db -> query($sql) -> num_rows();
  }

  public function get_unfinished_order($user_id,$offset,$limit){
    $sql = "select o.order_num,o.start_time,o.end_time, h.house_id,
            h.house_name,h.village_name,h.house_address,i.img_src
            from t_order o, t_house_info h, t_house_img i 
            where o.house_id = h.house_id and h.house_id = i.house_id 
            and i.is_main = 1 and o.is_finished = 0 and o.is_delete = 0 
            and o.user_id = $user_id limit $offset,$limit";
    return $this -> db -> query($sql) -> result();
  }

  public function get_unfinished_order_count($user_id){
    $sql = "select o.order_num,o.start_time,o.end_time, h.house_id,
            h.house_name,h.village_name,h.house_address,i.img_src
            from t_order o, t_house_info h, t_house_img i 
            where o.house_id = h.house_id and h.house_id = i.house_id 
            and i.is_main = 1 and o.is_finished = 0 and o.is_delete = 0 
            and o.user_id = $user_id";
    return $this -> db -> query($sql) -> num_rows();
  }

  public function update_order_by_order_num($order_num){
    $this -> db -> where('order_num', $order_num);
        $this -> db -> update('t_order', array(
            'is_delete' => 1
        ));
    return $this -> db -> affected_rows();
  }

  public function get_order_info_by_order_num($order_num){
    $sql = "select o.*, h.house_name, h.village_name, h.house_address, i.img_src
            from t_house_info h, t_house_img i, t_order o where o.house_id = h.house_id 
            and h.house_id = i.house_id and i.is_main = 1 
            and o.order_num = $order_num";
    return $this -> db -> query($sql) -> row();  
  }

  public function update_order_evaluate($order_num){
    $this -> db -> where('order_num', $order_num);
        $this -> db -> update('t_order', array(
            'is_evaluate' => 1
        ));
    return $this -> db -> affected_rows();
  }

  public function get_reserve_house_time($house_id){
    $sql = "select start_time, end_time from t_order where house_id=$house_id and is_delete = 0";
    return $this -> db -> query($sql) -> result();
  }

  public function save_order_info($real_name,$phone_num,$emergency_tel,$start_time,
                  $end_time,$total_price,$house_id,$user_id,$order_num){
    $this -> db -> insert('t_order', array(
      'real_name' => $real_name,
      'phone_num' => $phone_num,
      'emergency_tel' => $emergency_tel,
      'start_time' => $start_time,
      'end_time' => $end_time,
      'total_price' => $total_price,
      'house_id' => $house_id,
    'user_id' => $user_id,
      'order_num' => $order_num,
      'is_finished' => 0,
      'is_evaluate' => 0,
      'is_delete' => 0
    ));
    return $this -> db -> affected_rows();
  }

  public function update_order_by_finish($order_num){
    $this -> db -> where('order_num', $order_num);
    $this -> db -> update('t_order', array(
        'is_finished' => 1
    ));
    return $this -> db -> affected_rows();
  }

  public function get_order_evaluation_by_house_id($house_id){
    $sql = "select * from t_order_evaluation where house_id = $house_id";
    return $this -> db -> query($sql) -> result();
  }

  public function get_order_evaluation_count_by_house_id($house_id){
    $sql = "select * from t_order_evaluation where house_id = $house_id";
    return $this -> db -> query($sql) -> num_rows();
  }




  
}