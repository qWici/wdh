<template>
  <div class="authors">
<!--    @TODO: Adaptive-->
    <h2>
      {{ $t('articles.authors') }}
    </h2>
    <div class="content-wrapper">
      <AuthorItem
        v-for="(item, key) in authors"
        :key="key"
        :src="item.logo"
        :link="getAuthorLink(item)"
        :title="item.name"
        :lang="item.language"
        :type="type"
      />
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import AuthorItem from '../../components/AuthorItem'

export default {
  layout: 'inner',
  name: 'AuthorsList',

  components: {
    AuthorItem
  },

  metaInfo () {
    return { title: this.$t('authors') }
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
.authors {
  margin: 0 0 20px;
  h2 {
    margin: 20px 0 20px;
    color: #FFF;
  }
  .content-wrapper {
    grid-template-columns: 1fr 1fr 1fr 1fr;
    grid-column-gap: 20px;
    grid-row-gap: 20px;
  }
}
</style>
