<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

export default {
  name: 'Participants',
  components: {
    AuthenticatedLayout,
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
    
  </AuthenticatedLayout>
</template>

<style>

</style>