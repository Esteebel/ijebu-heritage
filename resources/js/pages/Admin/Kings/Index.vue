<template>
  <app-layout>
    <div class="py-6">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
        <div class="flex justify-between items-center">
          <h1 class="text-2xl font-semibold text-gray-900">Kings</h1>
          <inertia-link
            :href="route('admin.kings.create')"
            class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
          >
            Add King
          </inertia-link>
        </div>
      </div>
      <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
        <div class="py-4">
          <div class="bg-white shadow overflow-hidden sm:rounded-md">
            <ul class="divide-y divide-gray-200">
              <li v-for="king in kings" :key="king.id">
                <inertia-link
                  :href="route('admin.kings.show', king.id)"
                  class="block hover:bg-gray-50"
                >
                  <div class="px-4 py-4 sm:px-6">
                    <div class="flex items-center justify-between">
                      <p class="text-sm font-medium text-indigo-600 truncate">
                        {{ king.name }}
                      </p>
                      <div class="ml-2 flex-shrink-0 flex">
                        <p
                          v-if="king.featured"
                          class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800"
                        >
                          Featured
                        </p>
                      </div>
                    </div>
                    <div class="mt-2 sm:flex sm:justify-between">
                      <div class="sm:flex">
                        <p class="flex items-center text-sm text-gray-500">
                          {{ king.regnal_name }}
                        </p>
                      </div>
                      <div class="mt-2 flex items-center text-sm text-gray-500 sm:mt-0">
                        <p>
                          Reign:
                          {{
                            king.reign_start_date
                              ? new Date(king.reign_start_date).toLocaleDateString()
                              : ''
                          }}
                          -
                          {{
                            king.reign_end_date
                              ? new Date(king.reign_end_date).toLocaleDateString()
                              : ''
                          }}
                        </p>
                      </div>
                    </div>
                  </div>
                </inertia-link>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </app-layout>
</template>

<script>
import AppLayout from '../../../layouts/AppLayout.vue'

export default {
  name: 'AdminKingsIndex',
  props: {
    kings: Array,
  },
  components: {
    AppLayout,
  },
}
</script>
