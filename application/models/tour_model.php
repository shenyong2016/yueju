<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Tour_model extends CI_Model{

  public function get_tour_list_limit(){
    $sql = "select * from t_tour limit 3";
    return $this -> db -> query($sql) -> result();
  }
  
  public function get_tour_list($offset, $limit){
    $sql = "select t.*, u.username, u.head_img from t_tour t, t_user u 
            where t.user_id = u.user_id order by publish_time desc limit $offset, $limit";
    return $this -> db -> query($sql) -> result();
  }

  public function get_tour_list_count(){
    $sql = "select t.*, u.username, u.head_img from t_tour t, t_user u 
            where t.user_id = u.user_id";
    return $this -> db -> query($sql) -> num_rows();
  }

  public function get_hot_tour(){
    $sql = "select tour_id,tour_title from t_tour where is_hot = 1 limit 3";
    return $this -> db -> query($sql) -> result();
  }

  public function get_tour_detail_by_tour_id($tour_id){
    $sql = "select t.*, u.username, u.head_img from t_tour t, t_user u 
            where t.user_id = u.user_id and t.tour_id = $tour_id";
    return $this -> db -> query($sql) -> row();  
  }

  public function save_tour($user_id,$title,$content,$img_src,$tour_tag){
    $this -> db -> insert('t_tour', array(
      'user_id' => $user_id,
      'tour_title' => $title,
      'tour_content' => $content,
      'tour_img_src' => $img_src,
      'tour_tag' => $tour_tag,
      'is_delete' => 0
    ));
    return $this -> db -> affected_rows();
  }

  public function get_tour_by_user_id($user_id,$offset,$limit){
    $sql = "select tour_id,tour_title,publish_time from t_tour 
            where user_id = $user_id and is_delete = 0
            order by publish_time desc limit $offset,$limit";
    return $this -> db -> query($sql) -> result();
  }

  public function get_tour_count_by_user_id($user_id){
    $sql = "select tour_id,tour_title,publish_time from t_tour 
            where user_id = $user_id and is_delete = 0 order by publish_time desc";
    return $this -> db -> query($sql) -> num_rows();
  }

  public function delete_tour_by_tour_id($tour_id){
    $this -> db -> where('tour_id', $tour_id);
        $this -> db -> update('t_tour', array(
            'is_delete' => 1
        ));
    return $this -> db -> affected_rows();
  }

  public function get_tour_detail($tour_id){
    return $this -> db -> get_where('t_tour', array(
      'tour_id' => $tour_id
    )) -> row();
  }

  public function update_tour($title,$content,$img_src,$tour_tag,$tour_id){
    $this -> db -> where('tour_id', $tour_id);
        $this -> db -> update('t_tour', array(
          'tour_title' => $title,
          'tour_content' => $content,
          'tour_img_src' => $img_src,
          'tour_tag' => $tour_tag,
        ));
    return $this -> db -> affected_rows();
  }

  public function get_tour_list_by_user_id($user_id, $offset, $limit){
    $sql = "select t.*, u.username, u.username, u.head_img from t_tour t, t_user u 
            where t.user_id = u.user_id and u.user_id = $user_id
            limit $offset, $limit";
    return $this -> db -> query($sql) -> result();
  }

  public function get_tour_list_count_by_user_id($user_id){
    $sql = "select t.*, u.username, u.username, u.head_img from t_tour t, t_user u 
            where t.user_id = u.user_id and u.user_id = $user_id";
    return $this -> db -> query($sql) -> num_rows();
  }


}