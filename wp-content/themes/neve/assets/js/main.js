function createNewPost( dataArray, ctr ) {
    var createPost = new XMLHttpRequest();
    createPost.open( "POST", "http://localhost/proj/wp-json/katana/posts" );
    createPost.setRequestHeader( "X-WP-Nonce", nonceData.nonce);
    createPost.setRequestHeader( "Content-Type", "application/json;charset=UTF-8" );
    createPost.send(JSON.stringify( dataArray ));  
    createPost.onreadystatechange = function() {
        if( createPost.readyState == 4 ) {
            if( createPost.status == 200 ) {
                //alert( 'Successfully added new Post!' );
                document.querySelector( ".addPost [name='title']" ).value = "";
                document.querySelector( ".addPost [name=content]" ).value = "";
                //getPost( "addPost", "" );
                return createPost.status;
            } else {
                alert( "response: " + createPost.responseText );
                if( ctr < 2 ) {
                    console.log( "Retrying " + ctr );
                    createNewPost( dataArray, ++ctr );
                } else {
                    alert( `Post not created! Request Status: ${createPost.status} \n Retried ${ctr} times` );
                    return false;
                }
            }
        } else {
            if( createPost.status != 200) {
                if( ctr < 2 ) {
                    console.log( "Retrying " + ctr );
                    createNewPost( dataArray, ++ctr );
                } else {
                    alert( `Error in ready State ${createPost.readyState}: ${createPost.status} \n Retried ${ctr} times` );
                    return false;
                }
            }
        }
    }
}
