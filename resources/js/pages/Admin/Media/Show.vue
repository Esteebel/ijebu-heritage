<template>
  <app-layout>
    <div class="py-6">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
        <div class="flex justify-between items-center">
          <h1 class="text-2xl font-semibold text-gray-900">Media Details</h1>
          <div class="flex space-x-2">
            <inertia-link
              :href="$route('admin.media.edit', medium.id)"
              class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
            >
              Edit
            </inertia-link>
            <inertia-link
              :href="$route('admin.media.index')"
              class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
            >
              Back
            </inertia-link>
          </div>
        </div>
      </div>
      <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
        <div class="py-4">
          <div class="bg-white shadow sm:rounded-lg">
            <div class="px-4 py-5 sm:p-6">
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                  <div class="border border-gray-200 rounded-md p-4">
                    <h3 class="text-sm font-medium text-gray-900 mb-2">Media Preview</h3>
                    <div class="flex items-center justify-center">
                      <img v-if="medium.type === 'image'" :src="'/storage/' + medium.path" :alt="medium.name" class="max-h-96 object-contain">
                      <video v-else-if="medium.type === 'video'" controls class="max-h-96">
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
                <div>
                  <div class="border border-gray-200 rounded-md p-4">
                    <h3 class="text-sm font-medium text-gray-900 mb-4">Media Information</h3>
                    <dl class="grid grid-cols-1 gap-4">
                      <div>
                        <dt class="text-sm font-medium text-gray-500">Name</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ medium.name }}</dd>
                      </div>
                      <div>
                        <dt class="text-sm font-medium text-gray-500">Type</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ medium.type }}</dd>
                      </div>
                      <div>
                        <dt class="text-sm font-medium text-gray-500">MIME Type</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ medium.mime_type }}</dd>
                      </div>
                      <div>
                        <dt class="text-sm font-medium text-gray-500">Size</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ formatBytes(medium.size) }}</dd>
                      </div>
                      <div>
                        <dt class="text-sm font-medium text-gray-500">Uploaded At</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ formatDate(medium.created_at) }}</dd>
                      </div>
                      <div>
                        <dt class="text-sm font-medium text-gray-500">Path</dt>
                        <dd class="mt-1 text-sm text-gray-900 break-all">{{ medium.path }}</dd>
                      </div>
                    </dl>
                  </div>
                </div>
              </div>
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
  components: {
    AppLayout,
  },
  props: {
    medium: Object,
  },
  methods: {
    formatBytes(bytes, decimals = 2) {
      if (bytes === 0) return '0 Bytes'
      const k = 1024
      const dm = decimals < 0 ? 0 : decimals
      const sizes = ['Bytes', 'KB', 'MB', 'GB']
      const i = Math.floor(Math.log(bytes) / Math.log(k))
      return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i]
    },
    formatDate(dateString) {
      if (!dateString) return ''
      return new Date(dateString).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
      })
    }
  }
}
</script>
