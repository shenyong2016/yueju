<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class House_model extends CI_Model {
  
  public function get_house_by_village_type($village_type){
    $sql = 'select h.*, i.img_src from t_house_info h, t_house_img i 
            where h.house_id = i.house_id and I.is_main = 1 and h.village_type ='.$village_type.' limit 3';
    return $this -> db -> query($sql) -> result();  
  }
  
  public function get_house_by_house_id($house_id){
    $sql = 'select * from t_house_info where house_id='.$house_id;
    return $this -> db -> query($sql) -> row();
  }

  public function get_house_imgs_by_house_id($house_id){
    $sql = 'select * from t_house_img where house_id='.$house_id;
    return $this -> db -> query($sql) -> result();
  }

  public function get_recommened_house(){
    $sql = 'select h.*, i.img_src from t_house_info h, t_house_img i 
            where h.house_id = i.house_id and i.is_main = 1 and h.house_recommened =1';
    return $this -> db -> query($sql) -> result();
  }

  
  // 根据条件查询
  public function get_houses($limit,$offset,$content,$region,$min_price,
                             $max_price,$house_size,$village_type,$sale_type){
    $sql = "select h.house_id, h.house_name, h.village_name, h.house_price, 
            h.house_address, i.img_src from t_house_info h, t_house_img i 
            where h.house_id  = i.house_id and i.is_main = 1";
    if($region){
      $sql .= " and h.house_location = '$region'";
    }
    if($content){
      $sql .= " and h.village_name like '%$content%'";
    }
    if($min_price){
      $sql .= " and h.house_price >= $min_price";
    }
    if($max_price){
      $sql .= " and h.house_price <= $max_price";
    }
    if($house_size){
      $sql .= " and h.house_size_val in ($house_size)";
    }
    if($village_type){
      $sql .= " and h.village_type in ($village_type)";
    }
    if($sale_type){
      $sql .= " and h.sale_type in ($sale_type)";
    }
    
    $sql .= " limit $offset, $limit";
    return $this -> db -> query($sql) -> result();
  }

  public function get_houses_count($content,$region,$min_price,$max_price,
                                    $house_size,$village_type,$sale_type){
    $sql = "select h.house_id, h.house_name, h.village_name, h.house_price, 
            h.house_address, i.img_src from t_house_info h, t_house_img i 
            where h.house_id  = i.house_id and i.is_main = 1";
    if($region){
      $sql .= " and h.house_location = '$region'";
    }
    if($content){
      $sql .= " and h.village_name like '%$content%'";
    }
    if($min_price){
      $sql .= " and h.house_price >= $min_price";
    }
    if($max_price){
      $sql .= " and h.house_price <= $max_price";
    }
    if($house_size){
      $sql .= " and h.house_size_val in ($house_size)";
    }
    if($village_type){
      $sql .= " and h.village_type in ($village_type)";
    }
    if($sale_type){
      $sql .= " and h.sale_type in ($sale_type)";
    }
    
    return $this -> db -> query($sql) -> num_rows();
  }








}