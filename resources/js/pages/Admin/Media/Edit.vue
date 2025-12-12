<template>
  <app-layout>
    <div class="py-6">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
        <h1 class="text-2xl font-semibold text-gray-900">Edit Media</h1>
      </div>
      <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
        <div class="py-4">
          <div class="bg-white shadow sm:rounded-lg">
            <div class="px-4 py-5 sm:p-6">
              <form @submit.prevent="submit">
                <div class="grid grid-cols-6 gap-6">
                  <!-- Media Preview -->
                  <div class="col-span-6">
                    <div class="border border-gray-200 rounded-md p-4">
                      <h3 class="text-sm font-medium text-gray-900 mb-2">Media Preview</h3>
                      <div class="flex items-center">
                        <div class="flex-shrink-0 h-32 w-32 rounded-md overflow-hidden">
                          <img v-if="medium.type === 'image'"
                               :src="'/storage/' + medium.path"
                               :alt="medium.caption || medium.filename"
                               class="h-32 w-32 object-cover">
                          <div v-else class="h-32 w-32 bg-gray-200 flex items-center justify-center">
                            <svg v-if="medium.type === 'video'" class="h-12 w-12 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                              <path d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z" />
                            </svg>
                            <svg v-else-if="medium.type === 'audio'" class="h-12 w-12 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                              <path d="M18 3a1 1 0 00-1.196-.98l-10 2A1 1 0 006 5v9.114A4.369 4.369 0 005 14c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V7.82l8-1.6v5.894A4.37 4.37 0 0015 12c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V3z" />
                            </svg>
                            <svg v-else class="h-12 w-12 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                              <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd" />
                            </svg>
                          </div>
                        </div>
                        <div class="ml-4">
                          <p class="text-sm font-medium text-gray-900">{{ medium.filename }}</p>
                          <p class="text-sm text-gray-500">{{ formatFileSize(medium.size) }}</p>
                          <p class="text-sm text-gray-500">Type: {{ medium.type }}</p>
                          <p class="text-sm text-gray-500">Uploaded: {{ formatDate(medium.created_at) }}</p>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="col-span-6">
                    <label
                      for="caption"
                      class="block text-sm font-medium text-gray-700"
                    >
                      Caption
                    </label>
                    <input
                      v-model="form.caption"
                      type="text"
                      id="caption"
                      class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                    />
                  </div>

                  <div class="col-span-6">
                    <label
                      for="credit"
                      class="block text-sm font-medium text-gray-700"
                    >
                      Credit
                    </label>
                    <input
                      v-model="form.credit"
                      type="text"
                      id="credit"
                      class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                    />
                  </div>
                </div>
                <div class="mt-5">
                  <button
                    type="submit"
                    :disabled="isSubmitting"
                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-50"
                  >
                    <span v-if="isSubmitting">Saving...</span>
                    <span v-else>Save Changes</span>
                  </button>
                  <inertia-link
                    :href="route('admin.media.index')"
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
  name: 'AdminMediaEdit',
  props: {
    medium: Object,
  },
  components: {
    AppLayout,
  },
  data() {
    return {
      form: this.$inertia.form({
        caption: this.medium.caption || '',
        credit: this.medium.credit || '',
      }),
      isSubmitting: false,
    }
  },
  methods: {
    formatFileSize(bytes) {
      if (bytes === 0) return '0 Bytes'
      const k = 1024
      const sizes = ['Bytes', 'KB', 'MB', 'GB']
      const i = Math.floor(Math.log(bytes) / Math.log(k))
      return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i]
    },
    formatDate(dateString) {
      return new Date(dateString).toLocaleDateString()
    },
    submit() {
      this.isSubmitting = true
      this.form.put(route('admin.media.update', this.medium.id), {
        preserveScroll: true,
        onSuccess: () => {
          this.isSubmitting = false
        },
        onError: () => {
          this.isSubmitting = false
        }
      })
    },
  },
}
</script>
