const url = 'http://localhost/proj/wp-json/katana/posts';
const postsContainer = document.querySelector( '.postList' );

fetch( url )
.then( response => response.json() )
.then( data => {
    data.map( post => {
        const innerContent = 
        `
        <li>
            <h2>${post.title}</h2>
            <p class='meta'>By: ${post.author} | ${post.date}
            <p>${post.content}</p>
            <a class='readBtn' href="${post.link}">Read More</a>
        </li>
        `
        postsContainer.innerHTML += innerContent;
    }) 
});