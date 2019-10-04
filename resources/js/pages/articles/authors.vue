<template>
  <div class="authors">
    <h2>{{ $t('articles.authors') }}</h2>
    <div class="production content-wrapper">
      <AuthorItem
        v-for="(item, key) in authors"
        :key="key"
        :src="item.logo"
        :link="getAuthorLink(item)"
        :title="item.name"
        :lang="item.language"
        :type="type"
      />
      <suggest-button type="author" />
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import AuthorItem from '../../components/AuthorItem'
import SuggestButton from '../../components/SuggestButton'

export default {
  layout: 'inner',
  name: 'AuthorsList',

  components: {
    AuthorItem,
    SuggestButton
  },

  metaInfo () {
    return { title: this.$t('articles.authors') }
  },

  data: () => ({
    type: 'article'
  }),

  computed: mapGetters({
    authors: 'articles/authors'
  }),

  created () {
    this.$store.dispatch('articles/fetchAuthors')
  },

  methods: {
    getAuthorLink (author) {
      return { author: author.slug }
    }
  }
}
</script>

<style scoped lang="scss">
@import "../../../sass/elements/home";
</style>
