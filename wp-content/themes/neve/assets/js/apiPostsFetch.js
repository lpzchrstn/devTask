const url = 'http://localhost/proj/wp-json/katana/posts';
const postsContainer = document.querySelector('.latest-posts');

fetch( url )
.then( response => response.json() )
.then( data => {
    data.map( post => {
        const innerContent = 
        `
        <li>
            <h2>${post.title}</h2>
            ${post.content}
            <a href="${post.link}">Read More</a>
        </li>
        `
        postsContainer.innerHTML += innerContent;
    }) 
});