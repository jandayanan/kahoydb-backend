<script>
import ParticipateLayout from '@/Layouts/ParticipateLayout.vue';
import ParticipateForm from '@/Components/Participate/ParticipateForm.vue'

import { Head } from '@inertiajs/vue3';

export default {
  name: 'Participate',
  components: {
    ParticipateLayout,
    ParticipateForm,
    Head
  },
  props: {
    activityId: {
      type: Number
    },
    hash: {
      type: String
    },
    isError: {
      type: Boolean,
      default: false
    }
  }
}
</script>

<template>
  <Head title="Plant a tree - Form" />
  <ParticipateLayout>
    <ParticipateForm 
      :activityId="activityId"
      :hash="hash" />
  </ParticipateLayout>
</template>

<style>

</style>