<template>
  <div class="search">
    <div class="search-input" v-click-outside="clickOut">
      <label for="search">
        <input ref="input" type="text" :placeholder="$t('search_placeholder')"
               :class="{ 'fill' : showResults && results.resultsCount > 0 }"
               v-model="query"
               @keyup="handleInput"
               id="search" aria-label="search"
        >
      </label>
      <fa v-if="validatedInput || isMobile" icon="times-circle" fixed-width class="clearquery" @click="clear" />
    </div>

    <div class="results" v-if="results.resultsCount > 0 && showResults && validatedInput">
      <SearchResultsGroup :query="query" :data="results.data.articles" :title="$t('articles.articles')" :type="'article'" />
      <SearchResultsGroup :query="query" :data="results.data.videos" :title="$t('videos.videos')" :type="'video'" />
      <SearchResultsGroup :query="query" :data="results.data.streams" :title="$t('streams.streams')" :type="'stream'" />
      <SearchResultsGroup :query="query" :data="results.data.podcasts" :title="$t('podcasts.podcasts')" :type="'podcast'" />
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import SearchResultsGroup from './SearchResultsGroup'
import ClickOutside from 'vue-click-outside'

export default {
  name: 'WSearch',

  directives: {
    ClickOutside
  },

  components: {
    SearchResultsGroup
  },

  data: () => ({
    query: '',
    showResults: false
  }),

  computed: {
    validatedInput () {
      return this.query.trim().length >= 3
    },
    ...mapGetters({
      results: 'global/search',
      isMobile: 'global/isMobile'
    })
  },

  methods: {
    handleInput () {
      if (!this.validatedInput) {
        this.showResults = false
        return false
      }

      this.$store.dispatch('global/search', this.query.trim()).then(() => {
        this.showResults = true
      })
    },
    clickOut () {
      return this.showResults ? this.clear() : null
    },
    clear () {
      this.query = ''
      this.showResults = false
      this.$emit('close')
    }
  }
}
</script>

<style lang="scss">
  .search {
    position: relative;
    &.mobile {
      position: absolute;
      top: -80px;
      left: 0;
      width: 100%;
      height: 80px;
      padding: 20px 20px 0;
      background: linear-gradient(-45deg, #312b54 0%, #191d3b 100%);
      &.visible {
        top: 0;
      }
      .search-input input {
        width: 100%;
        padding: 11px 20px;
      }
      .results {
        top: 60px;
      }
    }
  }

  .search-input {
    position: relative;

    input {
      width: 400px;
      font-size: 16px;
      background: #404275;
      border-radius: 24px;
      padding: 10px 20px;
      line-height: 1;
      color: #fff;
      font-weight: bold;

      &::placeholder {
        font-weight: normal;
        color: rgba(255, 255, 255, .7);
      }

      &.fill {
        border-radius: 24px 24px 0 0;
      }
    }

    svg {
      position: absolute;
      right: 15px;
      top: 50%;
      transform: translateY(-50%);
      &:hover {
        cursor: pointer;
        path {
          fill: #FFF;
        }
      }
      path {
        fill: #cacaca;
      }
    }
  }

  .results {
    position: absolute;
    top: 38px;
    left: 0;
    width: 100%;
    background-color: #404275;
    z-index: 2;
    border-radius: 0 0 5px 5px;
    box-shadow: inset 0 10px 10px -10px rgba(0,0,0,.07), 0 10px 12px 0 rgba(0,0,0,.08), 0 14px 28px 0 rgba(0,0,0,.1);
  }

  @media only screen and (min-width: 768px) {
    .results {
      width: calc(100% - 40px);
      left: 20px;
    }
  }
  @media only screen and (min-width: 1024px) {
    .results {
      width: 100%;
      left: 0;
    }
  }
</style>
