/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap'

import Vue from 'vue'
import VueRouter from 'vue-router';
import TextareaAutosize from 'vue-textarea-autosize'
import sanitizeHTML from 'sanitize-html'
import VModal from 'vue-js-modal'
import VuejsDialog from 'vuejs-dialog';
import 'vuejs-dialog/dist/vuejs-dialog.min.css';


import store from './store'
import SystemError from './components/e_learning2/errors/System.vue'
import NotFound from './components/e_learning2/errors/NotFound.vue'
import E_learning2_App from './E_learning2_App.vue'
import E_learning2LoginComponent from "./components/e_learning2/E_learning2LoginComponent";
import E_learning2TeacherComponent from "./components/e_learning2/E_learning2TeacherComponent";
import E_learning2QuestionListComponent from "./components/e_learning2/E_learning2QuestionListComponent";
import E_learning2QuestionShowComponent from "./components/e_learning2/E_learning2QuestionShowComponent";
import E_learning2QuestionCreateComponent from "./components/e_learning2/E_learning2QuestionCreateComponent";
import E_learning2QuestionEditComponent from "./components/e_learning2/E_learning2QuestionEditComponent";
import E_learning2QuestionCsvComponent from "./components/e_learning2/E_learning2QuestionCsvComponent";
import E_learning2AnswerListComponent from "./components/e_learning2/E_learning2AnswerListComponent";
import E_learning2ClassListComponent from "./components/e_learning2/E_learning2ClassListComponent";
import E_learning2QuestionSettingComponent from "./components/e_learning2/E_learning2QuestionSettingComponent";
import E_learning2StudentComponent from "./components/e_learning2/E_learning2StudentComponent";
import E_learning2Question2Component from "./components/e_learning2/E_learning2Question2Component";
import E_learning2AdminComponent from "./components/e_learning2/E_learning2AdminComponent";
import E_learning2UserListComponent from "./components/e_learning2/E_learning2UserListComponent";
import E_learning2UserCreateComponent from "./components/e_learning2/E_learning2UserCreateComponent";
import E_learning2UserEditComponent from "./components/e_learning2/E_learning2UserEditComponent";
import E_learning2UserCsvComponent from "./components/e_learning2/E_learning2UserCsvComponent";

require('./bootstrap');

window.Vue = require('vue');

Vue.use(VueRouter);
Vue.use(TextareaAutosize);
Vue.use(VModal);
Vue.use(VuejsDialog, {
  html: true,
  loader: true,
  okText: 'OK',
  cancelText: 'Cancel',
  animation: 'bounce'
});


const router = new VueRouter({
  mode: 'history',
  scrollBehavior () {
    return { x: 0, y: 0 }
    },
  routes: [
    {
      path: '/e_learning2/login',
      component: E_learning2LoginComponent,
      beforeEnter (to, from, next) {
        if (store.getters['auth_e_learning2/check'] && store.getters['auth_e_learning2/role'] == 5) {
          next('/e_learning2/tc')
        } else if (store.getters['auth_e_learning2/check'] && store.getters['auth_e_learning2/role'] == 10) {
          next('/e_learning2/st')
        } else if (store.getters['auth_e_learning2/check'] && store.getters['auth_e_learning2/role'] == 1) {
          next('/e_learning2/ad')
        } else {
          next()
        }
      }
    },
    {
      path: '/e_learning2/tc',
      component: E_learning2TeacherComponent,
        children: [
          {
            path: '',
            name: 'tc.list',
            component: E_learning2QuestionListComponent
          },
          {
            path: ':questionId',
            name: 'tc.show',
            component: E_learning2QuestionShowComponent,
            props: true
          },
          {
            path: 'create',
            name: 'tc.create',
            component: E_learning2QuestionCreateComponent
          },
          {
            path: 'import',
            name: 'tc.import',
            component: E_learning2QuestionCsvComponent
          },
          {
            path: ':questionId',
            name: 'tc.edit',
            component: E_learning2QuestionEditComponent,
            props: true
          },
          {
            path: 'answer/:no',
            name: 'tc.answer',
            component: E_learning2AnswerListComponent,
            props: true
          },
          {
            path: 'class_list/:e_classes_id',
            name: 'tc.class',
            component: E_learning2ClassListComponent
          },
          {
            path: 'setting',
            name: 'tc.setting',
            component: E_learning2QuestionSettingComponent
          },
        ]
    },
    {
      path: '/e_learning2/st',
      component: E_learning2StudentComponent,
        children: [
          {
            path: '',
            name: 'st.question2',
            component: E_learning2Question2Component,
            props: true
          }
        ]
    },
    {
      path: '/e_learning2/ad',
      component: E_learning2AdminComponent,
        children: [
          {
            path: '',
            name: 'ad.list',
            component: E_learning2UserListComponent
          },
          {
            path: 'create',
            name: 'ad.create',
            component: E_learning2UserCreateComponent
          },
          {
            path: 'import',
            name: 'ad.import',
            component: E_learning2UserCsvComponent
          },
          {
            path: ':userId',
            name: 'ad.edit',
            component: E_learning2UserEditComponent,
            props: true
          },
        ]
    },
    {
      path: '/500',
      component: SystemError
    },    {
      path: '/e_learning2/*',
      component: NotFound
    },

  ]
});

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

sanitizeHTML.defaults.allowedTags.push('img')
sanitizeHTML.defaults.allowedAttributes.img = ['src']
Vue.prototype.$sanitize = sanitizeHTML;

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const createApp3 = async () => {
  await store.dispatch('auth_e_learning2/currentUser')
  new Vue({
    el: '#app3',
    router,
    store,
    components: { E_learning2_App }, // ルートコンポーネントの使用を宣言する
    template: '<E_learning2_App />' // ルートコンポーネントを描画する
});
}
createApp3()
