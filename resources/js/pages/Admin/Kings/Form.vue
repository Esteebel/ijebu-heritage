<template>
  <app-layout>
    <div class="py-6">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
        <h1 class="text-2xl font-semibold text-gray-900">
          {{ king ? 'Edit King' : 'Create King' }}
        </h1>
      </div>
      <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
        <div class="py-4">
          <div class="bg-white shadow sm:rounded-lg">
            <div class="px-4 py-5 sm:p-6">
              <form @submit.prevent="submit">
                <div class="grid grid-cols-6 gap-6">
                  <div class="col-span-6 sm:col-span-3">
                    <label
                      for="name"
                      class="block text-sm font-medium text-gray-700"
                    >
                      Name
                    </label>
                    <input
                      v-model="form.name"
                      type="text"
                      id="name"
                      class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                    />
                  </div>

                  <div class="col-span-6 sm:col-span-3">
                    <label
                      for="regnal_name"
                      class="block text-sm font-medium text-gray-700"
                    >
                      Regnal Name
                    </label>
                    <input
                      v-model="form.regnal_name"
                      type="text"
                      id="regnal_name"
                      class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                    />
                  </div>

                  <div class="col-span-6 sm:col-span-3">
                    <label
                      for="birth_year"
                      class="block text-sm font-medium text-gray-700"
                    >
                      Birth Year
                    </label>
                    <input
                      v-model="form.birth_year"
                      type="number"
                      id="birth_year"
                      class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                    />
                  </div>

                  <div class="col-span-6 sm:col-span-3">
                    <label
                      for="death_year"
                      class="block text-sm font-medium text-gray-700"
                    >
                      Death Year
                    </label>
                    <input
                      v-model="form.death_year"
                      type="number"
                      id="death_year"
                      class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                    />
                  </div>

                  <div class="col-span-6 sm:col-span-3">
                    <label
                      for="reign_start_date"
                      class="block text-sm font-medium text-gray-700"
                    >
                      Reign Start Date
                    </label>
                    <input
                      v-model="form.reign_start_date"
                      type="date"
                      id="reign_start_date"
                      class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                    />
                  </div>

                  <div class="col-span-6 sm:col-span-3">
                    <label
                      for="reign_end_date"
                      class="block text-sm font-medium text-gray-700"
                    >
                      Reign End Date
                    </label>
                    <input
                      v-model="form.reign_end_date"
                      type="date"
                      id="reign_end_date"
                      class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                    />
                  </div>

                  <div class="col-span-6">
                    <label
                      for="short_bio"
                      class="block text-sm font-medium text-gray-700"
                    >
                      Short Bio
                    </label>
                    <textarea
                      v-model="form.short_bio"
                      id="short_bio"
                      rows="3"
                      class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                    />
                  </div>

                  <div class="col-span-6">
                    <label
                      for="full_bio"
                      class="block text-sm font-medium text-gray-700"
                    >
                      Full Bio
                    </label>
                    <textarea
                      v-model="form.full_bio"
                      id="full_bio"
                      rows="6"
                      class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                    />
                  </div>

                  <div class="col-span-6 flex items-start">
                    <div class="flex items-center h-5">
                      <input
                        v-model="form.featured"
                        id="featured"
                        type="checkbox"
                        class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded"
                      />
                    </div>
                    <div class="ml-3 text-sm">
                      <label
                        for="featured"
                        class="font-medium text-gray-700"
                      >
                        Featured
                      </label>
                    </div>
                  </div>
                </div>
                <div class="mt-5">
                  <button
                    type="submit"
                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                  >
                    {{ king ? 'Update' : 'Create' }} King
                  </button>
                  <inertia-link
                    :href="route('admin.kings.index')"
                    class="ml-2 inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                  >
                    Cancel
                  </inertia-link>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </app-layout>
</template>

<script>
import AppLayout from '../../../layouts/AppLayout.vue'

export default {
  name: 'AdminKingsForm',
  props: {
    king: Object,
  },
  components: {
    AppLayout,
  },
  data() {
    return {
      form: this.$inertia.form({
        name: this.king?.name || '',
        regnal_name: this.king?.regnal_name || '',
        birth_year: this.king?.birth_year || null,
        death_year: this.king?.death_year || null,
        reign_start_date: this.king?.reign_start_date || null,
        reign_end_date: this.king?.reign_end_date || null,
        dynasty_id: this.king?.dynasty_id || null,
        short_bio: this.king?.short_bio || '',
        full_bio: this.king?.full_bio || '',
        portrait_media_id: this.king?.portrait_media_id || null,
        featured: this.king?.featured || false,
      }),
    }
  },
  methods: {
    submit() {
      if (this.king) {
        this.form.put(route('admin.kings.update', this.king.id))
      } else {
        this.form.post(route('admin.kings.store'))
      }
    },
  },
}
</script>
