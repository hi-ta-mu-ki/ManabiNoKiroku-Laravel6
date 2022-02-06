<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-sm-12">
        <form @submit.prevent="submit">
          <div class="form-group row">
            <label for="name" class="col-sm-1 col-form-label">Group Name</label>
            <input type="text" class="col-sm-11 form-control" id="name" v-model="group.name">
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
      group: {}
    }
  },
  methods: {
    submit() {
      axios.post('/api/e_learning2/group', this.group)
        .then((res) => {
          this.$router.push({name: 'tc.grouplist'});
        });
    }
  }
}
</script>