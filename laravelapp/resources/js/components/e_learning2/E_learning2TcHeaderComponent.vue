<template>
  <div class="container-fluid bg-primary mb-3 text-white">
    <nav class="navbar navbar-primary">
      <span class="navbar-brand mb-0 h1">まなびのきろく３　～先生メニュー～</span>
      <div>
        <router-link v-bind:to="{name: 'tc.grouplist'}">
        <button class="btn btn-success">グループ設定</button>
        </router-link>
        <router-link v-bind:to="{name: 'tc.member'}">
        <button class="btn btn-success">クラス生徒設定</button>
        </router-link>
        <router-link v-bind:to="{name: 'tc.record'}">
          <button class="btn btn-success">生徒個人記録</button>
        </router-link>
        <router-link v-bind:to="{name: 'tc.setting'}">
          <button class="btn btn-success">問題実施設定</button>
        </router-link>
        <router-link v-bind:to="{name: 'tc.questionlist'}">
          <button class="btn btn-success">問題一覧</button>
        </router-link>
        <router-link v-bind:to="{name: 'tc.questioncreate'}">
          <button class="btn btn-success">問題作成</button>
        </router-link>
        <router-link v-bind:to="{name: 'tc.questionimport'}">
          <button class="btn btn-success">問題 CSV インポート</button>
        </router-link>
        <router-link v-bind:to="{name: 'tc.join'}">
          <button class="btn btn-success">クラスに参加</button>
        </router-link>
        <button class="btn btn-secondary" @click="logout">ログアウト</button>
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