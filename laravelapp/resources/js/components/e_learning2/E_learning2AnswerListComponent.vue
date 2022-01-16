<template>
  <div class="container-fluid">
    <h3>{{ questions[0].quest }}</h3>
    <table class="table table-hover table-sm" ref="table">
      <thead class="thead-light">
      <tr>
        <th scope="col">Name</th>
        <th scope="col">E_Mail</th>
        <th scope="col">Answer Time</th>
        <th scope="col" v-for="i in n - 1" :key="i">Q_no{{ i }}</th>
      </tr>
      </thead>
      <tbody>
        <tr v-for="answer in answers" :key="answer.id">
          <td v-for="i in n + 2" :key="i">{{ answer[i] }}</td>
        </tr>
      </tbody>
    </table>
    <button class="btn btn-success" @click="downloadExcelFile()">Excel Download</button>
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
      axios.get('/api/e_learning2/tc/list/' + this.no)
        .then((res) => {
          this.questions = res.data;
          this.n = this.questions.length - 1;
        });
    },
    getAnswers() {
      axios.get('/api/e_learning2/tc/answer/' + this.no)
        .then((res) => {
          this.answers = res.data;
        });
    },
    downloadExcelFile() {
      const data = this.$refs.table
      const wb = XLSX.utils.table_to_book(data);
      XLSX.writeFile(wb,'e_learning2_answer_list.xlsx');
    },
  },
  mounted() {
    this.getAnswers();
    this.getQuestions();
  }
}
</script>