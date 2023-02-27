<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import EntitiesTable from '@/Components/Entities/EntitiesTable.vue'
import EntitiesContent from '@/Components/Entities/EntitiesContent.vue'
import EntityUpsertModal from '@/Components/Entities/EntityUpsertModal.vue'
import { Head } from '@inertiajs/vue3';

export default {
  name: 'Entities',
  components: {
    AuthenticatedLayout,
    EntitiesContent,
    EntityUpsertModal,
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
      this.entity = row
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
  <Head title="Entities" />
  <AuthenticatedLayout :page="page">
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
          
          <EntitiesContent @updateSelectedRow="selectedRow" />
        </div>
      </div>
    </div>
    
  </AuthenticatedLayout>
</template>

<style>

</style>