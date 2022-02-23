<template>
  <div class="container-fluid">
    <button class="btn btn-success" @click="back">戻る</button>
    <h3>{{ name }}</h3>
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
</template>

<script>
import XLSX from 'xlsx'
export default {
  props: {
    id: 0,
    name: String
  },
  data: function () {
    return {
      answers: [],
      n: 0
    }
  },
  methods: {
    getAnswers() {
      axios.get('/api/e_learning2/st/answer/'+ this.id + '/' + this.$store.getters['auth_e_learning2/e_classes_id'])
        .then((res) => {
          this.answers = res.data;
          for(let i = 0; i < this.answers.length; i++) {
            if(this.n < this.answers[i].length)
              this.n = this.answers[i].length;
          }
        });
    },
    downloadExcelFile() {
      const data = this.$refs.table
      const wb = XLSX.utils.table_to_book(data);
      XLSX.writeFile(wb,'e_learning2_answer_list.xlsx');
    },
    back(){
      this.$router.push(`/e_learning2/tc`);
    }
  },
  mounted() {
    this.getAnswers();
  }
}
</script>