<template>
  <CModal size="lg" :visible="showActivityModal" @close="resetModalState" id="activityModal">
    <CModalHeader>
      <CModalTitle>Activity Output</CModalTitle>
    </CModalHeader>
    <CModalBody>
      <CContainer>
        <CRow>
          <CCol sm="auto"><strong>Name:</strong></CCol>
          <CCol sm="auto">{{ activity.name }}</CCol>
        </CRow>
        <CRow class="mt-2">
          <CCol sm="auto"><strong>Start Date:</strong></CCol>
          <CCol sm="auto">{{ activity.start_date }}</CCol>
        </CRow>
        <CRow class="mt-2">
          <CCol sm="auto"><strong>End Date:</strong></CCol>
          <CCol sm="auto">{{ activity.end_date }}</CCol>
        </CRow>
        <CRow class="mt-2">
          <CCol sm="auto"><strong>Status:</strong></CCol>
          <CCol sm="auto">{{ activity.activity_status.toUpperCase() }}</CCol>
        </CRow>
        <CRow class="mt-4">
          <CCol sm="auto"><strong>No. of Participants:</strong></CCol>
          <CCol sm="auto">{{ participants.length }}</CCol>
        </CRow>
        <CRow>
          <CCol sm="auto"><strong>No. of Trees:</strong></CCol>
          <CCol sm="auto">{{ trees.length }}</CCol>
        </CRow>
        <CRow>
          <CCol sm="auto">
            <CButton 
              color="success" 
              class="mt-3" @click="showInsertModal">
              {{ tabPaneActiveKey === 1 ? 'Add Participant': tabPaneActiveKey === 2 ? 'Add Tree':'' }}
            </CButton>
            <ParticipantInsertModal 
              :participants="participants"
              :activityId="activity.id" 
              @inserted="insertedParticipant"/>
          </CCol>
        </CRow>
      </CContainer>
      <CContainer class="mt-3">
        <CNav variant="tabs" role="tablist">
          <CNavItem>
            <CNavLink
              href="javascript:void(0);"
              :active="tabPaneActiveKey === 1"
              @click="() => {tabPaneActiveKey = 1}"
            >
              Participants
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
          <CTabPane role="tabpanel" aria-labelledby="participants-tab" :visible="tabPaneActiveKey === 1">
            <ParticipantsTable :items="participants" @selectedRow="selectedParticipantRow"/>
          </CTabPane>
          <CTabPane role="tabpanel" aria-labelledby="trees-tab" :visible="tabPaneActiveKey === 2">
          </CTabPane>
        </CTabContent>
      </CContainer>
    </CModalBody>
  </CModal>
  
</template>

<script>
import { mapState } from 'vuex'
import ParticipantsTable from '@/Components/Participants/ParticipantsTable.vue'
import ParticipantInsertModal from '../Participants/ParticipantInsertModal.vue'

export default {
  name: "ActivityOutputModal",
  components: {
    ParticipantsTable,
    ParticipantInsertModal
  },
  props: {
    activity: {
      type: Object,
      default: {}
    }
  },
  data() {
    return {
      participants: [],
      trees: [],
      tabPaneActiveKey: 1
    };
  },
  updated() {        
    this.segregateEntities()                                  
  },
  methods: {
    segregateEntities() {
      // Segregate participants and trees into separate arrays
      this.clearEntities()
      this.activity.participants.forEach((participant) => {
        if (participant.entity.trees) {
          this.trees = this.trees.concat(participant.entity.trees)
        }
        this.participants.push({
          status: participant.participant_status,
          origin: participant,
          ...participant.entity
        })
      })
    },
    resetModalState() {
      // Resets modal state
      this.$store.commit('updateActivityOutputModalState', false)
      this.clearEntities()
    },
    clearEntities() {
      this.participants = []
      this.trees = []
    },
    showInsertModal() {
      if(this.tabPaneActiveKey == 1) {
        this.segregateEntities()
        this.$store.commit('updateParticipantInsertModalState', true)
      }
    },
    insertedParticipant(){
      this.$emit('inserted', this.activity)
      this.resetModalState()
    }
  },
  computed: {
    ...mapState({
      showActivityModal: state => state.showActivityOutputModal
    })
  }
}
</script>

<style>

</style>