<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-sm-12">
        <form @submit.prevent="submit">
          <div class="form-group row">
            <label for="name" class="col-sm-1 col-form-label">Name</label>
            <input type="text" class="col-sm-11 form-control" id="name" v-model="user.name">
          </div>
          <div class="form-group row">
            <label for="email" class="col-sm-1 col-form-label">E_Mail</label>
            <input type="text" class="col-sm-11 form-control" id="email" v-model="user.email">
          </div>
          <div class="form-group row">
            <label for="password" class="col-sm-1 col-form-label text-primary">Password</label>
            <input type="text" class="col-sm-11 form-control text-primary" id="password" v-model="user.password">
          </div>
          <div class="form-group row">
            <label for="role" class="col-sm-1 col-form-label">Role</label>
            <select class="col-sm-11 form-control" v-model="user.role">
              <option value="">Select Role</option>
              <option v-bind:value="1">管理者</option>
              <option v-bind:value="5">教　員</option>
              <option v-bind:value="10">生　徒</option>
            </select>
          </div>
          <button type="submit" class="btn btn-primary">Submit</button>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data: function () {
    return {
      user: {}
    }
  },
  methods: {
    submit() {
      axios.post('/api/e_learning2/ad', this.user)
        .then((res) => {
          this.$router.push({name: 'ad.list'});
        });
    }
  }
}
</script>