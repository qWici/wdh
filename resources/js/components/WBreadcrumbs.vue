<template>
  <ul v-show="lastIndex !== 0" class="breadcrumbs" itemscope itemtype="http://schema.org/BreadcrumbList">
    <li v-for="(item, key) in breadcrumbs" :key="key" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
      <meta itemprop="position" :content="key + 1"/>
      <router-link v-if="key !== lastIndex" :to="item.route" itemscope itemtype="http://schema.org/Thing" itemprop="item" :id="key">
        <b itemprop="name">{{ item.title }}</b>
      </router-link>
      <span v-else itemscope="itemscope" itemtype="http://schema.org/Thing" itemprop="item" :id="'breadcrumb_' + key">
        <b itemprop="name">{{ item.title }}</b>
      </span>
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
  margin: 20px 0 0;
  &:not(:last-child) {
    margin-bottom: 0;
  }
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

@media only screen and (max-width: 768px) {
  .breadcrumbs {
    margin-top: 20px;
    margin-bottom: 20px;
    &:not(:last-child) {
      margin-bottom: 20px;
    }
  }
}
</style>
