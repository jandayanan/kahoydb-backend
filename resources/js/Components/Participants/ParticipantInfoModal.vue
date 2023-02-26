<template>
  <CModal size="lg" :visible="showInfoModal" @close="resetModalState" id="participantModal">
    <CModalHeader>
      <CModalTitle>Tracker</CModalTitle>
    </CModalHeader>
    <CModalBody>
      <CContainer>
        <CRow>
          <CCol sm="auto"><strong>Name:</strong></CCol>
          <CCol sm="auto">{{ entity.full_name }}</CCol>
        </CRow>
        <CRow class="mt-2">
          <CCol sm="auto"><strong>Email:</strong></CCol>
          <CCol sm="auto">{{ entity.email }}</CCol>
        </CRow>
        <CRow class="mt-2">
          <CCol sm="auto"><strong>Contact #:</strong></CCol>
          <CCol sm="auto">{{ entity.contact_number }}</CCol>
        </CRow>
        <CRow class="mt-2">
          <CCol sm="auto"><strong>Status:</strong></CCol>
          <CCol sm="auto">{{ entity.status.toUpperCase() }}</CCol>
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
        <CTabContent>
          <CTabPane role="tabpanel" aria-labelledby="activies-tab" :visible="tabPaneActiveKey === 1">

          </CTabPane>
        </CTabContent>
      </CContainer>
    </CModalBody>
  </CModal>
</template>

<script>
import { mapState } from 'vuex'
export default {
  name: "ParticipantInfoModal",
  props: {
    entity: {
      type: Object,
      default: {}
    }
  },
  data() {
    return {
      participants: [],
      activities: [],
      trees: [],
      tab: "activities",
      tabPaneActiveKey: 1
    };
  },
  methods: {
    segregateEntities() {
      this.participants = this.entity.participants
      this.participants.forEach((participant) => {
        if (participant.activity.trees) {
          this.trees = this.trees.concat(participant.activity.trees)
        }
        delete participant.activity.trees
        this.activities.push(participant.activity)
      })
    },
    resetModalState() {
      this.$store.commit('updateParticipantInfoModalState', false)
      this.activities = []
      this.trees = []
    }
  },
  watch: {
    entity: {
      deep: true,
      handler() {
        this.segregateEntities()
      }
    }
  },
  computed: {
    ...mapState({
      showInfoModal: state => state.showParticipantInfoModal
    })
  }
}
</script>

<style>

</style>