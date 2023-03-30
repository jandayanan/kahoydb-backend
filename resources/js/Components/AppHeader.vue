<template>
  <CHeader position="sticky" class="mb-4">
    <CContainer fluid>
      <CHeaderToggler class="ps-1" @click="$store.commit('toggleSidebar')">
        <CIcon icon="cil-menu" size="lg" />
      </CHeaderToggler>
      <CHeaderNav>
        <AppHeaderDropdownAccnt />
      </CHeaderNav>
    </CContainer>
    <CHeaderDivider />
    <CContainer fluid>
      <AppBreadcrumb :page="page"></AppBreadcrumb>
    </CContainer>
  </CHeader>
</template>

<script>
import AppBreadcrumb from '@/Components/AppBreadcrumb.vue'
import AppHeaderDropdownAccnt from '@/Components/AppHeaderDropdownAccnt.vue'
import { logo } from '@/Assets/brand/logo';

export default {
  name: 'AppHeader',
  props: ['page'],
  components: {
    AppBreadcrumb,
    AppHeaderDropdownAccnt
  },
  setup() {
    return {
      logo
    }
  }
}
</script>
