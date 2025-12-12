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
                      ref="fileInput"
                      type="file"
                      id="file"
                      @change="handleFileChange"
                      class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                    />
                    <p class="mt-1 text-sm text-gray-500">Upload a single image, video, audio, or document file.</p>
                  </div>

                  <div class="col-span-6">
                    <label
                      for="bulkFiles"
                      class="block text-sm font-medium text-gray-700"
                    >
                      Bulk File Upload
                    </label>
                    <input
                      ref="bulkFilesInput"
                      type="file"
                      id="bulkFiles"
                      @change="handleBulkFilesChange"
                      multiple
                      class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                    />
                    <p class="mt-1 text-sm text-gray-500">Upload multiple files at once (Ctrl+Click or Shift+Click to select multiple files).</p>
                  </div>

                  <div class="col-span-6" v-if="selectedFiles.length > 0">
                    <div class="border border-gray-200 rounded-md p-4">
                      <h3 class="text-sm font-medium text-gray-900 mb-2">Selected Files ({{ selectedFiles.length }})</h3>
                      <ul class="divide-y divide-gray-200">
                        <li v-for="(file, index) in selectedFiles" :key="index" class="py-2">
                          <div class="flex items-center justify-between">
                            <div class="flex items-center">
                              <span class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-indigo-100">
                                <svg v-if="getFileIcon(file.type) === 'image'" class="h-5 w-5 text-indigo-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                  <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd" />
                                </svg>
                                <svg v-else-if="getFileIcon(file.type) === 'video'" class="h-5 w-5 text-indigo-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                  <path d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z" />
                                </svg>
                                <svg v-else-if="getFileIcon(file.type) === 'audio'" class="h-5 w-5 text-indigo-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                  <path d="M18 3a1 1 0 00-1.196-.98l-10 2A1 1 0 006 5v9.114A4.369 4.369 0 005 14c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V7.82l8-1.6v5.894A4.37 4.37 0 0015 12c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V3z" />
                                </svg>
                                <svg v-else class="h-5 w-5 text-indigo-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                  <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd" />
                                </svg>
                              </span>
                              <span class="ml-3 text-sm font-medium text-gray-900 truncate">{{ file.name }}</span>
                            </div>
                            <span class="text-sm text-gray-500">{{ formatFileSize(file.size) }}</span>
                          </div>
                        </li>
                      </ul>
                    </div>
                  </div>

                  <div class="col-span-6">
                    <label
                      for="caption"
                      class="block text-sm font-medium text-gray-700"
                    >
                      Caption (for single file upload)
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
                      Credit (for single file upload)
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
                    <span v-if="isSubmitting">Uploading...</span>
                    <span v-else>Upload</span>
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
  name: 'AdminMediaUpload',
  components: {
    AppLayout,
  },
  data() {
    return {
      form: this.$inertia.form({
        file: null,
        files: [],
        caption: '',
        credit: '',
      }),
      selectedFiles: [],
      isSubmitting: false,
    }
  },
  methods: {
    handleFileChange(e) {
      this.form.file = e.target.files[0]
      // If a single file is selected, clear bulk files
      if (this.form.file) {
        this.form.files = []
        this.selectedFiles = [this.form.file]
      }
    },
    handleBulkFilesChange(e) {
      this.form.files = Array.from(e.target.files)
      this.selectedFiles = this.form.files
      // If bulk files are selected, clear single file
      if (this.form.files.length > 0) {
        this.form.file = null
      }
    },
    getFileIcon(type) {
      if (type.startsWith('image/')) return 'image'
      if (type.startsWith('video/')) return 'video'
      if (type.startsWith('audio/')) return 'audio'
      return 'document'
    },
    formatFileSize(bytes) {
      if (bytes === 0) return '0 Bytes'
      const k = 1024
      const sizes = ['Bytes', 'KB', 'MB', 'GB']
      const i = Math.floor(Math.log(bytes) / Math.log(k))
      return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i]
    },
    submit() {
      this.isSubmitting = true

      // Determine which upload method to use
      if (this.form.files.length > 0) {
        // Bulk upload
        const formData = new FormData()
        this.form.files.forEach((file, index) => {
          formData.append('files[' + index + ']', file)
        })

        this.$inertia.post(route('admin.media.bulk-upload'), formData, {
          forceFormData: true,
          preserveScroll: true,
          onSuccess: () => {
            this.isSubmitting = false
          },
          onError: () => {
            this.isSubmitting = false
          }
        })
      } else if (this.form.file) {
        // Single file upload
        this.form.post(route('admin.media.store'), {
          forceFormData: true,
          preserveScroll: true,
          onSuccess: () => {
            this.isSubmitting = false
          },
          onError: () => {
            this.isSubmitting = false
          }
        })
      } else {
        this.isSubmitting = false
        alert('Please select a file to upload')
      }
    },
  },
}
</script>
