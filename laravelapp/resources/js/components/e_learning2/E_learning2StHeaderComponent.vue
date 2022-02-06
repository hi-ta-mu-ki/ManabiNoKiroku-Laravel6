<template>
  <div class="container-fluid bg-primary mb-3 text-white">
    <nav class="navbar navbar-primary">
      <span class="navbar-brand mb-0 h1">E-Learning</span>
      <div class="col-sm-2">
        <router-link v-bind:to="{name: 'st.join'}">
          <button class="btn btn-success">Join New Class</button>
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