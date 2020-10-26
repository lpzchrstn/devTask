<add-post inline-template id="addPostTemplate">
    <div class="addPost">
        <h3>Add post</h3>
        <input type="text" name="title" placeholder="Title" style="width: 400px;margin-bottom: 10px;"><br>
        <textarea name="content" placeholder="Content" rows="5" style="width: 100%;"></textarea><br>
        <input type="button" value="Add Post" @click="addPost()">
    </div>
</add-post>