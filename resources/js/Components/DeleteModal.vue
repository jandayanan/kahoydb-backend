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
import { deleteActivity, deleteEntity } from '@/service/api'

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
    remove() {
      if(this.entityType == 'activity') {
        deleteActivity(this.entityId)
        .then(() => {
          this.resetModalState()
        })
      }

      if(this.entityType == 'entity') {
        deleteEntity(this.entityId)
        .then(() => {
          this.resetModalState()
        })
      }
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