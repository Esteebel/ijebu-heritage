<template>
  <app-layout title="Gallery of Old Ijebu Photos">
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <div class="p-6 bg-white border-b border-gray-200">
            <h1 class="text-3xl font-bold text-gray-800 mb-6">Gallery of Old Ijebu Photos</h1>

            <!-- Decade Filter -->
            <div class="mb-8">
              <h2 class="text-xl font-semibold text-gray-700 mb-4">Browse by Decade</h2>
              <div class="flex flex-wrap gap-2">
                <button
                  v-for="decade in decades"
                  :key="decade"
                  @click="filterByDecade(decade)"
                  :class="[
                    'px-4 py-2 rounded-full transition-colors',
                    selectedDecade === decade
                      ? 'bg-blue-600 text-white'
                      : 'bg-gray-200 text-gray-700 hover:bg-gray-300'
                  ]"
                >
                  {{ decade }}s
                </button>
                <button
                  @click="filterByDecade(null)"
                  :class="[
                    'px-4 py-2 rounded-full transition-colors',
                    selectedDecade === null
                      ? 'bg-blue-600 text-white'
                      : 'bg-gray-200 text-gray-700 hover:bg-gray-300'
                  ]"
                >
                  All Decades
                </button>
              </div>
            </div>

            <!-- Category Filter -->
            <div class="mb-8">
              <h2 class="text-xl font-semibold text-gray-700 mb-4">Browse by Category</h2>
              <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                <button
                  v-for="category in categories"
                  :key="category"
                  @click="filterByCategory(category)"
                  :class="[
                    'px-4 py-2 rounded-lg transition-colors text-center',
                    selectedCategory === category
                      ? 'bg-green-600 text-white'
                      : 'bg-gray-200 text-gray-700 hover:bg-gray-300'
                  ]"
                >
                  {{ category }}
                </button>
                <button
                  @click="filterByCategory(null)"
                  :class="[
                    'px-4 py-2 rounded-lg transition-colors text-center',
                    selectedCategory === null
                      ? 'bg-green-600 text-white'
                      : 'bg-gray-200 text-gray-700 hover:bg-gray-300'
                  ]"
                >
                  All Categories
                </button>
              </div>
            </div>

            <!-- Photo Grid -->
            <div v-if="filteredPhotos.length > 0" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
              <div
                v-for="photo in filteredPhotos"
                :key="photo.id"
                class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow"
              >
                <img
                  v-if="photo.media"
                  :src="'/storage/' + photo.media.path"
                  :alt="photo.title"
                  class="w-full h-48 object-cover"
                >
                <div class="p-4">
                  <h3 class="font-semibold text-lg text-gray-800">{{ photo.title }}</h3>
                  <p class="text-sm text-gray-600 mt-1">{{ photo.description }}</p>
                  <div class="mt-2 flex justify-between text-xs text-gray-500">
                    <span>{{ photo.decade }}s</span>
                    <span>{{ photo.category }}</span>
                  </div>
                </div>
              </div>
            </div>

            <div v-else class="text-center py-12">
              <p class="text-gray-500">No photos found matching your filters.</p>
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
    photos: Array,
  },

  data() {
    return {
      selectedDecade: null,
      selectedCategory: null,
      decades: ['1940', '1950', '1960', '1970', '1980', '1990'],
      categories: [
        'Festivals',
        'Market scenes',
        'Coronations',
        'Old towns',
        'Early schools',
        'Traditional ceremonies'
      ],
    }
  },

  computed: {
    filteredPhotos() {
      let filtered = this.photos;

      if (this.selectedDecade) {
        filtered = filtered.filter(photo => photo.decade === this.selectedDecade);
      }

      if (this.selectedCategory) {
        filtered = filtered.filter(photo => photo.category === this.selectedCategory);
      }

      return filtered;
    }
  },

  methods: {
    filterByDecade(decade) {
      this.selectedDecade = decade;
    },
    filterByCategory(category) {
      this.selectedCategory = category;
    }
  }
}
</script>
