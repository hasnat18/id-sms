
require('./bootstrap');

window.Vue = require('vue').default;

import Form from 'vform'
window.Form = Form;

import Toaster from 'v-toaster'
import 'v-toaster/dist/v-toaster.css'
Vue.use(Toaster, {timeout: 5000})

Vue.component('example-component', require('./components/ExampleComponent.vue').default);


// const app = new Vue({
//     el: '#app',
// });
