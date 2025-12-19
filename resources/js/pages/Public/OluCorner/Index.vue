<template>
  <app-layout title="Olu's Corner">
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <div class="p-6 bg-white border-b border-gray-200">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Olu's Corner</h1>
            <p class="text-gray-600 mb-8">Reflections from the creator of this virtual museum</p>

            <div class="space-y-12">
              <div
                v-for="section in sections"
                :key="section.id"
                class="border-b border-gray-200 pb-8 last:border-0 last:pb-0"
              >
                <h2 class="text-2xl font-semibold text-gray-800 mb-4">{{ section.section }}</h2>

                <div v-if="section.featuredMedia" class="float-right ml-6 mb-4">
                  <img
                    :src="'/storage/' + section.featuredMedia.path"
                    :alt="section.section"
                    class="w-64 h-48 object-cover rounded-lg shadow"
                  >
                </div>

                <div class="prose max-w-none" v-html="formatContent(section.content)"></div>
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
    sections: Array,
  },

  methods: {
    formatContent(content) {
      // Simple formatting - in a real app you might use a markdown parser
      return content.replace(/\n/g, '<br>');
    }
  }
}
</script>
