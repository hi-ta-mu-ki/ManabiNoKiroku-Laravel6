<template>
  <div class="container-fluid">
    <h3>{{ questions[0].quest }}</h3>
    <table class="table table-hover table-sm" ref="table">
      <thead class="thead-light">
      <tr>
        <th scope="col">名前</th>
        <th scope="col">メールアドレス</th>
        <th scope="col">解答時刻</th>
        <th scope="col" v-for="i in n - 1" :key="i">問題{{ i }}</th>
      </tr>
      </thead>
      <tbody>
        <tr v-for="answer in answers" :key="answer.id">
          <td v-for="i in n + 2" :key="i">{{ answer[i] }}</td>
        </tr>
      </tbody>
    </table>
    <button class="btn btn-success" @click="downloadExcelFile()">Excelにダウンロード</button>
  </div>
</template>

<script>
import XLSX from 'xlsx'
export default {
  props: {
    no: String,
  },
  data: function () {
    return {
      questions: [],
      answers: [],
      n: 0
    }
  },
  methods: {
    getQuestions() {
      axios.get('/api/e_learning2/question/'+ this.$store.getters['auth_e_learning2/e_groups_id'] +'/' + this.no)
        .then((res) => {
          this.questions = res.data
          this.n = this.questions.length - 1
        });
    },
    getAnswers() {
      axios.get('/api/e_learning2/question/answer/'+ this.$store.getters['auth_e_learning2/e_groups_id'] +'/' + this.no)
        .then((res) => {
          this.answers = res.data
        });
    },
    downloadExcelFile() {
      const data = this.$refs.table
      const wb = XLSX.utils.table_to_book(data)
      XLSX.writeFile(wb,'e_learning2_answer_list.xlsx')
    },
  },
  mounted() {
    this.getAnswers()
    this.getQuestions()
  }
}
</script>