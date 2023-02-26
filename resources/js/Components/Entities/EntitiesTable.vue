<template>
  <div>
    <CFormInput
      type="text"
      size="md"
      placeholder="Search entity"
      aria-label="lg input"
      v-model="filters.name.value"
      class="mb-3"
    />
    <div class="d-flex justify-content-center" v-if="isLoading">
      <CSpinner color="success" />
    </div>
    <VTable 
      v-if="!isLoading"
      :data="items" 
      :filters="filters" 
      :selectOnClick="true"
      class="table table-striped table-hover">
      <template #head>
        <tr>
          <th>#</th>
          <th>Name</th>
          <th>Email</th>
          <th>Contact #</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </template>
      <template #body="{rows}">
        <tr v-for="row in rows" :key="row.id">
          <td>{{ row.id }}</td>
          <td>{{ `${row.first_name} ${row.last_name}`}}</td>
          <td>{{ row.email }}</td>
          <td>{{ row.contact_number }}</td>
          <td>{{ row.status }}</td>
          <td>
            <div class="d-flex">
              <CButton color="success" @click="updateRow(row)">
                <CIcon
                class="nav-icon"
                :icon="'cil-pencil'">
                </CIcon>
              </CButton>
              <CButton color="danger" class="ml-2" @click="showDeleteModal(row.id)">
                <CIcon
                class="nav-icon"
                :icon="'cil-x-circle'">
                </CIcon>
              </CButton>
            </div>
          </td>
        </tr>
      </template>
    </VTable>
    <CModal :visible="showDeleteModalVisible" @close="showDeleteModalVisible = false">
    <CModalBody>Are you sure you want to delete {{ name }} entity</CModalBody>
      <CModalFooter>
        <CButton color="secondary" @click="showDeleteModalVisible = false">Cancel</CButton>
        <CButton color="danger" @click="removeEntity">Delete</CButton>
      </CModalFooter>
    </CModal>
  </div>
</template>

<script>
import { mapState } from 'vuex'
import { getAllEntities, deleteEntity } from '@/service/api'

export default {
  name: 'EntitiesTable',
  data(){
    return {
      
      items: [], 
      filters: {
        name: {
          value: '',
          keys: ['full_name', 'email']
        }
      },
      entityId: null,
      showDeleteModalVisible: false
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
    removeEntity(){
      deleteEntity(this.entityId)
      .then(() => {
        this.getEntities()
        this.showDeleteModalVisible = false
      })
    },
    showDeleteModal(id) {
      this.entityId = id
      this.showDeleteModalVisible = true
    },
    updateRow(row){
      this.$emit('updateSelectedRow', row)
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
      isLoading: state => state.isReloading,
      hasNewData: state => state.hasNewData
    })
  }
}
</script>

<style>

</style>