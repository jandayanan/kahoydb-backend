<template>
  <CSidebar
    position="fixed"
    :unfoldable="sidebarUnfoldable"
    :visible="sidebarVisible"
    @visible-change="
      (event) =>
        $store.commit({
          type: 'updateSidebarVisible',
          value: event,
        })
    "
  >
    <CSidebarBrand>
      <CImage fluid src="logo.png" width="100" height="100" class="my-3 mx-3" />
      <CIcon
        custom-class-name="sidebar-brand-narrow"
        :icon="sygnet"
        :height="35"
      />
    </CSidebarBrand>
    <AppSideBarNav :page="page"/>
    <CSidebarToggler
      class="d-none d-lg-flex"
      @click="$store.commit('toggleUnfoldable')"
    />
  </CSidebar>
</template>

<script>
import { computed } from 'vue'
import { useStore } from 'vuex'
import { sygnet } from '@/Assets/brand/sygnet'
import { CNavGroup, CSidebarNav } from '@coreui/vue'
import AppSideBarNav from './AppSideBarNav.vue'

export default {
    name: "AppSidebar",
    props: ['page'],
    setup() {
        const store = useStore();
        return {
            sygnet,
            sidebarUnfoldable: computed(() => store.state.sidebarUnfoldable),
            sidebarVisible: computed(() => store.state.sidebarVisible),
        };
    },
    components: { CNavGroup, CSidebarNav, AppSideBarNav }
}
</script>
