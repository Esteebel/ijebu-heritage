<template>
  <app-layout>
    <div class="py-6">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
        <div class="flex justify-between items-center">
          <h1 class="text-2xl font-semibold text-gray-900">Media Details</h1>
          <div class="flex space-x-2">
            <inertia-link
              :href="route('admin.media.edit', medium.id)"
              class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
            >
              Edit
            </inertia-link>
            <inertia-link
              :href="route('admin.media.index')"
              class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
            >
              Back to Media
            </inertia-link>
          </div>
        </div>
      </div>
      <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
        <div class="py-4">
          <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6">
              <h3 class="text-lg leading-6 font-medium text-gray-900">Media Information</h3>
              <p class="mt-1 max-w-2xl text-sm text-gray-500">Details and metadata for this media file.</p>
            </div>
            <div class="border-t border-gray-200">
              <dl>
                <!-- Media Preview -->
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                  <dt class="text-sm font-medium text-gray-500">Preview</dt>
                  <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                    <div class="flex items-center">
                      <div class="flex-shrink-0 h-48 w-48 rounded-md overflow-hidden">
                        <img v-if="medium.type === 'image'"
                             :src="'/storage/' + medium.path"
                             :alt="medium.caption || medium.filename"
                             class="h-48 w-48 object-contain bg-gray-100">
                        <div v-else class="h-48 w-48 bg-gray-200 flex items-center justify-center">
                          <svg v-if="medium.type === 'video'" class="h-16 w-16 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z" />
                          </svg>
                          <svg v-else-if="medium.type === 'audio'" class="h-16 w-16 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M18 3a1 1 0 00-1.196-.98l-10 2A1 1 0 006 5v9.114A4.369 4.369 0 005 14c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V7.82l8-1.6v5.894A4.37 4.37 0 0015 12c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V3z" />
                          </svg>
                          <svg v-else class="h-16 w-16 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd" />
                          </svg>
                        </div>
                      </div>
                      <div class="ml-6">
                        <div class="mb-2">
                          <a :href="'/storage/' + medium.path" target="_blank" class="text-indigo-600 hover:text-indigo-900">
                            View Original File
                          </a>
                        </div>
                        <div v-if="medium.caption" class="mb-2">
                          <p class="text-sm text-gray-500">Caption: {{ medium.caption }}</p>
                        </div>
                        <div v-if="medium.credit">
                          <p class="text-sm text-gray-500">Credit: {{ medium.credit }}</p>
                        </div>
                      </div>
                    </div>
                  </dd>
                </div>

                <!-- Filename -->
                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                  <dt class="text-sm font-medium text-gray-500">Filename</dt>
                  <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ medium.filename }}</dd>
                </div>

                <!-- Type -->
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                  <dt class="text-sm font-medium text-gray-500">Type</dt>
                  <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                      {{ medium.type }}
                    </span>
                  </dd>
                </div>

                <!-- MIME Type -->
                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                  <dt class="text-sm font-medium text-gray-500">MIME Type</dt>
                  <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ medium.mime }}</dd>
                </div>

                <!-- Size -->
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                  <dt class="text-sm font-medium text-gray-500">File Size</dt>
                  <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ formatFileSize(medium.size) }}</dd>
                </div>

                <!-- Dimensions (for images) -->
                <div v-if="medium.width && medium.height" class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                  <dt class="text-sm font-medium text-gray-500">Dimensions</dt>
                  <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ medium.width }} × {{ medium.height }} pixels</dd>
                </div>

                <!-- Uploaded By -->
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                  <dt class="text-sm font-medium text-gray-500">Uploaded By</dt>
                  <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ medium.uploader?.name }}</dd>
                </div>

                <!-- Uploaded At -->
                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                  <dt class="text-sm font-medium text-gray-500">Uploaded At</dt>
                  <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ formatDate(medium.created_at) }}</dd>
                </div>

                <!-- Path -->
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                  <dt class="text-sm font-medium text-gray-500">Storage Path</dt>
                  <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2 break-all">{{ medium.path }}</dd>
                </div>
              </dl>
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
  name: 'AdminMediaShow',
  props: {
    medium: Object,
  },
  components: {
    AppLayout,
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
      return new Date(dateString).toLocaleString()
    }
  }
}
</script>
