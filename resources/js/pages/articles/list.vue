<template>
  <div class="home">
    <h2 v-show="items.length > 0">{{ $t('last_publications') }}</h2>
    <div class="content-wrapper">
      <content-item
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
    </div>
    <infinite-loading :distance="0" spinner="spiral" @infinite="infiniteHandler">
      <div slot="no-more" />
    </infinite-loading>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import ContentItem from '../../components/ContentItem'
import InfiniteLoading from 'vue-infinite-loading'

export default {
  middleware: 'auth',
  layout: 'inner',
  name: 'ArticleList',

  components: {
    ContentItem,
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
      this.$store.dispatch('articles/fetchPaginateArticles', this.page + 1).then(() => {
        let breadcrumbs = [{ title: this.$t('articles'), route: { name: 'article' } }]

        this.$store.dispatch('breadcrumbs/setBreadcrumbs', breadcrumbs)
      })
    },
    getArticleLink (article) {
      return { author: article.author.slug, slug: article.slug }
    }
  }
}
</script>

<style scoped lang="scss">
  @import "../../../sass/elements/home";
</style>
