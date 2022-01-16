<template>
  <div>
    <header>
      <Header />
    </header>
    <main>
      <div class="container-fluid">
        <RouterView />
      </div>
    </main>
  </div>
</template>

<script>
import Header from './E_learning2StHeaderComponent.vue'
export default {
  components: {
    Header,
  },
  mounted() {
    if(!this.$store.getters['auth_e_learning2/check'] || this.$store.getters['auth_e_learning2/role'] != 10)
      this.$router.push(`/e_learning2/login`)
  }
}
</script>