<?php $loginedUser = $this -> session -> userdata('loginedUser');?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <base href="<?php echo site_url();?>">
  <title>发表游记</title>
  <link rel="stylesheet" href="assets/css/common.css">
  <link rel="stylesheet" href="assets/css/footer.css">
  <link rel="stylesheet" href="assets/css/elementUI.css">
  <link rel="stylesheet" href="assets/css/tourPublish.css">
  <link rel="stylesheet" href="https://unpkg.com/element-ui/lib/theme-chalk/index.css">
  <style>
    .el-tag + .el-tag {
      margin-left: 10px;
    }
    .button-new-tag {
      margin-left: 10px;
      height: 32px;
      line-height: 30px;
      padding-top: 0;
      padding-bottom: 0;
    }
    .input-new-tag {
      width: 90px;
      margin-left: 10px;
      vertical-align: bottom;
    }
    .el-textarea__inner{
      height: 180px !important;
    }
  </style>
</head>
<body>
  <!-- header -->
  <?php include 'header.php';?>
  <!-- header -->
  <div id="edit-tour">
    <div class="wrapper">
      <div class="baner">
        <!-- 文章头图 -->
        <div class="blog-img">
          <img v-if="imgSrc" :src="imgSrc" alt="">
          <img v-else src="assets/img/add_blog.jpg" alt="">
          <!-- <p  v-if="imgSrc" class="delete-img">
              <span v-on:click="deleteImg"></span>
          </p> -->
        </div>
        <!-- 文章头图 --> 

        <div class="demo">
          <div class="upload-btn">
            <h2 v-on:click="clickFile">{{tourId ? '修改' : '上传'}}文章头图</h2>
            <input v-on:change="uploadImg" ref="upload" type="file" accept="image/gif, image/jpeg,image/png,image/jpg">
          </div>
        </div>
      </div>
      <div class="edit_blog">
        <div class="edit_header">
          <span>*标题：最多35个汉字</span>
          <el-input type="text" v-model="title" placeholder="请输入文章标题"></el-input>
        </div>
        <div class="blog_content">
          <span>*正文：</span>
          <el-input type="textarea" autosize="{ minRows: 2, maxRows: 6 }"
                  placeholder="请输入内容" v-model="content"
                  size="medium">
          </el-input>
        </div>
        <div class="tag">
          <span>添加标签：</span>
          <!-- 添加标签 -->
          <el-tag
            :key="tag"
            v-for="tag in dynamicTags"
            closable="true"
            :disable-transitions="false"
            @close="handleClose(tag)">
            {{tag}}
          </el-tag>
          <el-input
            class="input-new-tag"
            v-if="inputVisible"
            v-model="inputValue"
            ref="saveTagInput"
            size="small"
            @keyup.enter.native="handleInputConfirm"
            @blur="handleInputConfirm">
          </el-input>
          <el-button v-else class="button-new-tag" size="small" @click="showInput">+新标签</el-button>
        </div>
        <div class="publish">
          <el-button v-on:click="submitTour" type="warning">{{tourId ? '确认' : '发表'}}</el-button>
        </div>
      </div>
    </div>
  </div>


  <!-- footer -->
  <?php include 'footer.php';?>
  <!-- footer -->
  <input type="hidden" id="current-index" value="tour">    
  <script src="assets/js/jquery-1.12.4.min.js"></script>
  <script src="assets/js/vue.min.js"></script>
  <script src="assets/js/axios.min.js"></script>
  <script src="assets/js/elementUI.js"></script>
  <script src="assets/js/header.js"></script>
  <script>
    new Vue({
      el: '#edit-tour',
      data: {
        title: '',
        content: '',
        dynamicTags: [],
        inputVisible: false,
        inputValue: '',
        imgSrc: '',
        tourId: <?php echo $this->uri->segment(3) ? $this->uri->segment(3) : 0?>
      },
      methods: {
        handleClose(tag) {
          this.dynamicTags.splice(this.dynamicTags.indexOf(tag), 1);
        },
        showInput() {
          this.inputVisible = true;
          this.$nextTick(() => {
            this.$refs.saveTagInput.$refs.input.focus();
          });
        },
        handleInputConfirm() {
          let inputValue = this.inputValue;
          if (inputValue) {
            this.dynamicTags.push(inputValue);
          }
          this.inputVisible = false;
          this.inputValue = '';
        },
        clickFile(){
          var oUploadImg = this.$refs.upload;
          oUploadImg.click();
        },
        uploadImg(){
          if(this.imgSrc){
            this.deleteImg();
          }
          var oFormData = new FormData();
          var oUploadImg = this.$refs.upload;          
          oFormData.append('img', oUploadImg.files[0]);
          var config = {
            headers:{'Content-Type':'multipart/form-data'}
          }; 
          axios.post('tour/upload_tour_img',oFormData,config).then(res => {
            this.imgSrc = res.data;
          })     
        
        },
        deleteImg(){
          axios.get('tour/delete_img', {
            params: {
              imgSrc: this.imgSrc
            }
          }).then(res => {
            if(res.data == 'success'){
              this.imgSrc = '';
            }
          });
        },
        submitTour(){
          var tourTag = '';
          if(this.dynamicTags.length > 0){
             tourTag = this.dynamicTags.join('-');
          }
          var {title, content, imgSrc, tourId} = this;
          if(!imgSrc){
            this.$message({
              showClose: true,
              message: '请上传文章头图',
              type: 'warning'
            });
            return;
          }else if(!title){
            this.$message({
              showClose: true,
              message: '请填写标题',
              type: 'warning'
            });
            return;
          }else if(title.length > 35){
            this.$message({
              showClose: true,
              message: '标题不得超过35个字',
              type: 'warning'
            });
            return;
          }else if(!content){
            this.$message({
              showClose: true,
              message: '请填写正文',
              type: 'warning'
            });
            return;
          }else if(!tourTag){
            this.$message({
              showClose: true,
              message: '请填写标签',
              type: 'warning'
            });
            return;
          }
          
          axios.get('tour/publish_tour', {
            params: {title, content, imgSrc, tourTag,tourId}
          }).then(res => {
            if(res.data == 'success'){
              this.$message({
                showClose: true,
                message: this.tourId ? '游记修改成功' : '游记发表成功',
                type: 'success'
              });
              setTimeout(() => {
                window.location.href = 'tour/index';                              
              }, 1000);
            }else{
              this.$message({
                showClose: true,
                message: this.tourId ? '游记修改失败' : '发表游记失败',
                type: 'error'
              });
            }
          });
        }
      },
      created(){
        if(this.tourId){
          axios.get('tour/get_tour_detail', {
            params: {
              tourId: this.tourId
            }
          }).then(res => {
            var tour = res.data.tour;
            this.imgSrc = tour.tour_img_src;
            this.title = tour.tour_title;
            this.content = tour.tour_content;
            this.dynamicTags = tour.tour_tag.split('-');
            console.log('imgSrc===', this.imgSrc);
          });
        }
      },
    });
  
  
  
  
  
  
  </script>
</body>
</html>