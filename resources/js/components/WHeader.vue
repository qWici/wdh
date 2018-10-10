<template>
    <header>
        <div class="box">
            <router-link :to="{ name: user ? 'home' : 'welcome' }" class="logo">
                <img src="/img/logo.png" alt="">
            </router-link>

            <nav v-if="user">
                User
                <a href="#" @click.prevent="logout">
                    <fa icon="sign-out-alt" fixed-width/>
                    {{ $t('logout') }}
                </a>
            </nav>

            <nav v-else>
                <ul>
                    <li>
                        <router-link :to="{ name: 'welcome' }" active-class="active">
                            {{ $t('home') }}
                        </router-link>
                    </li>
                    <li>
                        <router-link :to="{ name: 'login' }" active-class="active">
                            {{ $t('login') }}
                        </router-link>
                    </li>
                    <li>
                        <router-link :to="{ name: 'register' }" active-class="active">
                            {{ $t('register') }}
                        </router-link>
                    </li>
                </ul>
            </nav>
        </div>
    </header>
</template>

<script>
  import { mapGetters } from 'vuex'

  export default {
    components: {},
    data: () => ({}),

    computed: mapGetters({
      user: 'auth/user'
    }),

    methods: {
      async logout () {
        // Log out the user.
        await this.$store.dispatch('auth/logout')

        // Redirect to login.
        this.$router.push({ name: 'login' })
      }
    }
  }
</script>