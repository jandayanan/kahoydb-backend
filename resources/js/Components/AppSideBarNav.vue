<template>
  <CSidebarNav >
    <CNavItem>
      <CNavLink href="/dashboard" :active="page == 'dashboard'">
        <CIcon
        class="nav-icon"
        :icon="'cil-speedometer'"
        >
        </CIcon>
        Dashboard
      </CNavLink>
      </CNavItem>
    <CNavItem>
      <CNavLink href="/activity" :active="page == 'activities'">
        <CIcon
        class="nav-icon"
        :icon="'cil-pencil'"
        >
        </CIcon>
        Activities
      </CNavLink>
    </CNavItem>
    <CNavItem>
      <CNavLink href="#" :active="page == 'participants'">
        <CIcon
        class="nav-icon"
        :icon="'cil-user'"
        >
        </CIcon>
        Participants
      </CNavLink>
    </CNavItem>
  </CSidebarNav>
</template>

<script>
export default {
  name: 'AppSideBarNav',
  props: ['page']
}
</script>