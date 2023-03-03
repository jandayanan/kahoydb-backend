<template>
  <AppNavbar />
  <CContainer sm class="py-12 d-flex justify-content-center">
    <CCard class="dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 col-md-6">
      <slot />
    </CCard>
  </CContainer>
</template>

<script>
import AppNavbar from '@/Components/AppNavbar.vue'

export default {
  name: 'ParticipateLayout',
  components: {
    AppNavbar
  }
}
</script>

<style>

</style>