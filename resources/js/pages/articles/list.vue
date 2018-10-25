<template>
  <div class="home">
    <h2 v-show="all.length > 0" >{{ $t('last_publications') }}</h2>
    <div class="content-wrapper">
      <content-item
        v-for="(item, key) in all"
        :key="key"
        :src="item.image_src"
        :link="item.link"
        :title="item.title"
        :author="item.author.name"
        :date="item.date"
        :lang="item.author.language"
        :type="type"/>
    </div>
    </div>
</template>

<script>
import { mapGetters } from 'vuex'
import ContentItem from '../../components/ContentItem'

export default {
  middleware: 'auth',
  layout: 'inner',
  name: 'ArticleList',

  components: {
    ContentItem
  },

  metaInfo () {
    return { title: this.$t('articles') }
  },

  data: () => ({
    type: 'article'
  }),

  computed: mapGetters({
    all: 'articles/all'
  }),

  created () {
    this.$store.dispatch('articles/fetchAllArticles')
  },

  methods: {}
}
</script>

<style scoped lang="scss">
  .home {
    margin-top: 20px;
    padding-right: 10px;
    padding-bottom: 20px;
    overflow-y: scroll;
    height: calc(100vh - 100px);
    &::-webkit-scrollbar {
      width: 10px;
    }
    &::-webkit-scrollbar-track {
      box-shadow: inset 0 0 5px rgba(0,0,0,0.3);
      border-radius: 5px;
    }
    &::-webkit-scrollbar-thumb {
      background: #0e1430;
      border-radius: 5px;
    }
    &::-webkit-scrollbar-thumb:hover {
      background: #0e1430;
    }
    h2 {
      color: #FFF;
      margin-top: 20px;
      display: inline-block;
      position: relative;
      padding-right: 20px;
      margin-bottom: 25px;
      &:first-child {
        margin-top: 0;
      }
      &:after {
        content: '';
        width: 10px;
        height: 10px;
        border-radius: 50%;
        position: absolute;
        top: 50%;
        right: 0;
        transform: translateY(-50%);
      }
      &.live:after {
        background-color: #D92B4C;
      }
      &.offline:after {
        background-color: #858585;
      }
    }
  }
  .content-wrapper {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    grid-column-gap: 20px;
    grid-row-gap: 20px;
  }
</style>
