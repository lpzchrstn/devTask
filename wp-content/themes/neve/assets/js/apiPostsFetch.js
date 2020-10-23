var btnGetPost = document.querySelector( '#btnGetPost' );

if( btnGetPost ) {
    btnGetPost.addEventListener("click", function() {
        if( document.querySelector( '#searchField' ).value == "" ){
            alert( 'Input a search query' );
        }else{
            getPost( document.querySelector( '#searchField' ).value );
        }
    });
}

getPost("");

function getPost( search ) {
    if( search != "") {
        
        search = "?title=" + search.replace(/\s/g, '%20');
    }


    const url = 'http://localhost/proj/wp-json/katana/posts' + search;
    console.log( url );
    const postsContainer = document.querySelector( '.postList' );
    postsContainer.innerHTML = "";

    fetch( url )
    .then( response => response.json() )
    .then( data => {
        data.map( post => {
            var img = "";

            if( post.featured_image.thumbnail ){
                img = `<img src='${post.featured_image.thumbnail}' draggable='false'></img>`
            }

            const innerContent = 
            `
            <li>
                <h2>${post.title}</h2>
                <p class='meta'>By: ${post.author} | ${post.date}
                <p>${post.content}</p>
                ${img}
                <a class='readBtn' href="${post.link}">Read More</a>
            </li>
            `
            postsContainer.innerHTML += innerContent;
        }) 
    });
}