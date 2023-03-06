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
              @inserted="upserted" />
            <ParticipantUpsertModal 
              :method="participantUpsertMethod" 
              :participant="selectedParticipant" 
              :activityId="activity.id" 
              @inserted="upserted" />
            <TreeUpsertModal 
              :activity="activity"
              :participants="participants"
              :method="treeUpsertMethod"
              :tree="tree"
              @inserted="upserted" />
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
              :permission="'write'"
              :showInfo="false"
              @selectedRow="selectedParticipantRow" 
              @deleteSelectedRow="deleteParticipantRow"
              @updateSelectedRow="updateParticipantRow"/>

              <ParticipantInfoModal 
                :entity="participantModalData" />
          </CTabPane>
          <CTabPane role="tabpanel" aria-labelledby="trees-tab" :visible="tabPaneActiveKey === 2">
            <TreesTable 
              :items="trees" 
              :permission="'write'"
              @updateSelectedRow="updateTreeRow"
              @deleteSelectedRow="deleteTreeRow" />
          </CTabPane>
        </CTabContent>
      </CContainer>
      <DeleteModal
        :entityId="entityId"
        :entityName="entityName"
        :entityType="entityType"
        @deleted="deleted" />
    </CModalBody>
  </CModal>
  
</template>

<script>
import { mapState } from 'vuex'
import TreesTable from '@/Components/Trees/TreesTable.vue'
import ParticipantsTable from '@/Components/Participants/ParticipantsTable.vue'
import ParticipantInsertModal from '@/Components/Participants/ParticipantInsertModal.vue'
import ParticipantUpsertModal from '@/Components/Participants/ParticipantUpsertModal.vue'
import ParticipantInfoModal from '@/Components/Participants/ParticipantInfoModal.vue'
import TreeUpsertModal from '@/Components/Trees/TreeUpsertModal.vue'
import ActivityOutputInfo from './ActivityOutputInfo.vue'
import DeleteModal from '@/Components/DeleteModal.vue'

export default {
  name: "ActivityOutputModal",
  components: {
    TreesTable,
    ParticipantsTable,
    ParticipantInsertModal,
    ParticipantUpsertModal,
    ParticipantInfoModal,
    TreeUpsertModal,
    ActivityOutputInfo,
    DeleteModal
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
      
      participant: {},
      participantUpsertMethod: 'create',
      selectedParticipant: null,

      treeUpsertMethod: 'create',
      tree: {},
      trees: [],

      entityId: null,
      entityName: null,
      entityType: 'entity'
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
          activity: participant.activity,
          origin: participant,
          trees: participant.entity.trees,
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
        this.participantUpsertMethod = 'create'
        this.$store.commit('updateParticipantUpsertModalState', true)
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
    deleteTreeRow(row) {
      this.entityId = row.id
      this.entityName = `"${row.tree_species} - ${row.planter.full_name}"`
      this.entityType = 'tree'
    },
    upserted(){
      this.$emit('upserted', this.activity)
      this.resetModalState()
    },
    deleted(){
      this.$emit('deleted', this.activity)
      this.resetModalState()
    },
    selectedParticipantRow(row){
      this.participantModalData = {
        participants: row,
        ...row
      }
    },
    updateParticipantRow(row) {
      this.participantUpsertMethod = 'update' 
      this.selectedParticipant = row
      this.$store.commit('updateParticipantUpsertModalState', true)
    },
    deleteParticipantRow(row) {
      console.log(row)
      this.entityId = row.origin.id
      this.entityName = `"${row.full_name}"`
      this.entityType = 'participant'
    } 
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