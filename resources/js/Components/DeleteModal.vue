<template>
  <CModal :visible="showModal" @close="$store.commit('updateDeleteModalState', false)">
    <CModalBody>Are you sure you want to delete {{ entityName }} {{ entityType }}</CModalBody>
    <CModalFooter>
      <CButton color="secondary" @click="$store.commit('updateDeleteModalState', false)">Cancel</CButton>
      <CButton color="danger" @click="remove">Delete</CButton>
    </CModalFooter>
  </CModal>
</template>

<script>
import { mapState } from 'vuex'
import { deleteActivity, deleteEntity, deleteTree, deleteParticipant, deleteOrganization } from '@/service/api'

export default {
  props: {
    entityId: {
      type: Number
    },
    entityType: {
      type: String,
    },
    entityName: {
      type: String,
      default: ''
    }
  },
  methods: {
    async remove() {
      if(this.entityType == 'activity') {
        await deleteActivity(this.entityId)
        .then(() => {
          this.resetModalState()
        })
      }

      else if(this.entityType == 'entity') {
        await deleteEntity(this.entityId)
        .then(() => {
          this.resetModalState()
        })
      }

      else if(this.entityType == 'tree') {
        await deleteTree(this.entityId)
        .then(() => {
          this.resetModalState()
        })
      }

      else if(this.entityType == 'participant') {
        await deleteParticipant(this.entityId)
        .then(() => {
          this.resetModalState()
        })
      }

      else if(this.entityType == 'organization') {
        await deleteOrganization(this.entityId)
        .then(() => {
          this.resetModalState()
        })
      }

      this.$emit('deleted')
    },
    resetModalState() {
      this.$store.commit('updateDeleteModalState', false)
      this.$store.commit('updateNewDataStatus', true)
    }
  },
  computed: {
    ...mapState({
      showModal: state => state.showDeleteModal
    })
  }
}
</script>

<style>

</style>