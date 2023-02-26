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
      <CNavLink href="/participants" :active="page == 'participants'">
        <CIcon
        class="nav-icon"
        :icon="'cil-people'"
        >
        </CIcon>
        Participants
      </CNavLink>
    </CNavItem>
    <CNavItem>
      <CNavLink href="/entities" :active="page == 'entities'">
        <CIcon
        class="nav-icon"
        :icon="'cil-user'"
        >
        </CIcon>
        Entities
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