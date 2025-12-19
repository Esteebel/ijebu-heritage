<template>
  <app-layout title="Ijebu Oral History">
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <div class="p-6 bg-white border-b border-gray-200">
            <h1 class="text-3xl font-bold text-gray-800 mb-6">Ijebu Oral History</h1>

            <!-- Category Filter -->
            <div class="mb-8">
              <h2 class="text-xl font-semibold text-gray-700 mb-4">Browse by Category</h2>
              <div class="flex flex-wrap gap-2">
                <button
                  v-for="category in categories"
                  :key="category"
                  @click="filterByCategory(category)"
                  :class="[
                    'px-4 py-2 rounded-full transition-colors',
                    selectedCategory === category
                      ? 'bg-purple-600 text-white'
                      : 'bg-gray-200 text-gray-700 hover:bg-gray-300'
                  ]"
                >
                  {{ category }}
                </button>
                <button
                  @click="filterByCategory(null)"
                  :class="[
                    'px-4 py-2 rounded-full transition-colors',
                    selectedCategory === null
                      ? 'bg-purple-600 text-white'
                      : 'bg-gray-200 text-gray-700 hover:bg-gray-300'
                  ]"
                >
                  All Categories
                </button>
              </div>
            </div>

            <!-- Story List -->
            <div v-if="filteredStories.length > 0" class="space-y-6">
              <div
                v-for="story in filteredStories"
                :key="story.id"
                class="border border-gray-200 rounded-lg p-6 hover:shadow-md transition-shadow"
              >
                <div class="flex justify-between items-start">
                  <div>
                    <h3 class="text-xl font-semibold text-gray-800">{{ story.title }}</h3>
                    <div class="mt-2 flex items-center text-sm text-gray-600">
                      <span v-if="story.storyteller">Narrated by {{ story.storyteller }}</span>
                      <span v-if="story.recorded_date" class="mx-2">•</span>
                      <span v-if="story.recorded_date">{{ formatDate(story.recorded_date) }}</span>
                      <span class="mx-2">•</span>
                      <span class="capitalize">{{ story.category }}</span>
                    </div>
                  </div>
                  <div v-if="story.is_featured" class="bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded">
                    Featured
                  </div>
                </div>

                <p class="mt-4 text-gray-700">{{ truncateText(story.story, 200) }}</p>

                <div class="mt-4 flex items-center">
                  <button
                    @click="playAudio(story)"
                    v-if="story.audioFile"
                    class="flex items-center text-blue-600 hover:text-blue-800"
                  >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                      <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd" />
                    </svg>
                    Play Recording
                  </button>

                  <button
                    @click="viewDetails(story)"
                    class="ml-4 text-indigo-600 hover:text-indigo-800"
                  >
                    Read Full Story
                  </button>
                </div>
              </div>
            </div>

            <div v-else class="text-center py-12">
              <p class="text-gray-500">No stories found matching your filters.</p>
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
    stories: Array,
  },

  data() {
    return {
      selectedCategory: null,
      categories: [
        'Folktales',
        'War stories',
        'Childhood memories',
        'Myths',
        'Personal experiences',
        'Recordings of elders'
      ],
    }
  },

  computed: {
    filteredStories() {
      let filtered = this.stories;

      if (this.selectedCategory) {
        filtered = filtered.filter(story => story.category === this.selectedCategory);
      }

      return filtered;
    }
  },

  methods: {
    filterByCategory(category) {
      this.selectedCategory = category;
    },

    formatDate(dateString) {
      const options = { year: 'numeric', month: 'long', day: 'numeric' };
      return new Date(dateString).toLocaleDateString(undefined, options);
    },

    truncateText(text, length) {
      if (text.length <= length) return text;
      return text.substr(0, length) + '...';
    },

    playAudio(story) {
      // In a real implementation, this would play the audio file
      alert(`Playing audio for "${story.title}"`);
    },

    viewDetails(story) {
      // In a real implementation, this would navigate to the story details page
      alert(`Viewing details for "${story.title}"`);
    }
  }
}
</script>
