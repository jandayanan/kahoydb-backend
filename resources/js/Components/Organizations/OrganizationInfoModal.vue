<template>
  <CModal size="xl" :visible="showInfoModal" @close="resetModalState" id="participantModal">
    <CModalHeader>
      <CModalTitle>Organization Details</CModalTitle>
    </CModalHeader>
    <CModalBody>
      <CContainer>
        <CRow>
          <CCol sm="auto"><strong>Name:</strong></CCol>
          <CCol sm="auto">{{ organization.full_name }}</CCol>
        </CRow>
        <CRow class="mt-2">
          <CCol sm="auto"><strong>Parent Organization:</strong></CCol>
          <CCol sm="auto" v-if="organization.organization.parent_organization_id == null">Main</CCol>
          <CCol sm="auto" v-if="organization.organization.parent_organization_id">{{ organization.organization.parent_organization_name }}</CCol>
        </CRow>
        <CRow class="mt-2">
          <CCol sm="auto"><strong>Organization Type:</strong></CCol>
          <CCol sm="auto">{{ organization.organization.organization_type.toUpperCase() }}</CCol>
        </CRow>
        <CRow class="mt-2">
          <CCol sm="auto"><strong>Trees Planted:</strong></CCol>
          <CCol sm="auto">{{ organization.treesCount }}</CCol>
        </CRow>
      </CContainer>
      <CContainer class="mt-5">
        <CNav variant="tabs" role="tablist">
          <CNavItem>
            <CNavLink
              href="javascript:void(0);"
              :active="tabPaneActiveKey === 1"
              @click="() => {tabPaneActiveKey = 1}"
            >
              Activities
            </CNavLink>
          </CNavItem>
          <CNavItem>
            <CNavLink
              href="javascript:void(0);"
              :active="tabPaneActiveKey === 2"
              @click="() => {tabPaneActiveKey = 2}"
            >
              Trees
            </CNavLink>
          </CNavItem>
        </CNav>
        <CTabContent class="mt-4">
          <CTabPane role="tabpanel" aria-labelledby="activies-tab" :visible="tabPaneActiveKey === 1">
            <OrganizationActivitiesTable :items="organization.activities" />
          </CTabPane>
          <CTabPane role="tabpanel" aria-labelledby="trees-tab" :visible="tabPaneActiveKey === 2">
            <TreesTable :items="organization.trees" :permission="'read'" />
          </CTabPane>
        </CTabContent>
      </CContainer>
    </CModalBody>
  </CModal>
</template>

<script>
import { mapState } from 'vuex'
import OrganizationActivitiesTable from './OrganizationActivitiesTable.vue';
import TreesTable from '@/Components/Trees/TreesTable.vue'

export default {
  name: "OrganizationInfoModal",
  components: {
    OrganizationActivitiesTable,
    TreesTable
  },
  props: {
    organization: {
      type: Object,
      default: {}
    }
  },
  data() {
    return {
      activities: [],
      trees: [],
      tab: "activities",
      tabPaneActiveKey: 1
    };
  },
  updated() {
    console.log(this.organization.activities)
  },
  methods: {
    resetModalState() {
      // Resets modal state
      this.$store.commit('updateOrganizationInfoModalState', false)
      this.clearEntities()
    },
    clearEntities() {
      this.activities = []
      this.trees = []
    }
  },
  computed: {
    ...mapState({
      showInfoModal: state => state.showOrganizationInfoModal
    })
  }
}
</script>

<style>

</style>