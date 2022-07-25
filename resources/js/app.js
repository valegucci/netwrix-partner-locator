require('./bootstrap');

import { createApp } from 'vue';
import * as VueRouter from 'vue-router';
import VueAxios from 'vue-axios';
import axios from 'axios';
import App from './App.vue';

import Select2 from 'vue3-select2-component';

/* fontawesome create */
import { library } from '@fortawesome/fontawesome-svg-core'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import { faMagnifyingGlass } from '@fortawesome/free-solid-svg-icons'
library.add(faMagnifyingGlass)


const View = createApp(App)
.use(VueRouter)
.use(VueAxios, axios)
.component('font-awesome-icon', FontAwesomeIcon)
.component('Select2', Select2)
.mount('#app')

