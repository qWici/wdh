<template>
  <li v-click-outside="hide">
    <template v-if="isChildrenExist">
      <span class="wsidebar-nav-item" @click="toggleVisibilityChildren">
        <span class="wsidebar-nav-item__icon" :class="item.iconGradientClass">
          <fa :icon="item.faIcon" fixed-width />
        </span>
        <span class="wsidebar-nav-item__title">
          {{ $t(item.text) }}
        </span>
      </span>
      <ul class="wsidebar-nav-item__subcategories" v-if="isChildrenVisible">
        <li v-for="(children, key) in item.children" :key="key">
          <router-link :to="preparedLink(children)" active-class="active" class="wsidebar-nav-item">
            {{ $t(children.text) }}
          </router-link>
        </li>
      </ul>
    </template>

    <template v-else>
      <router-link :to="{ name: item.link }" class="wsidebar-nav-item" active-class="active" exact>
        <span class="wsidebar-nav-item__icon" :class="item.iconGradientClass">
          <fa :icon="item.faIcon" fixed-width />
        </span>
        <span class="wsidebar-nav-item__title">
          {{ $t(item.text) }}
        </span>
      </router-link>
    </template>
  </li>
</template>

<script>
import WSidebarNavItemType from '../types/ui/WSidebarNavItemType'
import ClickOutside from 'vue-click-outside'

export default {
  name: 'WSidebarNavItem',

  directives: {
    ClickOutside
  },

  props: {
    item: WSidebarNavItemType
  },

  data: () => ({
    isChildrenVisible: false
  }),

  computed: {
    isChildrenExist () {
      return this.item.children.length > 0
    }
  },

  methods: {
    toggleVisibilityChildren () {
      if (!this.isChildrenExist) { return false }
      this.isChildrenVisible = !this.isChildrenVisible
    },
    hide () {
      if (!this.isChildrenExist) { return false }
      this.isChildrenVisible = false
    },
    preparedLink (item) {
      if (item.params) {
       return { name: item.link, params: item.params }
      }

      return { name: item.link }
    }
  }
}
</script>

<style lang="scss">
@import "../../sass/vars";

.wsidebar-nav-item {
    display: flex;
    align-items: center;
    padding: 10px 20px;
    &:hover {
        background: $gradient-default;
        cursor: pointer;
    }
    &.active {
        background: $gradient-default;
    }
    &__icon {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 30px;
        height: 30px;
        border-radius: 50% 50% 0 50%;
        margin-right: 20px;
        svg {
            font-size: 13px;
            path {
                fill: #FFF;
            }
        }
    }
    &__title {
        color: #FFF;
        font-weight: bold;
    }
    &__subcategories {
        a {
            color: #FFF;
            font-weight: normal;
            padding: 10px 20px 10px 70px;
            font-size: 14px;
        }
    }
}
</style>
