<template>
  <CBreadcrumb class="d-md-down-none me-auto mb-0">
    <CBreadcrumbItem
      v-for="item in breadcrumbs"
      :key="item"
      :href="item.active ? '' : item.path"
      :active="item.active"
    >
      {{ item.name }}
    </CBreadcrumbItem>
  </CBreadcrumb>
</template>

<script>
export default {
  name: 'AppBreadcrumb',
  props: ['page'],
  data() {
    return {
      breadcrumbsPage: {
        'dashboard': [
          {
            'name': 'Dashboard',
            'active': true,
            'path': '/dashboard'
          },
        ],
        'activities': [
          {
            'name': 'Dashboard',
            'active': false,
            'path': '/dashboard'
          },
          {
            'name': 'Activities',
            'active': true
          },
        ],
        'participants': [
          {
            'name': 'Dashboard',
            'active': false,
            'path': '/dashboard'
          },
          {
            'name': 'Participants',
            'active': true
          },
        ],
        'organizations': [
          {
            'name': 'Dashboard',
            'active': false,
            'path': '/dashboard'
          },
          {
            'name': 'Organizations',
            'active': true
          },
        ]
      },
      breadcrumbs: []
    }
  },
  mounted() {
    this.breadcrumbs = this.breadcrumbsPage[this.page]
  }

}
</script>
