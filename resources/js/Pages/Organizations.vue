<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import OrganizationContent from '@/Components/Organizations/OrganizationContent.vue'
import { Head } from '@inertiajs/vue3';

export default {
  name: 'Participants',
  components: {
    AuthenticatedLayout,
    OrganizationContent,
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
  <Head title="Organizations" />
  <AuthenticatedLayout :page="page">
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
          <OrganizationContent />
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<style>

</style>