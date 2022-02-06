<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-sm-12">
        <form @submit.prevent="submit">
          <div class="form-group row">
            <label for="name" class="col-sm-1 col-form-label">Class Name</label>
            <input type="text" class="col-sm-11 form-control" id="name" v-model="clas.name">
            <label for="pass_code" class="col-sm-1 col-form-label">Pass Code</label>
            <input type="text" class="col-sm-11 form-control" id="pass_code" v-model="clas.pass_code">
          </div>
          <div v-if="isMsg"><div class="alert alert-danger" role="alert">{{ msg }}</div></div>
          <button type="submit" class="btn btn-primary">Submit</button>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    classId: 0
  },
  data: function () {
    return {
      clas: {},
      msg: '',
      isMsg: false
    }
  },
  methods: {
    getclass() {
      axios.get('/api/e_learning2/class/' + this.classId)
        .then((res) => {
          this.clas = res.data;
        });
    },
    submit() {
      axios.put('/api/e_learning2/class/' + this.classId, this.clas)
        .then((res) => {
          if(res.status== 200)
            this.$router.push({name: 'tc.classlist'})
          else{
            this.isMsg = true;
            this.msg = 'すでに使用されているパスコードです';
          }
        });
    }
  },
  mounted() {
    this.getclass();
  }
}
</script>