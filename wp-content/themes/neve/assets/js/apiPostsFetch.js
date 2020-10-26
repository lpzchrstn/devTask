var btnGetPost = document.querySelector( '#btnGetPost' );

if( btnGetPost ) {
    btnGetPost.addEventListener("click", function() {
        if( document.querySelector( '#searchField' ).value == "" ){
            alert( 'Input a search query' );
        }else{
            getPost( "search", document.querySelector( '#searchField' ).value );
        }
    });
}

current_page = 1;
//getPost("", "");

function getPost( from, search ) {

    if( search != "") {
        search = "?title=" + search.replace(/\s/g, '%20');
    }


    const url = 'http://localhost/proj/wp-json/katana/posts' + search;
    const postsContainer = document.querySelector( '.innerTable' );
    if( from == "search" ) {
        postsContainer.innerHTML = "";
    } else if ( from == "addPost" ){
        current_page = 1;
        postsContainer.innerHTML = "";
    }

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
        console.log(array_index);

        var stop = (per_page * (current_page - 1 )) + num_this_page;

        for( var i = array_index; i < stop; i++ ) {
            //console.log(i);
            var img = "";

            if( data[i].featured_image.thumbnail ){
                img = `<img src='${data[i].featured_image.thumbnail}' draggable='false'></img>`
            } else {
                img = `<img src='../wp-content/themes/neve/assets/img/placeholder.png' draggable='false'></img>`
            }

            const innerContent = 
            `
            <div class="divcol">
                <a href="${data[i].link}">
                    ${img}
                    <div class="info">
                        <h2>${data[i].title}</h2>
                        <p>${data[i].content}</p>
                        <p>${data[i].meta.katana_post_token}</p>
                        <p>${data[i].meta.katana_referrer_url}</p>
                    </div>
                </a>
            </div>
            `
            postsContainer.innerHTML += innerContent;
        }

        if( per_page * current_page > total_result && document.querySelector( "#seemore" )) {
            document.querySelector( "#seemore" ).remove();
        }
    });
}