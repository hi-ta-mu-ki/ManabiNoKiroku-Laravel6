<template>
  <div class="container-fluid">
    <div class="p-1 mb-3 bg-primary text-white form-inline">
      <div class="form-group">
        <label for="selectclass" class="p-2">Select Class:</label>
        <select class="form-control" id="selectclass" @change="jump1" v-model="e_classes_id">
          <option v-for="classes_menu in classes_menus" :key="classes_menu.id" v-bind:value="classes_menu.id" >{{ classes_menu.name }}</option>
        </select>
      </div>
      <div v-if="isClassSelect">
        <button class="btn btn-warning ml-2" @click="openModal">Record</button>
        <AnswerList2 :e_classes_id="e_classes_id" @from-child="closeModal" />
        <div class="form-group">
          <label for="selectsection" class="ml-2 mr-2">Select Section:</label>
          <select class="form-control" id="selectsection" @change="jump2" v-model="no">
            <option v-for="question in questions_menu" :key="question.no" v-bind:value="question.no" >{{ question.quest }}</option>
          </select>
        </div>
      </div>
    </div>
    <div class="row justify-content-center" v-if="no==null">
      <div class="col-sm-12 h1">
        <div class="text-center">上のメニューからグループ，次にセクションを選択してください。</div>
     </div>
    </div>
    <div class="row justify-content-center" v-else-if="!answered">
      <div class="col-sm-12">
        <h3>現在{{question_num}}問中{{correct}}問正解</h3>
        <h1><p class="badge badge-primary">第 {{ (questionIndex+1) }} 問</p></h1>
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
        <h3>現在{{question_num}}問中{{correct}}問正解</h3>
        <h1><p class="badge badge-primary">第 {{ (questionIndex+1) }} 問</p></h1>
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
          <span v-if="currentQuestion.ans == answers[questionIndex]"><div class="text-primary ml-3">あなたの解答は「{{answers[questionIndex]}}」　正解！！</div></span>
          <span v-else><div class="text-danger ml-3">あなたの解答は「{{answers[questionIndex]}}」　不正解。。。　正解は「{{ currentQuestion.ans }}」でした。</div></span><br>
          <h3><span class="badge badge-primary ml-3">解説</span></h3>
          <span v-if="currentQuestion.exp1 != null"><div class="ml-3">　1 . <span v-html="$sanitize(currentQuestion.exp1)"></span></div></span>
          <span v-if="currentQuestion.exp2 != null"><div class="ml-3">　2 . <span v-html="$sanitize(currentQuestion.exp2)"></span></div></span>
          <span v-if="currentQuestion.exp3 != null"><div class="ml-3">　3 . <span v-html="$sanitize(currentQuestion.exp3)"></span></div></span>
          <span v-if="currentQuestion.exp4 != null"><div class="ml-3">　4 . <span v-html="$sanitize(currentQuestion.exp4)"></span></div></span>
          <span v-if="currentQuestion.exp0 != null"><div class="ml-3"><span v-html="$sanitize(currentQuestion.exp0)"></span></div></span>
        </h4>
      </div>
      <div class="row justify-content-center" v-if="!completed">
        <span><button type="button" class="btn btn-primary btn-lg btn-block text-left"
          @click="nextQuestion"> 次の問題 </button></span>
      </div>
      <div class="row justify-content-center" v-else-if="completed">
        <div class="col-sm-12 h1">
          <div class="text-center">このセクションの問題は終わりました。上のメニューから他のセクションを選択してください。</div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import AnswerList2 from './E_learning2AnswerList2Component.vue'
import { mapState } from 'vuex'
export default {
  props: {
    no: String,
  },
  components: {
    AnswerList2
  },
  data: function () {
    return {
      classes_menus: [],
      isClassSelect: false,
//      no: 0,
      answers: [],
      questionIndex: 0,
      questions_menu: [],
      questions: {},
      answered: false,
      correct: 0,
      question_num: 0,
      s_id: 0,
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
    getQuestionsMenu() {
      axios.get('/api/e_learning2/st_menu/' + this.e_classes_id)
        .then((res) => {
          this.questions_menu = res.data;
        });
    },
    getQuestions() {
      axios.get('/api/e_learning2/st/' + this.e_classes_id + '/' + this.no)
        .then((res) => {
          this.questions = res.data;
          this.question_num = this.questions.length;
        });
    },
    addAnswer: function(index) {
      this.answers.push(index);
      if(this.questions[this.questionIndex].ans == index) this.correct++;
      const formData = new FormData()
      formData.append('e_classes_id', this.e_classes_id)
      formData.append('s_id', this.s_id)
      formData.append('no', this.no)
      formData.append('q_no', this.questionIndex + 1)
      let correct
      if(this.questions[this.questionIndex].ans == index) correct = 1
      else correct = 0
      formData.append('correct', correct)
      axios.post('/api/e_learning2/st/answer', formData);
      return this.answered = true;
    },
    nextQuestion: function() {
      if(!this.completed) {
        this.questionIndex++;
        return this.answered = false;
      }
    },
    jump1: function() {
      this.isClassSelect = true
      this.getQuestionsMenu();
      if(this.no != null) this.getQuestions();
    },
    jump2: function() {
      this.questionIndex = 0;
      this.answers.length = 0;
      this.answered = false;
      this.correct = 0;
      this.getQuestions();
      const date= new Date();
      this.s_id = date.getTime() / 1000;
    },
    async logout () {
      await this.$store.dispatch('auth_e_learning2/logout')
      if (this.apiStatus) {
        this.$router.push('/e_learning2/login')
      }
    },
    openModal: function(){
      this.$modal.show('modal_answer_list');
    },
    closeModal: function(){
      this.$modal.hide('modal_answer_list');
    }
  },
  computed: {
    currentQuestion: function() {
      return this.questions[this.questionIndex];
    },
    completed: function() {
      return (this.questions.length == this.answers.length);
    },
    ...mapState({
      apiStatus: state => state.auth_e_learning2.apiStatus
    })
  },
  mounted() {
    this.getClassesMenu();
  }
}
</script>
