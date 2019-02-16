<template>
  <div class="home">
    <div class="content-header">
      <h2 v-show="items.length > 0">
        {{ pageTitle }}
      </h2>
      <content-filter @updateTitle="updateTitle" content-type="articles" />
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

<!--@TODO: Refresh title with filters on change locale-->

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
    infinityState: null,
    pageTitle: ''
  }),

  computed: mapGetters({
    items: 'articles/paginate'
  }),

  mounted () {
    this.pageTitle = this.$tc('last_publications')
  },

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
    updateTitle (filters) {
      if (filters) {
        this.pageTitle = this.$tc('last_publications', null, { filters: filters })
        return
      }

      this.pageTitle = this.$tc('last_publications')
    }
  }
}
</script>

<style scoped lang="scss">
  @import "../../../sass/elements/home";
</style>
