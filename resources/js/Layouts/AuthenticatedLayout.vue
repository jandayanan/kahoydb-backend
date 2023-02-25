<template>
  <div>
    <AppSidebar :page="page"/>
    <div class="wrapper d-flex flex-column min-vh-100 bg-light">
      <AppHeader :page="page"/>
      <div class="body flex-grow-1 px-3">
          <CContainer lg>
          <slot/>
          </CContainer>
      </div>
      <AppFooter />
    </div>
  </div> 
</template>

<script>
import  AppHeader from '@/Components/AppHeader.vue'
import AppFooter from '@/Components/AppFooter.vue'
import AppSidebar from '@/Components/AppSidebar.vue'
import { CContainer } from '@coreui/vue'

export default {
  name: 'AuthenticatedLayout',
  props: ['page'],
  components: {
    AppHeader,
    AppSidebar,
    CContainer,
    AppFooter
  },
  mounted() {
    this.pr
  }
}
</script>

<style lang="scss">
// Import Main styles for this application
@import '../styles/style.scss';
</style>
