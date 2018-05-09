<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Tour extends CI_Controller {
  public function __construct(){
    parent::__construct();
    $this -> load -> model('house_model');
    $this -> load -> model('tour_model');
    $this -> load -> model('user_model');
  }
  public function index(){
    //分页
    $offset = $this -> uri -> segment(3);
    if($offset == ''){
        $offset = 0;
    }
    $this->load->library('pagination');
    $config['base_url'] = 'tour/index';
    $config['total_rows'] = $this -> tour_model -> get_tour_list_count();
    $config['per_page'] = 4;
    $config['uri_segment'] = 3;
    //你希望在分页的左边显示“第一页”链接的名字。如果你不希望显示，可以把它的值设为 FALSE 。
    $config['first_link'] = '';
    $config['last_link'] = '';
    //你希望在分页的左边显示“第一页”链接的名字。如果你不希望显示，可以把它的值设为 FALSE 。

    $config['prev_link'] = '上一页';
    $config['prev_tag_open'] = '<li>';
    $config['prev_tag_close'] = '</li>';
    $config['next_link'] = '下一页';
    $config['next_tag_open'] = '<li>';
    $config['next_tag_close'] = '</li>';
    $config['cur_tag_open'] = '<li class="active"><a href="'. $config['base_url'] .'">';
    $config['cur_tag_close'] = '</a></li>';
    $config['num_tag_open'] = '<li>';
    $config['num_tag_close'] = '</li>';
    $this -> pagination -> initialize($config);

    // echo $config['total_rows'];
    $tour_list = $this -> tour_model -> get_tour_list($offset, $config['per_page']);
    $hot_tour = $this -> tour_model -> get_hot_tour();
    $house_list = $this -> house_model -> get_recommened_house();
    $this -> load -> view('tour_note', array(
      'tour_list' => $tour_list,
      'house_list' => $house_list,
      'hot_tour_list' => $hot_tour,
      'total_rows' => $config['total_rows']
    ));
  }

  public function detail(){
    $this -> load -> view('tour_detail');
  }

  // 游记详情
  public function get_tour_detail(){
    $tour_id = $this -> input -> get('tourId');
    $tour = $this -> tour_model -> get_tour_detail_by_tour_id($tour_id);
    $house = $this -> house_model -> get_recommened_house();
    $tour_info = array(
      'tour' => $tour,
      'house' => $house
    );
    echo json_encode($tour_info);
  }

  // 发表游记
  public function tour_publish(){
    
    $this -> load -> view('tour_publish');
  }

  // 上传图片
  public function upload_tour_img(){
    $config['upload_path'] = './images/tour/';//设置上传路径
    $config['allowed_types'] = 'gif|jpg|png';//设置上传文件的格式
    $config['max_size'] = '3072';//设置文件的大小
    $config['file_name'] = date("YmdHis") . '_' . rand(10000,99999);//设置文件的文件名
    $this->load->library('upload', $config);
    $this -> upload -> do_upload('img');//表单里的自定义属性值
    $upload_data = $this -> upload -> data();

    if($upload_data['file_size'] > 0){
        $photo_url = 'images/tour/' . $upload_data['file_name'];
        echo $photo_url;
    }
  }
  // 删除图片
  public function delete_img(){
    $img_src = $this -> input -> get('imgSrc');
    if(file_exists($img_src)){
        unlink($img_src);
        echo 'success';
    }
  }

  // 发表游记
  public function publish_tour(){
    $user_id = $this -> session -> userdata('loginedUser')->user_id;
    $title = $this -> input -> get('title');
    $content = $this -> input -> get('content');
    $img_src = $this -> input -> get('imgSrc');
    $tour_tag = $this -> input -> get('tourTag');
    $tour_id = $this -> input -> get('tourId');
    if($tour_id){
      $row = $this -> tour_model -> update_tour($title,$content,$img_src,$tour_tag,$tour_id);
    }else{
      $row = $this -> tour_model -> save_tour($user_id,$title,$content,$img_src,$tour_tag);    
    }
    if($row > 0){
      echo 'success';
    }else{
      echo 'fail';
    }
  }

  // 查询登录人游记
  public function get_tour_self_list(){
    $user_id = $this -> session -> userdata('loginedUser')->user_id;
    $page = $this -> input -> get('page');
    $page_size = $this -> input -> get('tourPageSize');
    $tour = $this -> tour_model -> get_tour_by_user_id($user_id,($page-1)*$page_size,$page_size); 
    $tour_count = $this -> tour_model -> get_tour_count_by_user_id($user_id);
    $tour_info = array(
      'tour' => $tour,
      'tour_count' => $tour_count
    );   
    echo json_encode($tour_info);
  }

  // 删除游记
  public function delete_tour(){
    $tour_id = $this -> input -> get('tourId');
    $row = $this -> tour_model -> delete_tour_by_tour_id($tour_id);
    if($row > 0){
      echo 'success';
    }else{
      echo 'fail';
    }
  }

  // 获取某人的游记列表
  public function get_someone_tour_list(){
    $user_id = $this -> input -> get('userId');
    $page = $this -> input -> get('page');
    $page_size = $this -> input -> get('pageSize');
    
    $tour = $this -> tour_model -> get_tour_list_by_user_id($user_id,($page-1)*$page_size,$page_size);
    $tour_count = $this -> tour_model -> get_tour_list_count_by_user_id($user_id);
    echo json_encode(array(
      "tour" => $tour,
      "tour_count" => $tour_count
    ));
  }

  public function get_other_info(){
    $user_id = $this -> input -> get('userId');
    $user_info = $this -> user_model -> get_user_by_user_id($user_id);
    $house_info = $this -> house_model -> get_recommened_house();
    $tour_info = $this -> tour_model -> get_hot_tour();
    echo json_encode(array(
      'user_info' => $user_info,
      'house_info' => $house_info,
      'tour_info' => $tour_info
    ));
  }

  







}