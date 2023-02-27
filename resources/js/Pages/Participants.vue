<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import ParticipantsTable from '@/Components/Participants/ParticipantsTable.vue' 
import ParticipantsContent from '@/Components/Participants/ParticipantsContent.vue' 
import { Head } from '@inertiajs/vue3';

export default {
  name: 'Participants',
  components: {
    AuthenticatedLayout,
    ParticipantsTable,
    ParticipantsContent,
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
          <ParticipantsContent />
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<style>

</style>