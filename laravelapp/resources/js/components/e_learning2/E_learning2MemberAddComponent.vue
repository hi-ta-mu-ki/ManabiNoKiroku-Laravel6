<template>
  <modal name="modal_member_add" :draggable="true" :resizable="true" :scrollable="true" width="30%" height="auto">
    <div id="overlay">
      <div id="content">
        <div class="container-fluid">
          <form @submit.prevent="submit">
            <div class="form-group row">
              <input type="text" v-model="keyword">
            </div>
            <div class="text-secondary">
              <table>
                <tr v-for="users in filteredUsers" :key="users.id">
                  <td v-text="users.name"></td>
                </tr>
              </table>
            </div>
            <div v-if="isMsg"><div class="alert alert-danger" role="alert">{{ msg }}</div></div>
            <div v-if="cnt == 1">
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
            <div v-else>
              <button class="btn btn-secondary" @click="clickEvent">Cancel</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </modal>
</template>

<script>
export default {
  name: 'MemberAdd',
  props: {
    e_classes_id: 0
  },
  data: function () {
    return {
      users: [],
      keyword: "",
      cnt: 0,
      joinForm: {
        id: 0
      },
      msg: '',
      isMsg: false
    }
  },
  methods: {
    getusers() {
      axios.get('/api/e_learning2/join2')
        .then((res) => {
          this.users = res.data;
        });
    },
    clickEvent: function() {
      this.$emit('from-child');
    },
    submit() {
      axios.post('/api/e_learning2/join2/' + this.e_classes_id, this.joinForm)
        .then((res) => {
          if(res.status== 201)
            this.$emit('from-child');
          else{
            this.isMsg = true;
            this.msg = '登録できません';
          }
        });
    },
  },
  computed: {
    filteredUsers: function() {
    var users = [];
    for(var i in this.users) {
        var user  = this.users[i];
        if(user.name.indexOf(this.keyword) !== -1) {
            users.push(user);
        }
        this.cnt = users.length;
        if(this.cnt == 1) this.joinForm.id = users[0].id;
    }
    return users;
    }
  },
  mounted() {
    this.getusers();
  }
}
</script>