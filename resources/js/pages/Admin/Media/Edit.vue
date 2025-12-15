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
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                  <!-- Media Preview -->
                  <div class="col-span-1">
                    <div class="border border-gray-200 rounded-md p-4">
                      <h3 class="text-sm font-medium text-gray-900 mb-2">Media Preview</h3>
                      <div class="flex items-center justify-center">
                        <img v-if="medium.type === 'image'" :src="'/storage/' + medium.path" :alt="medium.name" class="max-h-64 object-contain">
                        <video v-else-if="medium.type === 'video'" controls class="max-h-64">
                          <source :src="'/storage/' + medium.path" :type="medium.mime_type">
                          Your browser does not support the video tag.
                        </video>
                        <div v-else class="flex items-center justify-center h-64 w-full bg-gray-100 rounded">
                          <svg class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                          </svg>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Edit Form -->
                  <div class="col-span-1">
                    <div class="space-y-6">
                      <div>
                        <label
                          for="name"
                          class="block text-sm font-medium text-gray-700"
                        >
                          Name
                        </label>
                        <input
                          id="name"
                          v-model="form.name"
                          type="text"
                          class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                          :class="{ 'border-red-300': form.errors.name }"
                        >
                        <jet-input-error :message="form.errors.name" class="mt-2" />
                      </div>

                      <div>
                        <label
                          for="type"
                          class="block text-sm font-medium text-gray-700"
                        >
                          Type
                        </label>
                        <input
                          id="type"
                          v-model="form.type"
                          type="text"
                          disabled
                          class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm bg-gray-100"
                        >
                      </div>

                      <div>
                        <label
                          for="mime_type"
                          class="block text-sm font-medium text-gray-700"
                        >
                          MIME Type
                        </label>
                        <input
                          id="mime_type"
                          v-model="form.mime_type"
                          type="text"
                          disabled
                          class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm bg-gray-100"
                        >
                      </div>
                    </div>
                  </div>
                </div>

                <div class="mt-8 border-t border-gray-200 pt-5">
                  <div class="flex justify-end">
                    <inertia-link
                      :href="$route('media.show', medium.id)"
                      class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    >
                      Cancel
                    </inertia-link>
                    <button
                      type="submit"
                      class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                      :disabled="form.processing"
                    >
                      Update
                    </button>
                  </div>
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
import JetInputError from '../../../Jetstream/InputError.vue'

export default {
  components: {
    AppLayout,
    JetInputError,
  },
  props: {
    medium: Object,
  },
  data() {
    return {
      form: this.$inertia.form({
        name: this.medium?.name || '',
        type: this.medium?.type || '',
        mime_type: this.medium?.mime_type || '',
      })
    }
  },
  methods: {
    submit() {
      this.form.put(this.$route('media.update', this.medium.id))
    }
  }
}
</script>
