<template>
  <aside class="sidebar mobile">
    <div class="main">
      <div v-if="user" class="user">
        <img :alt="user.nickname" :src="userPhoto" class="user__img">
        <div>
          <span class="user__name">
            {{ user.nickname }}
          </span>
          <span v-show="user.specialization" class="user__specs">
            {{ user.specialization }}
          </span>
        </div>
      </div>
      <nav class="content-nav">
        <ul>
          <li>
            <RouterLink :to="{ name: 'article' }" active-class="active" class="content-nav__category">
              <span class="content-nav__category__icon gradient-pink">
                <Fa :icon="['far', 'newspaper']" fixed-width />
              </span>
              <span class="content-nav__category__title">
                {{ $t('articles') }}
              </span>
            </RouterLink>
          </li>
          <li>
            <RouterLink :to="{ name: 'stream' }" active-class="active" class="content-nav__category">
              <span class="content-nav__category__icon gradient-purple-to-pink">
                <Fa :icon="'tv'" fixed-width />
              </span>
              <span class="content-nav__category__title">
                {{ $t('streams') }}
              </span>
            </RouterLink>
          </li>
          <li>
            <RouterLink :to="{ name: 'video' }" active-class="active" class="content-nav__category">
              <span class="content-nav__category__icon gradient-blue">
                <Fa :icon="['fab', 'youtube']" fixed-width />
              </span>
              <span class="content-nav__category__title">
                {{ $t('videos') }}
              </span>
            </RouterLink>
          </li>
          <li>
            <RouterLink :to="{ name: 'podcast' }" active-class="active" class="content-nav__category">
              <span class="content-nav__category__icon gradient-crimson">
                <Fa :icon="['fas', 'microphone']" fixed-width />
              </span>
              <span class="content-nav__category__title">
                {{ $t('podcasts') }}
              </span>
            </RouterLink>
          </li>
          <hr>
          <li>
            <RouterLink :to="{ name: 'settings.profile' }" active-class="active" class="content-nav__category">
              <span class="content-nav__category__icon gradient-clear">
                <Fa icon="cog" fixed-width />
              </span>
              <span class="content-nav__category__title">
                {{ $t('settings') }}
              </span>
            </RouterLink>
          </li>
        </ul>
      </nav>
    </div>
  </aside>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
  name: 'WSidebarMobile',

  computed: mapGetters({
    user: 'auth/user',
    userPhoto: 'auth/userPhoto'
  })
}
</script>

<style scoped lang="scss">
@import "../../sass/vars";

@media #{$mobile} {
    aside.sidebar {
        &.mobile {
            display: flex;
            background-image: none;
            background: transparent;
            box-shadow: none;
            .content-nav ul {
                flex-direction: column;
                width: 100%;
                hr {
                    background-color: #1e1f3f;
                }
                li {
                    margin-right: 0;
                }
            }
        }
        .user {
            display: flex;
        }
    }
}
</style>
