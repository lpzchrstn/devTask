<search-post inline-template id="searchPostTemplate">
    <div class="searchPost" style="margin: 50px 0px;">
        <h3>Search Post</h3>
        <input type="text" id="searchField" name="search" placeholder="Search..." style="width: 400px;margin-bottom: 10px;">
        <input type="button" value="Get Post" @click="searchPost()">
    </div>
</search-post>