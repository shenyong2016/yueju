<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Order extends CI_Controller {
  public function __construct(){
    parent::__construct();
    $this -> load -> model('house_model');
    $this -> load -> model('tour_model');
    $this -> load -> model('order_model');  
    $this -> load -> model('evaluate_model');  
  }
  // 订单提交
  public function house_order(){
    $this -> load -> view('house_order');
  }

  // 订单确认
  public function confirmorder(){
    $this -> load -> view('order_confirm');
  }

  // 查询某房源的所有预定时间
  public function get_house_reserve_time(){
    $house_id = $this -> input -> get('houseId');
    $order_time_list = $this -> order_model -> get_reserve_house_time($house_id);
    echo json_encode($order_time_list);  
  }

  

  // 提交订单
  public function submit_order(){
    $real_name = $this -> input -> get('realName');
    $phone_num = $this -> input -> get('phoneNum');
    $emergency_tel = $this -> input -> get('emergencyTel');
    $start_time = $this -> input -> get('startTime');
    $end_time = $this -> input -> get('endTime');
    $total_price = $this -> input -> get('totalPrice');
    $house_id = $this -> input -> get('houseId');
    $user_id = $this -> session -> userdata('loginedUser')->user_id;
    $order_num= date("YmdHis").rand(10000,99999);//生成订单号
    $row = $this -> order_model -> save_order_info($real_name,$phone_num,$emergency_tel,$start_time,
                                   $end_time,$total_price,$house_id,$user_id,$order_num);
    if($row > 0){
      $order_info = array(
        'msg' => 'success',
        'order_num' => $order_num
      );
    }else{
      $order_info = array(
        'msg' => 'fail',
      );
    }
    echo json_encode($order_info);
  }

  // 订单详情
  public function order_detail(){
    $this -> load -> view('order_detail');
  }

  // 评价订单
  public function order_commit(){
    $this -> load -> view('order_commit');
  }

  // 获取当前登录人的finishedOrder
  public function get_finished_order(){
    $page = $this -> input -> get('page');
    $finish_page_size = $this -> input -> get('finishPageSize');
    $user_id = $this -> session -> userdata('loginedUser')->user_id;
    $order = $this -> order_model -> get_finished_order($user_id,($page-1)*$finish_page_size,$finish_page_size);
    $order_count = $this -> order_model -> get_finished_order_count($user_id);
    echo json_encode(array(
      'order' => $order,
      'order_count' => $order_count
    ));
  }

  // 获取当前登录人的unfinishedOrder
  public function get_unfinished_order(){
    $page = $this -> input -> get('page');
    $unfinish_page_size = $this -> input -> get('unfinishPageSize');
    $user_id = $this -> session -> userdata('loginedUser')->user_id;
    $order = $this -> order_model -> get_unfinished_order($user_id,($page-1)*$unfinish_page_size,$unfinish_page_size);
    $order_count = $this -> order_model -> get_unfinished_order_count($user_id);
    echo json_encode(array(
      'order' => $order,
      'order_count' => $order_count
    ));
  }

  // 删除订单
  public function delete_order(){
    $order_num = $this -> input -> get('orderNum');
    $row =$this -> order_model -> update_order_by_order_num($order_num);
    if($row > 0){
      echo 'success';
    }else{
      echo 'fail';
    }
  }

  // 获取订单相关信息
  public function get_order_info(){
   $order_num = $this -> input -> get('orderNum');
   $user_id = $this -> session -> userdata('loginedUser') -> user_id;
   $order = $this -> order_model -> get_order_info_by_order_num($order_num);
   $evaluation = array();
   if($order -> is_evaluate == 1){
    $evaluation = $this -> evaluate_model -> get_evaluation($order -> order_num);
   }
   echo json_encode(array(
     'order' => $order,
     'evaluation' => $evaluation
   )); 
  }

  // 提交订单评价
  public function commit_evaluation(){
    $user_id = $this -> session -> userdata('loginedUser')->user_id;
    $clean = $this -> input -> get('cleanVal');
    $traffic = $this -> input -> get('trafficVal');
    $manage = $this -> input -> get('manageVal');
    $facility = $this -> input -> get('facilityVal');
    $house_id = $this -> input -> get('houseId');
    $order_num = $this -> input -> get('orderNum');
    $row = $this -> evaluate_model -> save_evaluation($user_id,$clean,$traffic,$manage,$facility,$house_id,$order_num);
    if($row > 0){
      $result = $this -> order_model -> update_order_evaluate($order_num);
      if($result > 0){
        echo 'success';
      }else{
        echo 'fail';
      }
    }
  }

  // 支付订单
  public function pay_order(){
    $order_num = $this -> input -> get('orderNum');
    $row = $this -> order_model -> update_order_by_finish($order_num);
    if($row > 0){
      echo 'success';
    }else{
      echo 'fail';
    }
  }




}