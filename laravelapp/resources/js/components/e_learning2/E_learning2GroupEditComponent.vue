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
  props: {
    groupId: 0
  },
  data: function () {
    return {
      group: {},
    }
  },
  methods: {
    getgroup() {
      axios.get('/api/e_learning2/group/' + this.groupId)
        .then((res) => {
          this.group = res.data;
        });
    },
    submit() {
      axios.put('/api/e_learning2/group/' + this.groupId, this.group)
        .then((res) => {
          this.$router.push({name: 'tc.grouplist'})
        });
    }
  },
  mounted() {
    this.getgroup();
  }
}
</script>