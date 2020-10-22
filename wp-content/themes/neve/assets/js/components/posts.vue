<template>
    <div class="divTable">
        <div class="divcol" v-for="post in posts" v-bind:key="post">
            <h3>{{ post.title.rendered }}</h3>
            <p>{{ post.content.rendered }}</p>
            <img src="../wp-content/themes/neve/assets/img/placeholder.png" draggable="false">
        </div>      
    </div>
</template>

<script>
export default {
    mounted() {
        this.getPosts();
    },
    data() {
        return {
            postsUrl: 'http://localhost/proj/wp-json/katana/posts',
            posts: [],
            postsData: {
                per_page: 15,
                page: 1
            },
        }
    },
    methods: {
        getPosts() {
            fetch( this.postsURL )
            .then( response => {
                this.posts = response.data;
            })
        }
    }
}
</script>

<style scoped>

</style>