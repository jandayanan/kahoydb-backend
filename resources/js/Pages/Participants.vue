<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import ParticipantsTable from '@/Components/Participants/ParticipantsTable.vue' 
import { Head } from '@inertiajs/vue3';

export default {
  name: 'Participants',
  components: {
    AuthenticatedLayout,
    ParticipantsTable,
    Head
  },
  props: {
    page: {
      type: String
    }
  }
}
</script>

<template>
  <Head title="Participants" />
  <AuthenticatedLayout :page="page">
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
          <ParticipantsTable />
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<style>

</style>