<template>
  <div>
    <CFormInput
      type="text"
      size="md"
      placeholder="Search activity"
      aria-label="lg input"
      v-model="filters.name.value"
      class="mb-3"
    />
    <div class="d-flex justify-content-center" v-if="isLoading">
      <CSpinner color="success" />
    </div>
    <VTable :data="items" 
      v-if="!isLoading"
      :filters="filters" 
      :selectOnClick="true"
      class="table table-striped table-hover">
      <template #head>
        <tr>
          <th>#</th>
          <th>Name</th>
          <th>Start Date</th>
          <th>End Date</th>
          <th>Actions</th>
        </tr>
      </template>
      <template #body="{rows}">
        <tr v-for="row in rows" :key="row.id">
          <td>{{ row.id }}</td>
          <td>{{ row.name }}</td>
          <td>{{ row.start_date }}</td>
          <td>
            {{ row.end_date }}
          </td>
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
    <CModalBody>Are you sure you want to delete {{ name }} activity</CModalBody>
      <CModalFooter>
        <CButton color="secondary" @click="showDeleteModalVisible = false">Cancel</CButton>
        <CButton color="danger" @click="removeActivity">Delete</CButton>
      </CModalFooter>
    </CModal>
  </div>
</template>

<script>
import { getAllActivities, deleteActivity } from '@/service/api'
import { mapState } from 'vuex'

export default {
  name: 'ActivityTable',
  data(){
    return {
      columns: [
        {
          key: 'id',
          label: '#'
        },
        {
          key: 'name',
          label: 'Name'
        },
        {
          key: 'start_date',
          label: 'Start Date'
        },
        {
          key: 'end_date',
          label: 'End Date'
        },
        {
          label: 'Actions'
        }
      ],
      items: [], 
      filters: {
        name: {
          value: '',
          keys: ['name']
        }
      },
      activityId: null,
      showDeleteModalVisible: false
    }
  },
  mounted() {
    // Fetch all activities when component is mounted
    this.getActivities()
  },
  methods: {
    getActivities() {
      // Toggle loading state 
      this.$store.commit('toggleReload')

      getAllActivities()
      .then(res => {
        this.items = res.data.data.activities
        
        // Reset loading state
        this.$store.commit('toggleReload')
        this.$store.commit('updateNewDataStatus', false) 
      })
    },
    removeActivity(){
      deleteActivity(this.activityId)
      .then(() => {
        this.getActivities()
        this.showDeleteModalVisible = false
      })
    },
    showDeleteModal(id) {
      this.activityId = id
      this.showDeleteModalVisible = true
    },
    updateRow(row){
      console.log(row)
      this.$emit('updateSelectedRow', row)
    }
  },
  watch: {
    hasNewData(current, old) {
      // Triggers if there's a new activity inserted or updated, reloads table
      if(current == true) {
        this.getActivities()
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

<style scoped>
  td {
    cursor: pointer;
  }
</style>