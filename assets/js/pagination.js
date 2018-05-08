Vue.component('pagination', {
  template: `<ul class="pagination">
            <li
              v-on:click="paginate(page)" 
              v-for="page in pageNum"
              :class="{active: currentPage == page}">{{page}}</li>
            </ul>`,
  props: ['total', 'pageSize', 'pageFlag'],
  data(){
    return {
      currentPage: 1
    }
  },
  computed: {
    pageNum(){
      return Math.ceil(this.total / this.pageSize);
    }
  },
  methods: {
    paginate(page){
      if(this.currentPage == page) return;
      this.currentPage = page;
      this.$emit('paginate', page);
    }
  },
  beforeUpdate(){
    // console.log('update');
    if(this.pageFlag) this.currentPage = 1;    
  }
});