<template>
  <div class="container-fluid">
    <h2 class="title">問題一覧</h2>
    <div class="bg-primary mb-1">
      <div class="p-1 mb-1 bg-primary text-white form-inline row">
        <div class="form-group col-2">
          <label for="selectgroup" class="mr-2">グループを選択：</label>
            <select class="form-control" id="selectgroup" @change="jump1" v-model="e_groups_id">
              <option v-for="groups_menu in groups_menus" :key="groups_menu.id" v-bind:value="groups_menu.id" >{{ groups_menu.name }}</option>
            </select>
        </div>
        <div class="form-group col-10">
          <label for="selectsection" class="mr-2">セクションを選択：</label>
         <select class="form-control" id="selectsection" @change="jump2" v-model="no">
            <option v-for="question in questions_menu" :key="question.no" v-bind:value="question.no" >{{ question.quest }}</option>
          </select>
        </div>
      </div>
    </div>
    <div v-if="isGroupSelect">
      <table class="table table-hover">
        <thead class="thead-light">
        <tr>
          <th scope="col">ID</th>
          <th scope="col">セクション番号</th>
          <th scope="col">問題番号</th>
          <th scope="col">問題</th>
          <th scope="col"></th>
          <th scope="col"></th>
          <th scope="col"></th>
        </tr>
        </thead>
        <tbody>
          <tr v-for="question in questions" :key="question.id">
            <th scope="row">{{ question.id }}</th>
            <td>{{ question.no }}</td>
            <td>{{ question.q_no }}</td>
            <td>
              <div v-if="question.q_no == 0">
                <strong>【セクションタイトル】<p v-html="$sanitize(question.quest)"></p></strong>
              </div>
              <div v-else>
                <p v-html="$sanitize(question.quest)"></p>
              </div>
            </td>
            <td>
              <div v-if="question.q_no != 0">
                <router-link v-bind:to="{name: 'tc.show', params: {questionId: question.id }}">
                  <button class="btn btn-primary">プレビュー</button>
                </router-link>
              </div>
              <div v-else>
                <router-link v-bind:to="{name: 'tc.answer', params: {no: question.no }}">
                  <button class="btn btn-warning">生徒の成績</button>
                </router-link>
              </div>
            </td>
            <td>
              <router-link v-bind:to="{name: 'tc.edit', params: {questionId: question.id }}">
                <button class="btn btn-success">編集</button>
              </router-link>
            </td>
            <td>
              <button class="btn btn-danger" @click="deleteQuestion(question.id)">削除</button>
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
      groups_menus: [],
      e_groups_id: 0,
      isGroupSelect: false,
      no: '',
      questions_menu: [],
      questions: []
    }
  },
  methods: {
    getGroupsMenu() {
      axios.get('/api/e_learning2/groups_menu')
        .then((res) => {
          this.groups_menus = res.data;
        });
    },
    jump1: function() {
      this.$store.commit('auth_e_learning2/setE_Groups_Id', this.e_groups_id)
      this.isGroupSelect = true
      this.getQuestionsMenu();
    },
    getQuestionsMenu() {
//      axios.get('/api/e_learning2/tc_menu/' + this.e_groups_id)
      axios.get('/api/e_learning2/tc_menu/' + this.$store.getters['auth_e_learning2/e_groups_id'])
        .then((res) => {
          this.questions_menu = res.data;
        });
    },
    getQuestions() {
      axios.get('/api/e_learning2/tc/'+ this.$store.getters['auth_e_learning2/e_groups_id'] +'/' + this.no)
        .then((res) => {
          this.questions = res.data;
        });
    },
    deleteQuestion(id) {
      axios.delete('/api/e_learning2/tc/' + id)
        .then((res) => {
          this.getQuestions();
        });
    },
    jump2: function() {
      this.getQuestions();
//      this.$router.push(`/e_learning2/tc/list/${this.no}`)
    },
  },
  mounted() {
    this.getGroupsMenu();
  }
}
</script>