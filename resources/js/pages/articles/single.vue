<template>
  <div v-if="single" class="article">
    <div :style="'background-image: url(' + single.image_src + ')'" class="article--image">
      <img :src="single.image_src" :alt="single.title" style="display: none">
    </div>
    <h1>{{ single.title }}</h1>
    <div class="article--body">
      {{ single.description }}
    </div>
    <footer v-if="single.author">
      <div class="article-author">
        <img :src="single.author.logo" :alt="single.author.name">
        <div class="article-author-info">
          <router-link :to="{name: 'article.author', params: { author: single.author.slug }}">
            {{ single.author.name }}
          </router-link>
          <p>{{ single.author.about }}</p>
        </div>
      </div>
      <a :href="single.link" target="_blank">Read full article</a>
    </footer>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
  middleware: 'auth',
  layout: 'inner',
  name: 'ArticleSingle',

  components: {},

  metaInfo () {
    return {title: this.single.title === undefined ? 'Article' : this.single.title}
  },

  data: () => ({}),

  computed: mapGetters({
    single: 'articles/single'
  }),

  created () {
    let article = {
      'author': this.$route.params.author,
      'slug': this.$route.params.slug
    }
    this.$store.dispatch('articles/fetchBySlug', article)
  },

  methods: {}
}
</script>

<style>
  main > .box {
    height: 100%;
    min-height: calc(100vh - 80px);
  }
</style>

<style scoped lang="scss">
@import "../../../sass/vars";

.article {
  margin: 20px 0;
  background: $default-black;
  border-radius: 5px;
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.4);
  overflow: hidden;
  &--image {
    background-size: cover;
    background-position: center;
    width: 100%;
    height: 500px;
  }
  h1 {
    color: #FFF;
    margin: 0;
    padding: 20px;
    background-color: $pink;
  }
  &--body {
    padding: 20px;
    color: #FFF;
  }
  footer {
    display: flex;
    justify-content: space-between;
    padding: 20px;
    background-color: #fff;
    align-items: center;
    > a {
      display: block;
      background: linear-gradient(135deg, #3260FE 0%, #3A9CFF 100%);
      color: #FFF;
      padding: 10px 20px;
      border-radius: 5px;
      font-weight: bold;
      text-align: center;
    }
    & .article-author {
      display: flex;
      max-width: calc(100% - 200px);
      img {
        width: auto;
        max-height: 100px;
        margin-right: 20px;
      }
    }
  }
}
</style>
