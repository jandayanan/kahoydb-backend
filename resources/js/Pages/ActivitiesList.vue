<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import ActivityTable from '@/Components/Activity/ActivityTable.vue';
import ActivityUpsertModal from '@/Components/Activity/ActivityUpsertModal.vue'
import { Head } from '@inertiajs/vue3';

export default {
  name: 'ActivitiesList',
  components: {
    AuthenticatedLayout,
    ActivityTable,
    ActivityUpsertModal,
    Head
  },
  props: {
    page: {
      type: String
    }
  },
  data() {
    return {
      isVisible: false,
      isReloading: false,
      method: 'create',
      activity: {}
    }
  },
  methods: {
    selectedRow(row){
      this.activity = row
      this.method = 'update'
      this.isVisible = true
    },
    showUpsertModal(){
      this.isVisible = true
      this.method = 'create'
    }
  }
}

</script>

<template>
  <Head title="Activities" />
  <AuthenticatedLayout :page="page">
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
          <CButton color="success" class="mb-3" @click="showUpsertModal">Add Activity</CButton>
          <ActivityTable @updateSelectedRow="selectedRow"/>
        </div>
      </div>
    </div>
    <ActivityUpsertModal 
      :method="method" 
      :activity="activity"
      :isVisible="isVisible"
      @close="isVisible=false"/>
  </AuthenticatedLayout>
</template>
