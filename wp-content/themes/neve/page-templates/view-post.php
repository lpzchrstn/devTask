<view-post inline-template id="viewPostTemplate">
    <div class="divTable">
        <div class="innerTable">
            <div class="divcol" v-for="post in posts">
                <a v-bind:href="post.link">
                    <img v-if="!post.featured_image.thumbnail" src='../wp-content/themes/neve/assets/img/placeholder.png' draggable='false'></img>
                    <img v-else v-bind:src='post.featured_image.large' draggable='false'></img>
                    <div class="info">
                        <h2>{{ post.title }}</h2>
                        <p>{{ post.content }}</p>
                        <p v-for="meta in post.meta">{{ meta }}</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</view-post>