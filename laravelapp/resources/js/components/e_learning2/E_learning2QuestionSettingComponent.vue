<template>
  <div class="container-fluid">
    <h2 class="title">問題実施設定</h2>
    <div class="bg-primary mb-1">
      <div class="p-1 mb-1 bg-primary text-white form-inline row">
        <div class="form-group col-2">
          <label for="selectclass" class="mr-2">クラスを選択：</label>
         <select class="form-control" id="selectclass" @change="jump" v-model="e_classes_id">
            <option v-for="classes_menu in classes_menus" :key="classes_menu.id" v-bind:value="classes_menu.id" >{{ classes_menu.name }}</option>
          </select>
        </div>
      </div>
    </div>
    <div v-if="isClassSelect">
      <table class="table table-hover">
        <tbody>
          <div>
            <form @submit.prevent="submit">
              <tr v-for="(section_title, i) in section_titles" :key="i">
                <td>
                  <input
                    :id="'section_title' + i"
                    type="checkbox"
                    :value="section_title.no"
                    v-model="selected_titles"
                  >
                  <label :for="'section_title' + i">{{section_title.quest}}</label>
                </td>
              </tr>
              <button type="submit" class="btn btn-primary">決定</button>
            </form>
          </div>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
export default {
  data: function () {
    return {
      classes_menus: [],
      isClassSelect: false,
      section_titles: [],
      selected_titles: [],
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
    jump: function() {
      this.isClassSelect = true;
      this.getSectionTitles();
      this.getSelectedTitles();
    },
    getSectionTitles() {
      axios.get('/api/e_learning2/tc_menu2/' + this.e_classes_id)
        .then((res) => {
          this.section_titles = res.data;
        });
    },
    getSelectedTitles() {
      axios.get('/api/e_learning2/tc_select/' + this.e_classes_id)
        .then((res) => {
          this.selected_titles = res.data;
        });
    },
    submit() {
      axios.put('/api/e_learning2/tc_setting/' + this.e_classes_id, this.selected_titles)
        .then((res) => {
            this.$router.push({name: 'tc.list'})
        });
    }
  },
  mounted() {
    this.getClassesMenu();
  }
}
</script>