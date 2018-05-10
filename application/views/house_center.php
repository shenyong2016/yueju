<?php $loginedUser = $this -> session -> userdata('loginedUser');?>
<!-- <?php echo $start_time;?> -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <base href="<?php echo site_url();?>">  
  <title>悦居短租-房源中心</title>
  <link rel="stylesheet" href="assets/css/common.css">
  <link rel="stylesheet" href="assets/css/houseCenter.css">
  <link rel="stylesheet" href="assets/css/jquery-ui.min.css">
  <link rel="stylesheet" href="assets/css/datePicker.css">
  <link rel="stylesheet" href="assets/css/picZoom.css">
  <link rel="stylesheet" href="assets/css/footer.css">
  <link rel="stylesheet" href="assets/css/elementUI.css">  
  <link rel="stylesheet" href="https://unpkg.com/element-ui/lib/theme-chalk/index.css">  
  
  <style>
    .pagination{
      width: 100%;
      display: -webkit-flex; /* Safari */
      display: flex;
      flex-direction: row;
      flex-wrap: nowrap;
      justify-content: center;
    }
    .pagination li{
      width: 30px;
      height: 30px;
      background: #ccc;
      color: #fff;
      text-align: center;
      line-height: 30px;
      cursor: pointer;
      margin-left: 10px;      
    }
    .pagination li.active{
      background: #65CEA7;
    }
  </style>
</head>
<body>
  <?php include 'header.php';?>
  <div id="house-center" v-loading="loading">
    <div class="wrapper">
      <!-- 搜索框 -->
      <form id="search_area" method="post" onsubmit="return false;" class="search">
        <div class="select-box">
          <div class="select_btn">区域</div> 
          <ul style="z-index: 1;" class="search_list">
            <li>香坊区</li> 
            <li>南岗区</li> 
            <li>动力区</li> 
            <li>道里区</li> 
            <li>道外区</li> 
            <li>呼兰区</li> 
            <li>双城区</li> 
            <li>江北区</li>
          </ul>
        </div> 
        <input type="hidden" name="region" class="select_hidden" ref="region" value=""> 
        <input type="text" id="dpd1" name="startTime" placeholder="最低价位" 
                autocomplete="off" v-model="minPrice" class="staytime"
                v-on:blur="isPrice(minPrice)"> 
        <input type="text" id="dpd2" name="endTime" placeholder="最高价位" 
               autocomplete="off" v-model="maxPrice" class="staytime"
               v-on:blur="isPrice(maxPrice)"> 
        <div>
          <input type="text" name="search_content" ref="content" value="<?php echo $this->input->get('content')?>"  autocomplete="off" placeholder="小区名" class="search_content">
        </div> 
        <input name="search_btn" type="submit" v-on:click="searchHouse" value="搜索" class="search_btn">
      </form> 
      <!-- 搜索框 -->
      
      <!-- 搜索条件 -->
      <ul class="select-tab">
        <li class="tab-list clearfix">
          <span class="tab-title">小&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;区：</span>
          <div class="tab-district">
            <input type="checkbox"
                   v-model="villageTypeList"
                   v-on:click="searchHouseByVillage" value="1">
            <label>哈尔滨悦居连锁公寓•康泰嘉园店</label> 
          </div>
          <div class="tab-district">
            <input type="checkbox"
                   v-model="villageTypeList"
                   v-on:click="searchHouseByVillage" value="2">
            <label>哈尔滨悦居连锁公寓•熙俊印象店</label> 
          </div>
          <div class="tab-district">
            <input type="checkbox"
                   v-model="villageTypeList"
                   v-on:click="searchHouseByVillage" value="3">
            <label>哈尔滨悦居连锁公寓•群力家园店</label> 
          </div>
          <div class="tab-district">
            <input type="checkbox"
                   v-model="villageTypeList"
                   v-on:click="searchHouseByVillage" value="4">
            <label>哈尔滨悦居连锁公寓•雨阳名居店</label> 
          </div>
          <div class="tab-district">
            <input type="checkbox"
                   v-model="villageTypeList"
                   v-on:click="searchHouseByVillage" value="5">
            <label>哈尔滨悦居连锁公寓•玫瑰湾店</label> 
          </div>
          <div class="tab-district">
            <input type="checkbox"
                   v-model="villageTypeList"
                   v-on:click="searchHouseByVillage" value="6">
            <label>哈尔滨悦居连锁公寓•新怡园店</label> 
          </div>
        </li>

        <li class="tab-list clearfix">
          <span class="tab-title">户&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp型：</span>
          <div class="tab-district">
            <input type="checkbox" 
                  v-on:click="searchHouseByHouseSize" 
                  v-model="houseSizeList" value="1">
            <label>一居室</label> 
          </div>
          <div class="tab-district">
            <input type="checkbox" 
                   v-on:click="searchHouseByHouseSize"             
                   v-model="houseSizeList" value="2">
            <label>二居室</label> 
          </div>
          <div class="tab-district">
            <input type="checkbox" 
                   v-on:click="searchHouseByHouseSize"                
                   v-model="houseSizeList" value="3">
            <label>三居室</label> 
          </div>
          <div class="tab-district">
            <input type="checkbox" 
                   v-on:click="searchHouseByHouseSize"             
                   v-model="houseSizeList" value="4">
            <label>四居室及以上</label> 
          </div>
        </li>
        <li class="tab-list clearfix">
          <span class="tab-title">租&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp售：</span>
          <div class="tab-district">
            <input type="checkbox" 
                   v-model="saleTypeList"
                   v-on:click="searchHouseBySale" value="2">
            <label>可售</label>
          </div>
        </li>
      </ul>
      <!-- 搜索条件 -->
     
      <!-- 搜索结果 -->
      <div id="search-content">
        <div v-for="houseItem in houseList" class="house-group">
          <a :href="'house/detail/'+houseItem.house_id">
            <div class="pic-box">
              <div class="house-mask"></div>          
              <img :src="houseItem.img_src" alt="">
            </div>
          </a>
          <div class="house-desc">
            <p>
              <span class="house-info">{{houseItem.village_name}} {{houseItem.house_name}}</span>
              <span class="house-price">{{houseItem.house_price}}.00</span>
            </p>
            <p>{{houseItem.house_address}}</p>
          </div>
        </div>

        <!-- 分页 -->
        <pagination :page-flag="pageFlag" :total="houseCount" :page-size="pageSize" v-on:paginate="loadHouseData"></pagination>
        <!-- 分页 -->


       
      </div>
      <!-- 搜索结果 -->
    </div>
  </div>

  <!-- footer -->
  <?php include 'footer.php';?>
  <!-- footer -->
  
  <!-- 登录dialog -->
   <?php include 'dialog.php';?>
  <!-- 登录dialog -->
  <input type="hidden" id="current-index" value="house">  
  <script src="assets/js/jquery-1.12.4.min.js"></script>
  <script src="assets/js/jquery-ui.min.js"></script>
  <script src="assets/js/datePicker.js"></script>
  <script src="assets/js/header.js"></script>
  <script src="assets/js/houseCenter.js"></script>
  <!-- <script src="assets/js/picZoom.js"></script> -->
  <script src="assets/js/vue.min.js"></script>
  <script src="assets/js/axios.min.js"></script>  
  <script src="assets/js/pagination.js"></script>
  <script src="assets/js/elementUI.js"></script>    
  <script>
      var houseCenter = new Vue({
        el: '#house-center',
        data: {
          loading: false,
          houseList: [],  
          houseCount: 0,
          minPrice: '',//最低价
          maxPrice: '',//最高价
          content: '',//小区名
          region: '',//区域
          villageTypeList: [],//小区
          villageType: '',//小区
          houseSizeList: [],//房屋大小
          houseSize: '',//房屋大小
          saleTypeList: [],
          saleType: '',
          pageSize: 6,
          page: 1,
          pageFlag: false,//设置当前页数的更新标识
        },
        methods: {
          isPrice(price){
            if(!/^\d*$/.test(price)){
              alert('请输入数字');
            }
          },
          searchHouseByHouseSize(){
            this.pageFlag = true;            
            this.houseSize = this.houseSizeList.join(',');
            this.loadHouseData(this.page);  
          },
          searchHouseBySale(){
            this.pageFlag = true;            
            this.saleType = this.saleTypeList.join(',');
            this.loadHouseData(this.page);
          },
          searchHouseByVillage(){
            this.pageFlag = true;            
            this.villageType = this.villageTypeList.join(',');
            this.loadHouseData(this.page);
          },
          searchHouse(){
            this.content = this.$refs.content.value;
            this.region = this.$refs.region.value;          
            this.pageFlag = true;
            this.loadHouseData(this.page);
          },
          loadHouseData(page){
            var { pageSize,content,region,minPrice,maxPrice,
                  houseSize,villageType,saleType } = this;  
            this.loading = true;
            axios.get('house/get_houses', {
              params:{
                pageSize,page,content,region,
                minPrice,maxPrice,houseSize,villageType,saleType
              }
            }).then(res => {
              this.houseList = res.data.house_info;
              this.houseCount = res.data.house_count;
              this.pageFlag = false;
              this.loading = false;            
            });
          }
        },
        created(){
          var url = window.location.href;
          var newUrl = url.indexOf('search') == -1 ? 
              (url + '?minPrice=&maxPrice=&content=') : url;
          var params = newUrl.split('?')[1].split('&');
          this.minPrice = params[0].split('=')[1];
          this.maxPrice = params[1].split('=')[1];
          this.content = params[2].split('=')[1];
          this.loadHouseData(this.page);
        },
        mounted(){
          $('#search-content').on('mouseover', '.pic-box', function(){
            $(this).children('img').stop().animate({
              width: 390,
              height: 237,
              marginLeft: -10,
              marginTop: -6,
            });
            $(this).children('.house-mask').stop().animate({
              opacity: 0.4
            });
          });
          $('#search-content').on('mouseout', '.pic-box', function(){
            $(this).children('img').stop().animate({
              width: 370,
              height: 225,
              marginLeft: 0,
              marginTop: 0,
            });   
            $(this).children('.house-mask').stop().animate({
              opacity: 0
            }); 
          });
        }
      });
    
  









  
  </script>
</body>
</html>