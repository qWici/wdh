<template>
  <div class="home">
    <div class="content-header">
      <h2>
        {{ $t('last_publications') }}
      </h2>
      <content-filter @filter="filter" content-type="articles" />
    </div>
    <div class="content-wrapper">
      <ContentItem
        v-for="(item, key) in items"
        :key="key"
        :src="item.image_src"
        :link="getArticleLink(item)"
        :title="item.title"
        :author="item.author.name"
        :date="item.date"
        :lang="item.author.language"
        :type="type"
      />
      <InfiniteLoading :distance="0" spinner="spiral" @infinite="infiniteHandler">
        <div slot="no-more" />
      </InfiniteLoading>
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import ContentItem from '../../components/ContentItem'
import ContentFilter from '../../components/ContentFilter'
import InfiniteLoading from 'vue-infinite-loading'

export default {
  layout: 'inner',
  name: 'ArticleList',

  components: {
    ContentItem,
    ContentFilter,
    InfiniteLoading
  },

  metaInfo () {
    return { title: this.$t('articles') }
  },

  data: () => ({
    type: 'article',
    page: 0,
    countItems: 0,
    infinityState: null
  }),

  computed: mapGetters({
    items: 'articles/paginate'
  }),

  watch: {
    items (newItems) {
      if (this.infinityState === null) { return false }

      this.page += 1
      if (this.countItems === newItems.length) {
        this.infinityState.complete()
      } else {
        this.countItems = newItems.length
        this.infinityState.loaded()
      }
    }
  },

  destroyed () {
    this.$store.dispatch('articles/clearState')
  },

  methods: {
    infiniteHandler ($state) {
      this.infinityState = $state
      this.$store.dispatch('articles/fetchPaginateArticles', this.page + 1)
    },
    getArticleLink (article) {
      return { author: article.author.slug, slug: article.slug }
    },
    filter (filters) {
      console.log(filters)
    }
  }
}
</script>

<style scoped lang="scss">
  @import "../../../sass/elements/home";
</style>
