<template>
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-sm-12">
        <div class="row mb-1">
          <table border=1><tr><td>
            【ヘルプ】　※HTMLのタグを使えば次のようなことなどができます。<br>
            　・改行したいところで&lt;br&gt;という記号を入力します。<br>
            　・上付き文字は，&lt;sup&gt;2&lt;/sup&gt;のように入力します。（例）10&lt;sup&gt;2&lt;/sup&gt;　は　10<sup>2</sup><br>
            　・下付き文字は，&lt;sub&gt;2&lt;/sub&gt;のように入力します。（例）10&lt;sub&gt;2&lt;/sub&gt;　は　CO<sub>2</sub><br>
            　・画像は，アップロードしたファイル名を用いて，&lt;img src="/storage/ファイル名"&gt;のように，挿入したい部分に入力します。
          </td></tr></table>
        </div>
        <div class="row mb-1">
          <button class="btn btn-success" @click="showForm = ! showForm">Upload Image</button>
        </div>
        <div class="row mb-1">
          <E_learning2PhotoUploadForm v-model="showForm" />
        </div>
        <form @submit.prevent="submit">
          <div class="form-group row">
            <label for="no" class="col-sm-1 col-form-label">S_No</label>
            <input type="number" class="col-sm-1 form-control" id="no" v-model="question.no">
          </div>
          <div class="form-group row">
            <label for="q_no" class="col-sm-1 col-form-label">Q_No</label>
            <input type="number" class="col-sm-1 form-control" id="q_no" v-model="question.q_no">
          </div>
          <div class="form-group row">
            <label for="quest" class="col-sm-1 col-form-label text-primary">Question</label>
            <textarea-autosize class="col-sm-11 form-control text-primary" id="quest" v-model="question.quest"></textarea-autosize>
          </div>
          <div class="form-group row">
            <label for="ans1" class="col-sm-1 col-form-label">Answer1</label>
            <textarea-autosize class="col-sm-11 form-control" id="ans1" v-model="question.ans1"></textarea-autosize>
          </div>
          <div class="form-group row">
            <label for="ans2" class="col-sm-1 col-form-label">Answer2</label>
            <textarea-autosize class="col-sm-11 form-control" id="ans2" v-model="question.ans2"></textarea-autosize>
          </div>
          <div class="form-group row">
            <label for="ans3" class="col-sm-1 col-form-label">Answer3</label>
            <textarea-autosize class="col-sm-11 form-control" id="ans3" v-model="question.ans3"></textarea-autosize>
          </div>
          <div class="form-group row">
            <label for="ans4" class="col-sm-1 col-form-label">Answer4</label>
            <textarea-autosize class="col-sm-11 form-control" id="ans4" v-model="question.ans4"></textarea-autosize>
          </div>
          <div class="form-group row">
            <label for="ans" class="col-sm-1 col-form-label text-danger">Correct Answer</label>
            <select class="col-sm-1 form-control" v-model="question.ans">
              <option disabled value="">Select Number</option>
              <option v-bind:value="1">1</option>
              <option v-bind:value="2">2</option>
              <option v-bind:value="3">3</option>
              <option v-bind:value="4">4</option>
            </select>
          </div>
          <div class="form-group row">
            <label for="exp1" class="col-sm-1 col-form-label">Explanation1</label>
            <textarea-autosize class="col-sm-11 form-control" id="exp1" v-model="question.exp1"></textarea-autosize>
          </div>
          <div class="form-group row">
            <label for="exp2" class="col-sm-1 col-form-label">Explanation2</label>
            <textarea-autosize class="col-sm-11 form-control" id="exp2" v-model="question.exp2"></textarea-autosize>
          </div>
          <div class="form-group row">
            <label for="exp3" class="col-sm-1 col-form-label">Explanation3</label>
            <textarea-autosize class="col-sm-11 form-control" id="exp3" v-model="question.exp3"></textarea-autosize>
          </div>
          <div class="form-group row">
            <label for="exp4" class="col-sm-1 col-form-label">Explanation4</label>
            <textarea-autosize class="col-sm-11 form-control" id="exp4" v-model="question.exp4"></textarea-autosize>
          </div>
          <div class="form-group row">
            <label for="exp0" class="col-sm-1 col-form-label">Explanation</label>
            <textarea-autosize class="col-sm-11 form-control" id="exp0" v-model="question.exp0"></textarea-autosize>
          </div>
          <button type="submit" class="btn btn-primary">Submit</button>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import E_learning2PhotoUploadForm from './E_learning2PhotoUploadForm.vue'
export default {
  components: {
    E_learning2PhotoUploadForm
  },
  props: {
    questionId: 0
  },
  data: function () {
    return {
      question: {},
      showForm: false
    }
  },
  methods: {
    getQuestion() {
      axios.get('/api/e_learning2/tc/' + this.questionId)
        .then((res) => {
          this.question = res.data;
        });
    },
    submit() {
      axios.put('/api/e_learning2/tc/' + this.questionId, this.question)
        .then((res) => {
          this.$router.push({name: 'tc.list'})
        });
    }
  },
  mounted() {
    this.getQuestion();
  }
}
</script>