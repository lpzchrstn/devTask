var btnPost = document.querySelector( '#btnPost' );

if( btnPost ) {
    btnPost.addEventListener("click", function() {
        var postData = {
            "title" : document.querySelector( ".addPost [name='title']" ).value,
            "content" : document.querySelector( ".addPost [name=content]" ).value,
            "status" : "publish"
        }
        
        var createPost = new XMLHttpRequest();
        createPost.open( "POST", "http://localhost/proj/wp-json/katana/posts" );
        createPost.setRequestHeader( "X-WP-Nonce", nonceData.nonce);
        createPost.setRequestHeader( "Content-Type", "application/json;charset=UTF-8" );
        createPost.send(JSON.stringify( postData ));  
        createPost.onreadystatechange = function() {
            if( createPost.readState == 4 ) {
                if( createPost.status == 201 ) {
                    document.querySelector( ".addPost [name='title']" ).value = "";
                    document.querySelector( ".addPost [name=content]" ).value = "";
                } else {
                    alert( "Error!" );
                }
            }
        } 
    });
}

/*
import posts from './components/posts.vue';
Vue.component('posts', posts);

var app = new Vue({
    el: '#app',
    data: {
      message: 'Hello Vue!'
    }
})
*/