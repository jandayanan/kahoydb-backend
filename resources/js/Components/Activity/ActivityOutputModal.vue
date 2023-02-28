<template>
  <CModal size="xl" backdrop="static" :visible="showActivityModal" @close="resetModalState" id="activityModal">
    <CModalHeader>
      <CModalTitle>Activity Output</CModalTitle>
    </CModalHeader>
    <CModalBody>
      <CContainer>
        <ActivityOutputInfo 
          :activity="activity"
          :participants="participants"
          :trees="trees" />
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
              @inserted="inserted"/>
            <TreeUpsertModal 
              :activity="activity"
              :participants="participants"
              :method="treeUpsertMethod"
              :tree="tree"
              @inserted="inserted" />
          </CCol>
        </CRow>
      </CContainer>
      <CContainer class="mt-3">
        <CNav variant="tabs" role="tablist">
          <CNavItem>
            <CNavLink
              href="javascript:void(0);"
              :active="tabPaneActiveKey === 1"
              @click="() => {$store.commit('setActivityOutputTabPaneKey', 1)}"
            >
              Participants
            </CNavLink>
          </CNavItem>
          <CNavItem>
            <CNavLink
              href="javascript:void(0);"
              :active="tabPaneActiveKey === 2"
              @click="() => {$store.commit('setActivityOutputTabPaneKey', 2)}"
            >
              Trees
            </CNavLink>
          </CNavItem>
        </CNav>
        <CTabContent class="mt-4">
          <CTabPane role="tabpanel" aria-labelledby="participants-tab" :visible="tabPaneActiveKey === 1">
            <ParticipantsTable 
              :items="participants" 
              @selectedRow="selectedParticipantRow"/>
          </CTabPane>
          <CTabPane role="tabpanel" aria-labelledby="trees-tab" :visible="tabPaneActiveKey === 2">
            <TreesTable 
              :items="trees" 
              :permission="'write'"
              @updateSelectedRow="updateTreeRow" />
          </CTabPane>
        </CTabContent>
      </CContainer>
    </CModalBody>
  </CModal>
  
</template>

<script>
import { mapState } from 'vuex'
import TreesTable from '@/Components/Trees/TreesTable.vue'
import ParticipantsTable from '@/Components/Participants/ParticipantsTable.vue'
import ParticipantInsertModal from '@/Components/Participants/ParticipantInsertModal.vue'
import TreeUpsertModal from '@/Components/Trees/TreeUpsertModal.vue'
import ActivityOutputInfo from './ActivityOutputInfo.vue'

export default {
  name: "ActivityOutputModal",
  components: {
    TreesTable,
    ParticipantsTable,
    ParticipantInsertModal,
    TreeUpsertModal,
    ActivityOutputInfo
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
      treeUpsertMethod: 'create',
      tree: {}
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
        this.participants.push({
          status: participant.participant_status,
          origin: participant,
          ...participant.entity
        })
      })
      this.activity.trees.forEach((tree) => {
        this.trees.push(tree)
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
      this.segregateEntities()

      if(this.tabPaneActiveKey == 1) {
        this.$store.commit('updateParticipantInsertModalState', true)
      } 
      else if(this.tabPaneActiveKey == 2) {
        this.treeUpsertMethod = 'create'
        this.$store.commit('updateTreeUpsertModalState', true)
      }
    },
    updateTreeRow(row) {
      this.tree = row
      this.treeUpsertMethod = 'update'
      this.$store.commit('updateTreeUpsertModalState', true)
    },
    inserted(){
      this.$emit('inserted', this.activity)
      this.resetModalState()
    },
  },
  computed: {
    ...mapState({
      showActivityModal: state => state.showActivityOutputModal,
      tabPaneActiveKey: state => state.activityOutputTabPaneKey
    })
  }
}
</script>

<style>

</style>