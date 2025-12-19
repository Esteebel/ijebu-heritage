<template>
  <AdminLayout>
    <div class="container-fluid">
      <div class="row mb-4">
        <div class="col">
          <h1>{{ archive.title }}</h1>
          <p class="text-muted">View oral history archive details</p>
        </div>
        <div class="col-auto">
          <div class="btn-group" role="group">
            <inertia-link :href="$route('admin.oral.history.archives.edit', archive.id)" class="btn btn-primary">
              Edit
            </inertia-link>
            <button @click="destroy" class="btn btn-danger">
              Delete
            </button>
          </div>
        </div>
      </div>

      <div class="card">
        <div class="card-header bg-white py-3">
          <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Archive Details</h5>
            <span :class="archive.is_featured ? 'badge bg-success' : 'badge bg-secondary'">
              {{ archive.is_featured ? 'Featured' : 'Not Featured' }}
            </span>
          </div>
          <div class="d-flex gap-3 mt-2">
            <span class="badge bg-primary">{{ archive.category }}</span>
            <span v-if="archive.audioFile || archive.audio_url" class="badge bg-success">Audio Available</span>
            <span v-if="archive.videoFile || archive.video_url" class="badge bg-info">Video Available</span>
          </div>
        </div>

        <div class="card-body">
          <div class="row">
            <div class="col-md-6">
              <p><strong>Contributor:</strong> {{ archive.contributor }}</p>
            </div>
          </div>

          <div class="mb-3">
            <p><strong>Description:</strong></p>
            <p>{{ archive.description || 'No description provided' }}</p>
          </div>

          <!-- Featured Image -->
          <div v-if="archive.featuredMedia" class="mb-4">
            <p><strong>Featured Image:</strong></p>
            <img
              :src="'/storage/' + archive.featuredMedia.path"
              :alt="archive.featuredMedia.filename"
              class="img-fluid rounded"
              style="max-height: 300px;"
            >
            <div class="mt-2 text-muted">
              <small>{{ archive.featuredMedia.filename }}</small>
            </div>
          </div>

          <!-- Audio Section -->
          <div v-if="archive.audioFile || archive.audio_url" class="mb-4">
            <p><strong>Audio Recording:</strong></p>
            <audio controls class="w-100">
              <source :src="archive.audioFile ? '/storage/' + archive.audioFile.path : archive.audio_url" :type="archive.audioFile ? archive.audioFile.mime : 'audio/mpeg'">
              Your browser does not support the audio element.
            </audio>
            <div v-if="archive.audioFile" class="mt-2 text-muted">
              <small>{{ archive.audioFile.filename }}</small>
            </div>
          </div>

          <!-- Video Section -->
          <div v-if="archive.videoFile || archive.video_url" class="mb-4">
            <p><strong>Video Recording:</strong></p>
            <video controls class="w-100" style="max-height: 400px;">
              <source :src="archive.videoFile ? '/storage/' + archive.videoFile.path : archive.video_url" :type="archive.videoFile ? archive.videoFile.mime : 'video/mp4'">
              Your browser does not support the video element.
            </video>
            <div v-if="archive.videoFile" class="mt-2 text-muted">
              <small>{{ archive.videoFile.filename }}</small>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script>
import AdminLayout from '../../../layouts/AdminLayout.vue'

export default {
  name: 'OralHistoryArchivesShow',
  layout: AdminLayout,
  props: {
    archive: {
      type: Object,
      required: true
    }
  },
  methods: {
    async destroy() {
      const result = await this.$swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
      });

      if (result.isConfirmed) {
        this.$inertia.delete(this.$route('admin.oral.history.archives.destroy', this.archive.id));
      }
    }
  }
}
</script>
