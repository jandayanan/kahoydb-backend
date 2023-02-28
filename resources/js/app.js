import './bootstrap';
import '../css/app.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';

import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';
import CoreuiVue from '@coreui/vue';
import CIcon from '@coreui/icons-vue';
import SmartTable from 'vuejs-smart-table'
import VueDatePicker from '@vuepic/vue-datepicker';
import VPagination from "@hennge/vue3-pagination";
import vSelect from 'vue-select'

import { iconsSet as icons } from '@/Assets/icons'
import store from '@/store/index'
import _ from 'lodash'

import '@vuepic/vue-datepicker/dist/main.css'
import 'bootstrap/dist/css/bootstrap.min.css'
import '@coreui/coreui/dist/css/coreui.min.css'
import "@hennge/vue3-pagination/dist/vue3-pagination.css";
import 'vue-select/dist/vue-select.css';

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Kahoy';

createInertiaApp({
  title: (title) => `${title} - ${appName}`,
  resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
  setup({ el, App, props, plugin }) {
    return createApp({ render: () => h(App, props) })
      .use(plugin)
      .use(ZiggyVue, Ziggy)
      .use(CoreuiVue)
      .use(SmartTable)
      .use(VueDatePicker)
      .use(store)
      .provide('icons', icons)
      .provide('$_', _)
      .component('CIcon', CIcon)
      .component('VDatePicker', VueDatePicker)
      .component('VPagination', VPagination)
      .component('v-select', vSelect)
      .mount(el);
  },
  progress: {
      color: '#4B5563',
  },
});
