<template>
  <div class="container-fluid">
    <h2 class="title">生徒個人記録</h2>
    <div class="bg-primary mb-1">
      <div class="p-1 mb-1 bg-primary text-white form-inline row">
        <div class="form-group col-4">
          <label for="selectclass" class="mr-2">クラスを選択：</label>
          <select class="form-control" id="selectclass" @change="jump1" v-model="e_classes_id">
            <option v-for="classes_menu in classes_menus" :key="classes_menu.id" v-bind:value="classes_menu.id" >{{ classes_menu.name }}</option>
          </select>
          <div v-if="isClassSelect">
            <div class="form-group">
              <label for="selectuser" class="ml-2 mr-2">生徒を選択：</label>
              <select class="form-control" id="selectuser" @change="jump2" v-model="user_id">
                <option v-for="user in users" :key="user.user_id" v-bind:value="user.user_id" >{{ user.name }}</option>
              </select>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div v-if="isUserSelect">
      <table class="table table-hover table-sm" ref="table">
        <thead class="thead-light">
        <tr>
          <th scope="col">セクション名</th>
          <th scope="col">解答時刻</th>
          <th scope="col" v-for="i in n - 3" :key="i">問題{{ i }}</th>
        </tr>
        </thead>
        <tbody>
          <tr v-for="answer in answers" :key="answer.id">
            <td v-for="i in n - 1" :key="i">{{ answer[i] }}</td>
          </tr>
        </tbody>
      </table>
      <button class="btn btn-success" @click="downloadExcelFile()">Excelにダウンロード</button>
    </div>
  </div>
</template>

<script>
import XLSX from 'xlsx'
export default {
  data: function () {
    return {
      classes_menus: [],
      isClassSelect: false,
      users: [],
      e_classes_id: 0,
      answers: [],
      n: 0,
      user_id: 0,
      isUserSelect: false
    }
  },
  methods: {
    getClassesMenu() {
      axios.get('/api/e_learning2/classes_menu')
        .then((res) => {
          this.classes_menus = res.data
        })
    },
    getUsers() {
      axios.get('/api/e_learning2/member_list2/' + this.e_classes_id)
        .then((res) => {
          this.users = res.data
        })
    },
    getAnswers() {
      axios.get('/api/e_learning2/st/answer/'+ this.user_id + '/' + this.$store.getters['auth_e_learning2/e_classes_id'])
        .then((res) => {
          this.answers = res.data
          for(let i = 0; i < this.answers.length; i++) {
            if(this.n < this.answers[i].length)
              this.n = this.answers[i].length;
          }
        });
    },
    downloadExcelFile() {
      const data = this.$refs.table
      const wb = XLSX.utils.table_to_book(data)
      XLSX.writeFile(wb,'e_learning2_answer_list.xlsx')
    },
    jump1: function() {
      this.$store.commit('auth_e_learning2/setE_Classes_Id', this.e_classes_id)
      this.isClassSelect = true
      this.getUsers()
    },
    jump2: function() {
      this.isUserSelect = true
      this.getAnswers()
    },
  },
  mounted() {
    this.getClassesMenu()
  }
}
</script>