<template>
  <div class="search" v-click-outside="hide">
    <div class="search-input">
      <input ref="input" type="text" placeholder="Quick find..."
             :class="{ 'fill' : showResults }"
             v-model="query"
             @input="handleInput()"
             @blur="handleInput()"
      >
      <fa v-if="validatedInput" icon="times-circle" fixed-width class="clearquery" @click="clear()" />
    </div>

    <div class="results" v-if="results.resultsCount > 0 && showResults && validatedInput">
      <SearchResultsGroup :query="query" :data="results.data.articles" :title="'Articles'" :type="'article'" />
      <SearchResultsGroup :query="query" :data="results.data.videos" :title="'Videos'" :type="'video'" />
      <SearchResultsGroup :query="query" :data="results.data.streams" :title="'Streams'" :type="'stream'" />
      <SearchResultsGroup :query="query" :data="results.data.podcasts" :title="'Podcasts'" :type="'podcast'" />
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
      return this.query.length >= 3
    },
    ...mapGetters({
      results: 'global/search'
    })
  },

  methods: {
    handleInput () {
      if (!this.validatedInput) {
        this.showResults = false
        return false
      }

      this.$store.dispatch('global/search', this.query).then(() => {
        this.showResults = true
      })
    },
    hide () {
      this.query = ''
      this.showResults = false
    },
    clear () {
      this.query = ''
      this.showResults = false
    }
  }
}
</script>

<style lang="scss">
  .search {
    position: relative;
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
</style>
