<template>
  <div class="settings">
    <h1>{{ $t('settings') }}</h1>
    <div class="tabs">
      <ul>
        <li v-for="tab in tabs" :key="tab.route" class="nav-item">
          <router-link :to="{ name: tab.route }" class="nav-link" active-class="active">
            <fa :icon="tab.icon" fixed-width />
            {{ tab.name }}
          </router-link>
        </li>
      </ul>
    </div>
    <div class="tabs-content">
      <transition name="fade" mode="out-in">
        <router-view />
      </transition>
    </div>
  </div>
</template>

<script>
export default {
  middleware: 'auth',

  computed: {
    tabs () {
      return [
        {
          icon: 'user',
          name: this.$t('profile'),
          route: 'settings.profile'
        },
        {
          icon: 'lock',
          name: this.$t('password'),
          route: 'settings.password'
        }
      ]
    }
  }
}
</script>

<style scoped lang="scss">
@import "../../../sass/vars";

.settings {
  width: 100%;
  margin-top: 20px;
  h1 {
    color: #FFF;
    margin-top: 0;
    font-weight: bold;
    margin-bottom: 20px;
  }
  .tabs {
    margin-bottom: 0;
    ul {
      border-bottom: none;
    }
    li {
      width: 100%;
      &:first-child a {
        border-top-left-radius: 5px;
      }
      &:last-child a {
        border-top-right-radius: 5px;
      }
      a {
        color: #FFF;
        background: $gradient-article;
        svg {
          margin-right: 10px;
        }
        &.active {
          background: linear-gradient(to bottom, #DA4453 0%, #89216B 100%);
        }
        &:hover {
          background: linear-gradient(to bottom, #DA4453 0%, #89216B 100%);
        }
      }
    }
  }
  .tabs-content {
    background-color: #191d3b;
    border-radius: 0 0 5px 5px;
  }
}
@media only screen and (max-width: 480px) {
  .settings {
    h1 {
      font-size: 16px;
    }
    .tabs ul {
      font-size: 14px;
    }
  }
}
</style>
