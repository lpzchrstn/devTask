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
      this.createPost( postData, 1 );
    },
    createPost( dataArray, ctr) {
      var temp = this;
      var createPost = new XMLHttpRequest();
      createPost.open( "POST", "http://localhost/proj/wp-json/katana/posts" );
      createPost.setRequestHeader( "X-WP-Nonce", nonceData.nonce);
      createPost.setRequestHeader( "Content-Type", "application/json;charset=UTF-8" );
      createPost.send(JSON.stringify( dataArray ));  
      createPost.onreadystatechange = function() {
          if( createPost.readyState == 4 ) {
              if( createPost.status == 200 ) {
                  document.querySelector( ".addPost [name='title']" ).value = "";
                  document.querySelector( ".addPost [name=content]" ).value = "";
                  temp.$root.$refs.viewPost.viewPost( 'addPost', '' );
                  temp.$root.$refs.seemore.resetPage();
              } else {
                  alert( "response: " + createPost.responseText );
                  if( ctr < 2 ) {
                      console.log( "Retrying " + ctr );
                      createNewPost( dataArray, ++ctr );
                  } else {
                      alert( `Post not created! Request Status: ${createPost.status} \n Retried ${ctr} times` );
                      this.posted = false;
                  }
              }
          } else {
              if( createPost.status != 200) {
                  if( ctr < 2 ) {
                      console.log( "Retrying " + ctr );
                      createNewPost( dataArray, ++ctr );
                  } else {
                      alert( `Error in ready State ${createPost.readyState}: ${createPost.status} \n Retried ${ctr} times` );
                      this.posted = false;
                  }
              }
          }
      }
    }
  }
});

Vue.component('see-more', {
  props: [
    'reset',
  ],
  created() {
    this.$root.$refs.seemore = this;
  },
  data () {
    return {
      is_last_page: false,
    }
  },
  methods: {
    seeMore() { 
      this.$root.$refs.viewPost.viewPost( 'seemore', '' ); 
      this.is_last_page = this.$root.$refs.isLastPage;
      console.log(this.is_last_page);
    },
    resetPage() {
      this.is_last_page = false;
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
      is_last_page: false,
      is_next_last_page: false,
    }
  },
  created() {
    this.$root.$refs.viewPost = this;
    this.$root.$refs.isLastPage = this.is_last_page;
  },
  methods: {
    viewPost( from, search ) { 
      if( search != "") {
        search = "?title=" + search.replace(/\s/g, '%20');
      }

      const url = 'http://localhost/proj/wp-json/katana/posts' + search ;
      if( from == "search" || from == "addPost") {
          this.current_page = 1;
          this.is_last_page = false;
          this.$root.$refs.isLastPage = this.is_last_page;
          this.posts.length = 0;
      }else if( from == "seemore" ) {
        this.current_page += 1;
      } 

      fetch( url )
      .then( response => response.json() )
      .then( data => {

        // Pagination
        var total_result = data.length;
        var per_page = 6;
        var num_this_page;
        console.log('current page: ' + this.current_page);

        this.is_last_page = this.isLastPage( per_page, this.current_page, total_result);
        this.$root.$refs.isLastPage = this.is_last_page;

        if( this.is_last_page ) {
            num_this_page = per_page - ((per_page * this.current_page) - total_result);
        } else {
            num_this_page = per_page;
        }

        // End of Pagination

        var array_index = per_page * ( this.current_page - 1);

        var stop = (per_page * ( this.current_page - 1 )) + num_this_page;

          var tempPost = [];
          for( var i = array_index; i < stop; i++ ) {
            tempPost[i] = data[i];
          }
          
          this.posts = this.posts.concat(tempPost.filter(function () { return true }));

          // Check if next page is last page for see more component
          this.is_next_last_page = this.isLastPage( per_page, this.current_page + 1, total_result);
          this.$root.$refs.isLastPage = this.is_next_last_page;
      })
      .catch(function(err) {
        console.log('Fetch Error :-S', err);
      });
    },
    isLastPage( per_page, current_page, total_result ) {
      return per_page * current_page >= total_result ? true : false;
    }
  },
  mounted: function() {
    this.viewPost( 'initialize', '' );
  }
});

new Vue({
  el: '#app',
})


