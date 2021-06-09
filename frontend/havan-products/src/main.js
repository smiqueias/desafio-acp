import Vue from 'vue'
import App from './App.vue'
import { IconsPlugin } from 'bootstrap-vue'
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import RadioButton from 'primevue/radiobutton';
import Toolbar from 'primevue/toolbar'
import InputText from 'primevue/inputtext'
import Dialog from 'primevue/dialog'
import Button from 'primevue/button'
import InputNumber from 'primevue/inputnumber'
import ToastService from 'primevue/toastservice';
import ColumnGroup from 'primevue/columngroup';
import PrimeVue from 'primevue/config';
import Toast from 'primevue/toast';
import Dropdown from 'primevue/dropdown';


import 'primevue/resources/themes/saga-blue/theme.css';
import 'primevue/resources/primevue.min.css';             
import 'primeicons/primeicons.css';                        

Vue.use(PrimeVue);
Vue.use(IconsPlugin)
Vue.use(ToastService);
Vue.component('DataTable',DataTable)
Vue.component('Button',Button)
Vue.component('RadioButton',RadioButton)
Vue.component('Dialog',Dialog)
Vue.component('Toast',Toast)
Vue.component('Dropdown',Dropdown)
Vue.component('InputNumber',InputNumber)
Vue.component('Toolbar',Toolbar)
Vue.component('InputText',InputText)
Vue.component('Column',Column)
Vue.component('ColumnGroup',ColumnGroup)

Vue.config.productionTip = false

new Vue({
  render: h => h(App),
}).$mount('#app')
