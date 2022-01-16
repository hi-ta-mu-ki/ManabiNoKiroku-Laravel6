<template>
  <div class="container-fluid bg-primary mb-3 text-white">
    <nav class="navbar navbar-primary">
      <span class="navbar-brand mb-0 h1">E-Learning Teacher Menu</span>
      <div>
        <router-link v-bind:to="{name: 'tc.class'}">
        <button class="btn btn-success">Class List</button>
        </router-link>
        <router-link v-bind:to="{name: 'tc.setting'}">
          <button class="btn btn-success">Setting</button>
        </router-link>
        <router-link v-bind:to="{name: 'tc.list'}">
          <button class="btn btn-success">Question List</button>
        </router-link>
        <router-link v-bind:to="{name: 'tc.create'}">
          <button class="btn btn-success">Question ADD</button>
        </router-link>
        <router-link v-bind:to="{name: 'tc.import'}">
          <button class="btn btn-success">Question CSV Import</button>
        </router-link>
        <button class="btn btn-secondary" @click="logout">Logout</button>
      </div>
    </nav>
  </div>
</template>

<script>
import { mapState } from 'vuex'
export default {
  computed: {
    ...mapState({
      apiStatus: state => state.auth_e_learning2.apiStatus
    })
  },
  methods: {
    async logout () {
      await this.$store.dispatch('auth_e_learning2/logout')
      if (this.apiStatus) {
        this.$router.push('/e_learning2/login')
      }
    },
  },
}
</script>