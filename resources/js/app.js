import './bootstrap';

import Vue from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue';

createInertiaApp({
  resolve: name => {
    // Convert component name to file path
    const page = require(`./pages/${name}`).default;
    return page;
  },
  setup({ el, App, props, plugin }) {
    Vue.use(plugin);

    new Vue({
      render: h => h(App, props),
      el
    });
  },
});
