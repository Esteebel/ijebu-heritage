import './bootstrap';

import Vue from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue';
import { InertiaLink } from '@inertiajs/inertia-vue';
import Swal from 'sweetalert2';
import LoadingSpinner from './components/LoadingSpinner.vue';

createInertiaApp({
  resolve: name => {
    // Convert component name to file path
    const page = require(`./pages/${name}`).default;
    return page;
  },
  setup({ el, App, props, plugin }) {
    Vue.use(plugin);

    // Register components globally
    Vue.component('InertiaLink', InertiaLink);
    Vue.component('LoadingSpinner', LoadingSpinner);

    // Add route helper to Vue prototype
    Vue.prototype.$route = window.route;

    // Add SweetAlert to Vue prototype
    Vue.prototype.$swal = Swal;

    // Add global loading state handling
    let isLoading = false;

    // Show loading indicator when Inertia visits start
    document.addEventListener('inertia:start', () => {
      isLoading = true;
      // Add loading class to body
      document.body.classList.add('loading');
    });

    // Hide loading indicator when Inertia visits finish
    document.addEventListener('inertia:finish', () => {
      isLoading = false;
      // Remove loading class from body
      document.body.classList.remove('loading');
    });

    new Vue({
      render: h => h(App, props),
      el
    });
  },
});
