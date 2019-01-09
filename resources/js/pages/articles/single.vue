<template>
  <div v-if="single" class="article">
    <bookmark :bookmarked="single.bookmarked" :id="single.id" type="article" />
    <div :style="'background-image: url(' + single.image_src + ')'" class="article--image">
      <img :src="single.image_src" :alt="single.title" style="display: none">
    </div>
    <h1>{{ single.title }}</h1>
    <div class="article--body">
      <p>{{ single.description }}</p>
      <a :href="single.link" rel="noreferrer" target="_blank">
        {{ $t('read_full_article') }}
      </a>
    </div>
    <footer v-if="single.author">
      <div class="article-author">
        <div :style="getBackgroundImage(single)" class="author-logo">
          <img :src="single.author.logo" :alt="single.author.name" style="display: none;">
        </div>
        <div class="article-author-info">
          <router-link :to="{name: 'article.author', params: { author: single.author.slug }}">
            {{ single.author.name }}
          </router-link>
          <p>{{ single.author.about }}</p>
        </div>
      </div>
    </footer>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import Bookmark from '../../components/Bookmark'

export default {
  middleware: 'auth',
  layout: 'inner',
  name: 'ArticleSingle',

  components: {
    Bookmark
  },

  metaInfo () {
    return {
      title: this.single.title === undefined ? 'Article' : this.single.title,
      meta: [
        { name: 'description', content: this.single.description },
        { property: 'og:title', content: this.single.title },
        { property: 'og:site_name', content: 'WebDevHub' },
        { property: 'og:type', content: 'website' },
        { property: 'og:url', content: window.location.href },
        { property: 'og:image', content: this.single.image_src },
        { property: 'og:description', content: this.single.description },
        { name: 'twitter:card', content: 'summary' },
        { name: 'twitter:site', content: window.location.href },
        { name: 'twitter:title', content: this.single.title },
        { name: 'twitter:description', content: this.single.description },
        { name: 'twitter:image:src', content: this.single.image_src },
        { itemprop: 'name', content: this.single.title },
        { itemprop: 'description', content: this.single.description },
        { itemprop: 'image', content: this.single.image_src }
      ]
    }
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
    this.$store.dispatch('articles/fetchBySlug', article).then(() => {
      let breadcrumbs = [
        { title: this.$t('articles'), route: { name: 'article' } },
        { title: this.single.author.name, route: { name: 'article.author', params: { author: this.single.author.slug } } },
        { title: this.single.title,
          route: { name: 'article.single', params: { author: this.single.author.slug, slug: this.single.slug } }
        }
      ]

      this.$store.dispatch('breadcrumbs/setBreadcrumbs', breadcrumbs)
    })
  },

  methods: {
    getBackgroundImage (article) {
      return `background-image: url("${article.author.logo}")`
    }
  }
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
  background: $gradient-default;
  border-radius: 5px;
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.4);
  color: #FFF;
  height: calc(100vh - 162px);
  overflow-y: scroll;
  overflow-x: visible;
  padding-bottom: 20px;
  &::-webkit-scrollbar {
    width: 10px;
    display: none;
  }
  &--image {
    width: 100%;
    height: 500px;
    background: #FFF;
    background-position: center;
    background-size: cover;
    background-repeat: no-repeat;
  }
  h1 {
    color: #FFF;
    margin: 0;
    padding: 20px;
    background-color: $default-black;
    text-align: center;
  }
  &--body {
    padding: 20px 20px 0;
    &:after {
      content: '';
      display: block;
      width: 100%;
      height: 2px;
      background: linear-gradient(to right, #5E4F8E 0%, #554C86 100%);
    }
    > p {
      margin: 0;
    }
    > a {
      display: block;
      width: 200px;
      margin: 20px auto;
      background: linear-gradient(to right, #9857D4 0%, #6546CC 100%);
      color: #FFF;
      padding: 10px 20px;
      border-radius: 5px;
      font-weight: bold;
      text-align: center;
      &:hover {
        box-shadow: 0 4px 6px rgba(0,0,0,.3);
        animation: animateButton 0.3s linear forwards;
      }
    }
  }
  footer {
    display: flex;
    justify-content: space-between;
    padding: 20px;
    align-items: center;
    & .article-author {
      display: flex;
      width: 100%;
      justify-content: center;
      align-items: center;
      flex-direction: column;
      .author-logo {
        width: 100px;
        height: 100px;
        background: #FFF;
        background-size: 85%;
        background-position: center;
        background-repeat: no-repeat;
        margin-bottom: 20px;
      }
      .article-author-info {
        width: 100%;
        text-align: center;
        a {
          font-weight: bold;
          color: $pink;
          &:hover {
            color: $blue;
          }
        }
      }
    }
  }
}

@media #{$mobile} {
  .article {
    h1 {
      font-size: 24px;
    }
  }
}

@keyframes animateButton {
  0%   {
    background: linear-gradient(to right, #9857D4 0%, #6546CC 100%);
  }
  10% {
    background: linear-gradient(to right, #9857D4 0%, #6546CC 90%);
  }
  20% {
    background: linear-gradient(to right, #9857D4 0%, #6546CC 80%);
  }
  30% {
    background: linear-gradient(to right, #9857D4 0%, #6546CC 70%);
  }
  40% {
    background: linear-gradient(to right, #9857D4 0%, #6546CC 60%);
  }
  50% {
    background: linear-gradient(to right, #9857D4 0%, #6546CC 50%);
  }
  60% {
    background: linear-gradient(to right, #9857D4 0%, #6546CC 40%);
  }
  70% {
    background: linear-gradient(to right, #9857D4 0%, #6546CC 30%);
  }
  80% {
    background: linear-gradient(to right, #9857D4 0%, #6546CC 20%);
  }
  90% {
    background: linear-gradient(to right, #9857D4 0%, #6546CC 10%);
  }
  100% {
    background: linear-gradient(to right, #6546CC 0%, #6546CC 0%);
  }
}
</style>
