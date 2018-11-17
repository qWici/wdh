<template>
  <ul v-show="lastIndex !== 0" class="breadcrumbs">
    <li v-for="(item, key) in breadcrumbs" :key="key">
      <router-link v-if="key !== lastIndex" :to="item.route">
        {{ item.title }}
      </router-link>
      <span v-else>{{ item.title }}</span>
    </li>
  </ul>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
  name: 'WBreadcrumbs',

  data: () => ({}),

  computed: {
    lastIndex () {
      return this.breadcrumbs.length - 1
    },
    ...mapGetters({
      breadcrumbs: 'breadcrumbs/breadcrumbs'
    })
  }
}
</script>

<style scoped lang="scss">
@import "../../sass/vars";

.breadcrumbs {
  display: flex;
  flex-wrap: wrap;
  align-items: center;
  margin: 20px 0 20px 20px;
  li {
    margin-right: 10px;
    padding-right: 15px;
    font-size: 14px;
    position: relative;
    &:after {
      content: '/';
      position: absolute;
      top: 50%;
      right: 0;
      transform: translateY(-50%);
      font-size: 14px;
      color: #FFF;
      font-weight: bold;
    }
    + li {
      margin-top: 0;
    }
    &:last-child {
      margin-right: 0;
      &:after {
        display: none;
      }
    }
    a {
      color: $blue;
      font-weight: bold;
    }
    span {
      color: #FFF;
      font-weight: bold;
    }
  }
}
</style>
