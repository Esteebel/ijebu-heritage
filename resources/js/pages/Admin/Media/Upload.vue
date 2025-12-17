<template>
  <app-layout>
    <div class="py-6">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
        <h1 class="text-2xl font-semibold text-gray-900">Upload Media</h1>
      </div>
      <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
        <div class="py-4">
          <div class="bg-white shadow sm:rounded-lg">
            <div class="px-4 py-5 sm:p-6">
              <form @submit.prevent="submit">
                <div class="grid grid-cols-6 gap-6">
                  <div class="col-span-6">
                    <label
                      for="file"
                      class="block text-sm font-medium text-gray-700"
                    >
                      Single File Upload
                    </label>
                    <input
                      id="file"
                      ref="fileInput"
                      type="file"
                      class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100"
                      :class="{ 'border-red-300': form.errors.file }"
                      @change="handleFileChange"
                    >
                    <jet-input-error :message="form.errors.file" class="mt-2" />
                  </div>

                  <div class="col-span-6">
                    <label
                      for="name"
                      class="block text-sm font-medium text-gray-700"
                    >
                      Name (Optional)
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
                </div>

                <div class="mt-8 border-t border-gray-200 pt-5">
                  <div class="flex justify-end">
                    <inertia-link
                      :href="$route('admin.media.index')"
                      class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    >
                      Cancel
                    </inertia-link>
                    <button
                      type="submit"
                      class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                      :disabled="form.processing"
                    >
                      Upload
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
  data() {
    return {
      form: this.$inertia.form({
        file: null,
        name: '',
      })
    }
  },
  methods: {
    handleFileChange(e) {
      this.form.file = e.target.files[0]
      // Auto-fill name if not provided
      if (!this.form.name && this.form.file) {
        this.form.name = this.form.file.name.split('.')[0]
      }
    },
    submit() {
      const formData = new FormData()
      formData.append('file', this.form.file)
      if (this.form.name) {
        formData.append('name', this.form.name)
      }

      this.form.post(this.$route('admin.media.store'), {
        data: formData,
        headers: {
          'Content-Type': 'multipart/form-data',
        },
      })
    }
  }
}
</script>
