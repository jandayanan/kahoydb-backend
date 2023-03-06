<template>
  <div>
    <CButton color="success" class="mb-3" @click="showInsertModal">Add User</CButton>
    <EntitiesTable 
      :items="items"
      @updateSelectedRow="showUpdateModal"
      @deleteSelectedRow="showDeleteModal" />
    <EntityUpsertModal 
      :method="entityFormMethod" 
      :entity="entity" />
    <DeleteModal 
      :entityId="entityId"
      :entityName="entityName"
      :entityType="entityType"/>
  </div>
</template>

<script>
import { mapState } from 'vuex'
import { getAllEntities } from '@/service/api'
import EntitiesTable from '@/Components/Entities/EntitiesTable.vue'
import EntityUpsertModal from '@/Components/Entities/EntityUpsertModal.vue'
import DeleteModal from '@/Components/DeleteModal.vue'

export default {
  name: 'EntitiesContent',
  components: {
    EntitiesTable,
    EntityUpsertModal,
    DeleteModal
  },
  data(){
    return {
      items: [], 
      filters: {
        name: {
          value: '',
          keys: ['full_name', 'email']
        }
      },
      entityFormMethod: 'create',
      entity: {},
      entityId: null,
      entityName: null,
      entityType: 'entity'
    }
  },
  mounted(){
    this.getEntities()
  },
  methods: {
    getEntities(){
      // Toggle loading state 
      this.$store.commit('toggleReload')

      getAllEntities()
      .then(res => {
        this.items = res.data.data.entity
        
        // Reset loading state
        this.$store.commit('toggleReload')
        this.$store.commit('updateNewDataStatus', false) 
      })
    },  
    showDeleteModal(row) {
      this.entityId = row.id
      this.entityName = `"${row.first_name} ${row.last_name}"'`
      this.$store.commit('updateDeleteModalState', true)
    },
    showUpdateModal(row){
      this.entity = row
      this.entityFormMethod = 'update'
      this.$store.commit('updateEntityUpsertModalState', true)
    },
    showInsertModal() {
      this.entityFormMethod = 'create'
      this.$store.commit('updateEntityUpsertModalState', true)
    }
  },
  watch: {
    hasNewData(current, old) {
      // Triggers if there's a new activity inserted or updated, reloads table
      if(current == true) {
        this.getEntities()
      }
    }
  },
  computed: {
    ...mapState({
      hasNewData: state => state.hasNewData
    })
  }
}
</script>

<style>

</style>