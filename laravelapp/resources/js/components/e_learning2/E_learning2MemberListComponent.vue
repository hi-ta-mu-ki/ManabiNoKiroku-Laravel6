<template>
  <div class="container">
    <h2 class="title">クラス生徒一覧</h2>
    <div class="bg-primary mb-1">
      <div class="p-1 mb-1 bg-primary text-white form-inline row">
        <div class="form-group col-4">
          <label for="selectclass" class="mr-2">クラスを選択：</label>
          <select class="form-control" id="selectclass" @change="jump" v-model="e_classes_id">
            <option v-for="classes_menu in classes_menus" :key="classes_menu.id" v-bind:value="classes_menu.id" >{{ classes_menu.name }}</option>
          </select>
          <div v-if="isClassSelect">
            <button class="btn btn-success ml-2" @click="openModal">メンバーを追加</button>
            <MemberAdd :e_classes_id="e_classes_id" @from-child="closeModal" />
          </div>
        </div>
      </div>
    </div>
    <div v-if="isClassSelect">
      <table class="table table-hover">
        <thead class="thead-light">
        <tr>
          <th scope="col">名前</th>
          <th scope="col">役割</th>
          <th scope="col"></th>
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
              <div v-if="user.user.role == 10">
                <router-link v-bind:to="{name: 'tc.answer3', params: {id: user.user_id, name: user.user.name }}">
                  <button class="btn btn-warning">成績</button>
                </router-link>
              </div>
            </td>
            <td>
              <button class="btn btn-danger" v-confirm="onAlert(user.user_id)">削除</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
import MemberAdd from './E_learning2MemberAddComponent.vue'
export default {
  components: {
    MemberAdd
  },
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
      axios.get('/api/e_learning2/member_list/' + this.e_classes_id)
        .then((res) => {
          this.users = res.data;
        });
    },
    makeAdmin:function(dialog, id) {
      axios.delete('/api/e_learning2/st/answer/' + id);
      axios.delete('/api/e_learning2/member_list/' + id);
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
          body: 'この生徒の成績も削除します。よろしいですか？'
        }
      };
    },
    jump: function() {
      this.$store.commit('auth_e_learning2/setE_Classes_Id', this.e_classes_id)
      this.isClassSelect = true;
      this.getusers();
    },
    openModal: function(){
      this.$modal.show('modal_member_add');
    },
    closeModal: function(){
      this.$modal.hide('modal_member_add');
      this.getusers();
    },
  },
  mounted() {
    this.getClassesMenu();
  }
}
</script>