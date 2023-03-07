<template>
  <CModal size="lg" :visible="showInfoModal" @close="resetModalState" id="participantModal">
    <CModalHeader>
      <CModalTitle>Tracker</CModalTitle>
    </CModalHeader>
    <CModalBody>
      <CContainer>
        <CRow>
          <CCol sm="auto"><strong>Name:</strong></CCol>
          <CCol sm="auto">{{ organization.full_name }}</CCol>
        </CRow>
        <CRow class="mt-2">
          <CCol sm="auto"><strong>Parent Organization:</strong></CCol>
          <CCol sm="auto" v-if="organization.organization.parent_organization">Main</CCol>
        </CRow>
        <CRow class="mt-2">
          <CCol sm="auto"><strong>Organization Type:</strong></CCol>
          <CCol sm="auto">{{ organization.organization.organization_type }}</CCol>
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
            <!-- <ParticipantActivitiesTable :items="activities" /> -->
          </CTabPane>
          <CTabPane role="tabpanel" aria-labelledby="trees-tab" :visible="tabPaneActiveKey === 2">
            <!-- <ParticipantTreesTable :items="trees" /> -->
          </CTabPane>
        </CTabContent>
      </CContainer>
    </CModalBody>
  </CModal>
</template>

<script>
import { mapState } from 'vuex'
// import ParticipantActivitiesTable from './ParticipantActivitiesTable.vue'
// import ParticipantTreesTable from './ParticipantTreesTable.vue'

export default {
  name: "OrganizationInfoModal",
  components: {
    // ParticipantActivitiesTable,
    // ParticipantTreesTable
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
  },
  methods: {

    resetModalState() {
      // Resets modal state
      this.$store.commit('updateOrganizatrionInfoModalState', false)
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