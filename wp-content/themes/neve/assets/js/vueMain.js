Vue.component('add-post', {
  data () {
    return {
      title: '',
      content: '',
    }
  },
  methods: {
    addPost() { 
      this.title = document.querySelector( ".addPost [name='title']" ).value; 
      this.content = document.querySelector( ".addPost [name='content']" ).value;
      var postData = {
        "post_title" : this.title,
        "post_content" : this.content,
        "post_status" : "publish"
      } 
      createNewPost( postData, 1 ); 
    }
  }
});

Vue.component('see-more', {
  data () {
    return {}
  },
  methods: {
    seeMore() { 
      this.$root.$refs.viewPost.viewPost( 'seemore', '' ); 
    }
  }
});

Vue.component('search-post', {
  data () {
    return {
      search: '',
    }
  },
  methods: {
    searchPost() { 
      if( document.querySelector( '#searchField' ).value == "" ){
        alert( 'Input a search query' );
      }else{
        this.search = document.querySelector( '#searchField' ).value;
        this.$root.$refs.viewPost.viewPost( 'search', this.search );
      }
    }
  }
});

Vue.component('view-post', {
  data () {
    return {
      posts: [],
      current_page: 1,
    }
  },
  created() {
    this.$root.$refs.viewPost = this;
  },
  methods: {
    viewPost( from, search ) { 
      if( search != "") {
        search = "?title=" + search.replace(/\s/g, '%20');
      }

      const url = 'http://localhost/proj/wp-json/katana/posts' + search ;
      if( from == "search" || from == "addPost") {
          current_page = 1;
      }else if( from == "seemore" ) {
        current_page += 1;
      } 

      console.log(current_page);

      fetch( url )
      .then( response => response.json() )
      .then( data => {

        var total_result = data.length;
        var per_page = 9;
        var num_this_page;

        if( per_page*current_page > total_result ) {
            num_this_page = per_page - ((per_page * current_page) - total_result);
        } else {
            num_this_page = per_page;
        }

        var array_index = per_page * (current_page - 1);

        var stop = (per_page * (current_page - 1 )) + num_this_page;

          var tempPost = [];
          for( var i = array_index; i < stop; i++ ) {
            tempPost[i] = data[i];
          }
          
          this.posts = tempPost;

          // Check if current_page is last page
          if( per_page * current_page >= total_result && document.querySelector( "#seemore" )) {
            document.querySelector( "#seemore" ).hide();
          }
      })
    }
  },
  mounted: function() {
    this.viewPost( 'initialize', '' );
  }
});

new Vue({
  el: '#app',
})


