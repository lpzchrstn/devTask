var btnPost = document.querySelector( '#btnPost' );

if( btnPost ) {
    btnPost.addEventListener("click", function() {
        var postData = {
            "post_title" : document.querySelector( ".addPost [name='title']" ).value,
            "post_content" : document.querySelector( ".addPost [name=content]" ).value,
            "post_status" : "publish"
        }
        
        createNewPost( postData, 1 ); 
    });
}

function createNewPost( dataArray, ctr ) {
    var createPost = new XMLHttpRequest();
    createPost.open( "POST", "http://localhost/proj/wp-json/katana/posts" );
    createPost.setRequestHeader( "X-WP-Nonce", nonceData.nonce);
    createPost.setRequestHeader( "Content-Type", "application/json;charset=UTF-8" );
    createPost.send(JSON.stringify( dataArray ));  
    createPost.onreadystatechange = function() {
        if( createPost.readyState == 4 ) {
            if( createPost.status == 200 ) {
                alert( 'Successfully added new Post!' );
                document.querySelector( ".addPost [name='title']" ).value = "";
                document.querySelector( ".addPost [name=content]" ).value = "";
            } else {
                alert( "response: " + createPost.responseText );
                if( ctr < 2 ) {
                    console.log( "Retrying " + ctr );
                    createNewPost( dataArray, ++ctr );
                } else {
                    alert( `Post not created! Request Status: ${createPost.status} \n Retried ${ctr} times` );
                }
            }
        } else {
            if( createPost.status != 200) {
                if( ctr < 2 ) {
                    console.log( "Retrying " + ctr );
                    createNewPost( dataArray, ++ctr );
                } else {
                    alert( `Error in ready State ${createPost.readyState}: ${createPost.status} \n Retried ${ctr} times` );
                }
            }
        }
    }
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