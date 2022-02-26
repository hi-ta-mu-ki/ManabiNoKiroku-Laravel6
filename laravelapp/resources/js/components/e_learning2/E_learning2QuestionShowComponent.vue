<template>
  <div class="container-fluid">
    <div class="row justify-content-center" v-if="!answered">
      <div class="col-sm-12">
        <h3>げんざい，〇もんちゅう〇もんせいかい</h3>
        <h1><p class="badge badge-primary">だい {{ currentQuestion.q_no }} もん</p></h1>
        <br>
        <div class="text-primary">
          <h4><span v-html="$sanitize(currentQuestion.quest)"></span></h4>
        </div>
        <hr>
        <div class="container">
          <button type="button" class="btn btn-primary btn-lg btn-block text-left"
            @click="addAnswer(1)"> 1 . <span v-html="$sanitize(currentQuestion.ans1)"></span></button>
          <button type="button" class="btn btn-primary btn-lg btn-block text-left"
            @click="addAnswer(2)"> 2 . <span v-html="$sanitize(currentQuestion.ans2)"></span></button>
          <button type="button" class="btn btn-primary btn-lg btn-block text-left"
            @click="addAnswer(3)"> 3 . <span v-html="$sanitize(currentQuestion.ans3)"></span></button>
          <button type="button" class="btn btn-primary btn-lg btn-block text-left"
            @click="addAnswer(4)"> 4 . <span v-html="$sanitize(currentQuestion.ans4)"></span></button>
        </div>
      </div>
    </div>
    <div class="row justify-content-center" v-else-if="answered">
      <div class="col-sm-12">
        <h3>〇もんちゅう〇もんせいかい</h3>
        <h1><p class="badge badge-primary">だい {{ currentQuestion.q_no }} もん</p></h1>
        <br>
        <div class="text-primary">
          <h4><span v-html="$sanitize(currentQuestion.quest)"></span></h4>
        </div>
        <h4><table border = 0>
        <tr><td width = "5%" class="text-center"><span v-if="currentQuestion.ans == 1">〇</span><span v-else>×</span></td><td>　1 . <span v-html="$sanitize(currentQuestion.ans1)"></span></td></tr>
        <tr><td width = "5%" class="text-center"><span v-if="currentQuestion.ans == 2">〇</span><span v-else>×</span></td><td>　2 . <span v-html="$sanitize(currentQuestion.ans2)"></span></td></tr>
        <tr><td width = "5%" class="text-center"><span v-if="currentQuestion.ans == 3">〇</span><span v-else>×</span></td><td>　3 . <span v-html="$sanitize(currentQuestion.ans3)"></span></td></tr>
        <tr><td width = "5%" class="text-center"><span v-if="currentQuestion.ans == 4">〇</span><span v-else>×</span></td><td>　4 . <span v-html="$sanitize(currentQuestion.ans4)"></span></td></tr>
        </table></h4>
        <hr>
        <h4>
          <span v-if="currentQuestion.ans == answers[0]"><div class="text-primary ml-3">あなたのこたえは「{{answers[0]}}」　せいかい！！</div></span>
          <span v-else><div class="text-danger ml-3">あなたのこたえは「{{answers[0]}}」　まちがい。。。　せいかいは「{{ currentQuestion.ans }}」でした。</div></span><br>
          <h3><span class="badge badge-primary ml-3">かいせつ</span></h3>
          <span v-if="currentQuestion.exp1 != null"><div class="ml-3">　1 . <span v-html="$sanitize(currentQuestion.exp1)"></span></div></span>
          <span v-if="currentQuestion.exp2 != null"><div class="ml-3">　2 . <span v-html="$sanitize(currentQuestion.exp2)"></span></div></span>
          <span v-if="currentQuestion.exp3 != null"><div class="ml-3">　3 . <span v-html="$sanitize(currentQuestion.exp3)"></span></div></span>
          <span v-if="currentQuestion.exp4 != null"><div class="ml-3">　4 . <span v-html="$sanitize(urrentQuestion.exp4)"></span></div></span>
          <span v-if="currentQuestion.exp0 != null"><div class="ml-3"><span v-html="$sanitize(currentQuestion.exp0)"></span></div></span>
        </h4>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    questionId: 0
  },
  data: function () {
    return {
      answers: [],
      questions: [],
      answered: false,
      correct: 0,
    }
  },
  methods: {
    getQuestions() {
      axios.get('/api/e_learning2/question/' + this.questionId)
        .then((res) => {
          this.questions = res.data;
        });
    },
    addAnswer: function(index) {
      this.answers.push(index);
      return this.answered = true;
    },
    },
  computed: {
    currentQuestion: function() {
      return this.questions;
    },
  },
  mounted() {
    this.getQuestions();
  }
}
</script>
