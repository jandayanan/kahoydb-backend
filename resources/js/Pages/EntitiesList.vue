<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import EntitiesTable from '@/Components/Entities/EntitiesTable.vue'
import EntityUpsertModal from '@/Components/Entities/EntityUpsertModal.vue'
import { Head } from '@inertiajs/vue3';

export default {
  name: 'Entities',
  components: {
    AuthenticatedLayout,
    EntitiesTable,
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
      console.log(row)
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
          <CButton color="success" class="mb-5" @click="showUpsertModal">Add Entity</CButton>
          <EntitiesTable @updateSelectedRow="selectedRow"/>
        </div>
      </div>
    </div>
    <EntityUpsertModal 
      :method="method" 
      :entity="entity"
      :isVisible="isVisible"
      @close="isVisible=false"/>
  </AuthenticatedLayout>
</template>

<style>

</style>