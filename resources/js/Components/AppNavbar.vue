<template>
  <CNavbar expand="lg" style="background-color: #303C54;">
  <CContainer fluid>
    <CNavbarBrand href="#" class="d-flex">
      <div class="justify-center ml-2">
        <img src="@/Assets/logo.png" alt="" width="50">
      </div>
      
    </CNavbarBrand>
    <CNavbarToggler class="mr-2" />
    <CCollapse class="navbar-collapse">
      <CNavbarNav v-item="permission != 'guest'">
        <CNavItem>
          <CNavLink href="#" class="text-white" active>
            Home
          </CNavLink>
        </CNavItem>
      </CNavbarNav>
    </CCollapse>
  </CContainer>
</CNavbar>
</template>

<script>
export default {
  props: {
    permission: {
      type: String,
      default: 'guest'
    }
  },
  data(){
    return {
      visible: true
    }
  }
}
</script>

<style>

</style>