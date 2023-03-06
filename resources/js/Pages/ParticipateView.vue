<script>
import ParticipateLayout from '@/Layouts/ParticipateLayout.vue';
import ParticipateViewTree from '@/Components/Participate/ParticipateViewTree.vue'

import { Head } from '@inertiajs/vue3';

export default {
  name: 'Participate',
  components: {
    ParticipateLayout,
    ParticipateViewTree,
    Head
  },
  props: {
    treeId: {
      type: Number
    },
    hash: {
      type: String
    }
  }
}
</script>

<template>
  <Head title="View Tree Status" />
  <ParticipateLayout>
    <ParticipateViewTree 
      :treeId="treeId"
      :hash="hash"/>
  </ParticipateLayout>
</template>

<style>

</style>