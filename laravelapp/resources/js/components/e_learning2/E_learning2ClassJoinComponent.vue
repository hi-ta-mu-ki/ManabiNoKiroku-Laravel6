<template>
  <div class="container">
    <h2 class="title">クラスにさんかする</h2>
    <div class="row justify-content-center">
      <div class="col-sm-12">
        <form @submit.prevent="submit">
          <div class="form-group row">
            <label for="pass_code" class="col-sm-2 col-form-label">パスコード</label>
            <input type="text" class="col-sm-6 form-control" id="pass_code" v-model="joinForm.pass_code" placeholder="参加のためのパスコードを入力">
          </div>
          <div v-if="isMsg">
            <div class="alert alert-danger" role="alert">{{ msg }}</div>
          </div>
          <button type="submit" class="btn btn-primary">さんかする</button>
          <button type="button" class="btn btn-secondary" @click="cansel">キャンセル</button>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data: function () {
    return {
      joinForm: {
        pass_code: '',
      },
      msg: '',
      isMsg: false
    }
  },
  methods: {
    submit() {
      axios.post('/api/e_learning2/class_join2', this.joinForm)
        .then((res) => {
          if(res.status== 201){
            if (this.$store.getters['auth_e_learning2/role'] == 5)
              this.$router.push(`/e_learning2/tc`)
            else if (this.$store.getters['auth_e_learning2/role'] == 10)
              this.$router.push(`/e_learning2/st`)
          }else{
            this.isMsg = true;
            this.msg = 'パスコードがむこうです'
          }
        })
    },
    cansel: function() {
            if (this.$store.getters['auth_e_learning2/role'] == 5)
              this.$router.push(`/e_learning2/tc`)
            else if (this.$store.getters['auth_e_learning2/role'] == 10)
              this.$router.push(`/e_learning2/st`)
    }
  },
}
</script>