<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class House extends CI_Controller {
  public function __construct(){
    parent::__construct();
    $this -> load -> model('house_model');
    $this -> load -> model('order_model');
  }
  // 房源中心
  public function index(){
		$this -> load -> view('house_center');
  }

  public function search_index(){
    $start_time = $this -> input -> get('startTime');
    $end_time = $this -> input -> get('endTime');
    $content = $this -> input -> get('content');
    $this -> load -> view('house_center', array(
      'start_time' => $start_time,
      'end_time' => $end_time,
      'content' => $content 
    ));
  }
  // 房源详情
  public function detail(){
    $house_id = $this -> uri -> segment(3);
    $house_info = $this -> house_model -> get_house_by_house_id($house_id);
    $house_imgs = $this -> house_model -> get_house_imgs_by_house_id($house_id);
    $house_recommended = $this -> house_model -> get_recommened_house();
    $evaluation = $this -> order_model -> get_order_evaluation_by_house_id($house_id);
    $evaluation_count = $this -> order_model -> get_order_evaluation_count_by_house_id($house_id);
    $evaluation_count = $evaluation_count == 0 ? 1 : $evaluation_count;
    $clean = 0; $traffic = 0; $manage = 0; $facility = 0; $total_score = 0;
    // 计算评价分数
    foreach($evaluation as $item){
      $clean += $item -> clean_val;
      $traffic += $item -> traffic_val;
      $manage += $item -> manage_val;
      $facility += $item -> facility_val;
    }
    $total_score = $clean + $traffic + $manage + $facility;
    $evaluation_score = array(
      'clean_val' => ceil($clean / $evaluation_count),
      'traffic_val' => ceil($traffic / $evaluation_count),
      'manage_val' => ceil($manage / $evaluation_count),
      'facility_val' => ceil($facility / $evaluation_count),
      'total_val' => ceil($total_score / ($evaluation_count * 4))      
    );
    $this -> load -> view('house_detail', array(
      'house_info' => $house_info,
      'house_imgs' => $house_imgs,
      'house_recommended' => $house_recommended,
      'evaluation_score' => $evaluation_score
    ));
  }

  // 根据小区查询房屋
  public function get_house_by_village_type(){
    $village_type = $this -> input -> get('villageType');
    $house_info = $this -> house_model -> get_house_by_village_type($village_type);
    echo json_encode($house_info);
  }

 
  // 条件查询房屋信息
  public function get_houses(){
    $page_size = $this -> input -> get('pageSize');
    $page = $this -> input -> get('page');     
    $content = $this -> input -> get('content');   
    $region = $this -> input -> get('region');
    $min_price = $this ->input -> get('minPrice');
    $max_price = $this ->input -> get('maxPrice');
    $house_size = $this ->input -> get('houseSize');
    $village_type = $this ->input -> get('villageType');
    $sale_type = $this ->input -> get('saleType');
    
    $house = $this -> house_model 
    -> get_houses($page_size, ($page-1)*$page_size,
                  $content,$region,$min_price,$max_price,$house_size,$village_type,$sale_type);
    $house_count = $this -> house_model 
    -> get_houses_count($content,$region,$min_price,$max_price,$house_size,$village_type,$sale_type);
    $house_info = array(
      'house_info' => $house,
      'house_count' => $house_count
    );
    echo json_encode($house_info);
  }

  // 订单中获取房源信息
  public function get_house_detail(){
    $house_id = $this -> input -> get('houseId');
    $house = $this -> house_model -> get_house_by_house_id($house_id);
    echo json_encode($house);
  }
  
















}