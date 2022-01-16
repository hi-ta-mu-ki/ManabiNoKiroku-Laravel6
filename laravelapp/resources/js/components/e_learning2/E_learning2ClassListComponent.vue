<template>
  <div class="container-fluid">
    <div class="bg-primary mb-1">
      <div class="p-1 mb-1 bg-primary text-white form-inline row">
        <div class="form-group col-2">
          <label for="selectclass" class="mr-2">Select Class:</label>
          <select class="form-control" id="selectclass" @change="jump" v-model="e_classes_id">
            <option v-for="classes_menu in classes_menus" :key="classes_menu.id" v-bind:value="classes_menu.id" >{{ classes_menu.name }}</option>
          </select>
        </div>
      </div>
    </div>
    <div v-if="isClassSelect">
      <table class="table table-hover">
        <thead class="thead-light">
        <tr>
          <th scope="col">Name</th>
          <th scope="col">Role</th>
          <th scope="col"></th>
        </tr>
        </thead>
        <tbody>
          <tr v-for="user in users" :key="user.user.id">
            <td>{{ user.user.name }}</td>
            <td>
              <div v-if="user.user.role == 1">管理者</div>
              <div v-else-if="user.user.role == 5">教員</div>
              <div v-else>生徒</div>
            </td>
            <td>
              <button class="btn btn-danger" v-confirm="onAlert(user.user_id)">Delete</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
export default {
  data: function () {
    return {
      classes_menus: [],
      isClassSelect: false,
      users: [],
      e_classes_id: 0
    }
  },
  methods: {
    getClassesMenu() {
      axios.get('/api/e_learning2/classes_menu')
        .then((res) => {
          this.classes_menus = res.data;
        });
    },
    getusers() {
      axios.get('/api/e_learning2/class_list/' + this.e_classes_id)
        .then((res) => {
          this.users = res.data;
        });
    },
    makeAdmin:function(dialog, id) {
      axios.delete('/api/e_learning2/st/answer/' + id);
      axios.delete('/api/e_learning2/class_list/' + id);
      this.getusers();
      dialog.close();
    },
    doNothing:function() {
    },
    onAlert:function(id) {
      let self = this;
      return {
        ok: function(dialog){self.makeAdmin(dialog, id)},
        cancel: this.doNothing(),
        message: {
          title: '確認',
          body: '削除する生徒の成績も削除します。よろしいですか？'
        }
      };
    },
    jump: function() {
      this.isClassSelect = true;
      this.getusers();
    },
  },
  mounted() {
    this.getClassesMenu();
  }
}
</script>