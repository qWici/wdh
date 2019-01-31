<template>
  <div class="content-filters-wrapper">
    <button class="content-filters--button" :class="{ active: visible }" @click="toggleFiltersVisibility">Filters</button>
    <div class="content-filters-available" v-if="visible" v-click-outside="hide">
      <div class="content-filters-group" v-for="(item, key) in availableFilters" :key="key">
        <span>{{ item.title }}</span>
        <ul>
          <li v-for="(value, key) in item.values"
              :key="key"
              :class="{ active: filterSelected(value.val) }"
              @click.self="selectFilter({ type: item.type, value: value.val })">
            {{ value.title }}
            <button v-if="filterSelected(value.val)"  @click.self="removeFilter(item.type)"></button>
          </li>
        </ul>
      </div>
    </div>
  </div>
</template>
<!--
@TODO: Filter current state then make request for more data
-->
<script>
import ClickOutside from 'vue-click-outside'

export default {
  name: 'ContentFilter',

  directives: {
    ClickOutside
  },

  data: () => ({
    visible: false,
    availableFilters: [
      { title: 'Language', type: 'lang', values: [{ val: 'en', title: 'EN' }, { val: 'ru', title: 'RU' }] },
      { title: 'Author', type: 'author', values: [{ val: 'test-one', title: 'Test One' }, { val: 'test-two', title: 'Test Twi' }] }
    ],
    selectedFilters: []
  }),

  methods: {
    toggleFiltersVisibility () {
      this.visible = !this.visible
    },
    hide () {
      this.visible = false
    },
    selectFilter (item) {
      console.log('select')
      this.selectedFilters = [item, ...this.selectedFilters.filter(filter => filter.type !== item.type)]
    },
    removeFilter (type) {
      console.log('remove')
      console.log(type)
      console.log(this.selectedFilters)
      this.selectedFilters = this.selectedFilters.filter(test => test.type !== type)
    },
    filterSelected (filter) {
      return this.selectedFilters.some(item => {
        return item.value === filter
      })
    }
  }
}
</script>

<style scoped lang="scss">
.content-filters {
  &-wrapper {
    display: flex;
    justify-content: center;
    align-items: center;
    position: relative;
  }
  &-list {
    display: flex;
    span {
      margin: auto;
    }
  }
  &--button {
    height: 35px;
    background-color: #207eff;
    color: #FFF;
    font-weight: bold;
    font-size: 13px;
    padding: 10px 20px;
    border-radius: 5px;
    transition: all .3s;
    line-height: 1;
    &:hover {
      background-color: darken(#207eff, 15%);
      transition: all .3s;
      cursor: pointer;
    }
    &.active {
      background-color: darken(#207eff, 15%);
    }
  }
  &-available {
    position: absolute;
    top: 35px;
    right: 0;
    z-index: 2;
    background: linear-gradient(to right, #423A6F 0%, #323660 100%);
    width: 250px;
    padding: 15px 0 0;
    border-radius: 5px;
    box-shadow: 0 0 20px rgba(0,0,0,0.7);
    overflow: hidden;
  }
  &-group {
    display: flex;
    flex-direction: column;
    margin-bottom: 15px;
    &:last-child {
      margin-bottom: 0;
    }
    span {
      color: #FFF;
      font-weight: bold;
      display: block;
      margin-bottom: 10px;
      padding: 0 15px;
      line-height: 1;
    }
    ul {
      margin: 0;
      li {
        width: 100%;
        color: #FFF;
        padding: 5px 0 5px 15px;
        margin: 0;
        display: flex;
        align-items: center;
        justify-content: space-between;
        &:hover {
          cursor: pointer;
          background-color: #25294e;
        }
        &.active {
          background-color: #08a370;
        }
        button {
          -webkit-appearance: none;
          background-color: rgba(10,10,10,.2);
          border: none;
          border-radius: 290486px;
          cursor: pointer;
          pointer-events: auto;
          display: inline-block;
          flex-grow: 0;
          flex-shrink: 0;
          font-size: 0;
          outline: 0;
          position: relative;
          vertical-align: top;
          height: 16px;
          max-height: 16px;
          max-width: 16px;
          min-height: 16px;
          min-width: 16px;
          width: 16px;
          margin: 0 5px;
          &:after, &:before {
            background-color: #fff;
            content: "";
            display: block;
            left: 50%;
            position: absolute;
            top: 50%;
            transform: translateX(-50%) translateY(-50%) rotate(45deg);
            transform-origin: center center;
            height: 2px;
            width: 50%;
          }
          &:after {
            height: 50%;
            width: 2px;
          }
        }
      }
    }
  }
}
</style>
