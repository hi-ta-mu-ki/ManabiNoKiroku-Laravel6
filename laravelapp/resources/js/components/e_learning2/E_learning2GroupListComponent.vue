<template>
  <div class="container">
    <div class="bg-primary mb-1">
      <div class="p-1 mb-1 bg-primary text-white form-inline row">
        <router-link v-bind:to="{name: 'tc.groupcreate'}">
          <button class="btn btn-success">Group ADD</button>
        </router-link>
      </div>
    </div>
    <table class="table table-hover">
      <thead class="thead-light">
        <tr>
          <th scope="col">ID</th>
          <th scope="col">Group Name</th>
          <th scope="col"></th>
          <th scope="col"></th>
          <th scope="col"></th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="group in groups" :key="group.id">
          <th scope="row">{{ group.id }}</th>
          <td>{{ group.name }}</td>
          <td>
            <router-link v-bind:to="{name: 'tc.groupedit', params: {groupId: group.id }}">
              <button class="btn btn-success">Edit</button>
            </router-link>
          </td>
          <td>
            <button class="btn btn-danger" v-confirm="onAlert(group.id)">Delete</button>
          </td>
          <td>
            <router-link v-bind:to="{name: 'tc.classlist', params: {groupId: group.id }}">
              <button class="btn btn-success">Class Setting</button>
            </router-link>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
export default {
  data: function () {
    return {
      groups: [],
    }
  },
  methods: {
    getgroups() {
      axios.get('/api/e_learning2/group')
        .then((res) => {
          this.groups = res.data;
        });
    },
    makeAdmin:function(dialog, id) {
      axios.delete('/api/e_learning2/group/' + id);
      this.getgroups();
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
            body: 'このグループの問題，クラス，所属する生徒，成績のすべてを削除します。よろしいですか？'
          }
      };
    }
  },
  mounted() {
    this.getgroups();
  }
}
</script>