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
    <VTable 
      v-if="!isLoading"
      :data="items" 
      :filters="filters"
      :page-size="pageSize"
      v-model:currentPage="currentPage"
      @totalPagesChanged="totalPages = $event"
      class="table table-striped table-hover">
      <template #head>
        <tr>
          <th>#</th>
          <th>Name</th>
          <th>Start Date</th>
          <th>End Date</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </template>
      <template #body="{rows}">
        <tr v-for="row in rows" :key="row.id" >
          <td>{{ row.id }}</td>
          <td>{{ row.name }}</td>
          <td>{{ row.start_date }}</td>
          <td>{{ row.end_date }}</td>
          <td>{{ row.activity_status.toUpperCase() }}</td>
          <td>

            <div class="d-flex">
              <CButton color="success" @click="showActivityOutputModal(row)">
                <CIcon
                  class="nav-icon"
                  :icon="'cil-lightbulb'">
                </CIcon>
              </CButton>
              <CButton color="success" class="ml-2" @click="updateRow(row)">
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
    <v-pagination
      v-model="currentPage"
      :pages="totalPages"
      :range-size="1"
      active-color="#DCEDFF"
    />
    <ActivityOutputModal 
      :activity="activity"
      @inserted="reloadOutputModal"
      @deleted="reloadOutputModal"/>

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
import { mapState } from 'vuex'
import { getAllActivities, deleteActivity } from '@/service/api'
import ActivityOutputModal from './ActivityOutputModal.vue'

export default {
  name: 'ActivityTable',
  components: {
    ActivityOutputModal
  },
  data(){
    return {
      items: [], 
      currentPage: 1,
      totalPages: 1,
      pageSize: 25,
      filters: {
        name: {
          value: '',
          keys: ['name']
        }
      },
      activityId: null,
      activity: {},
      showDeleteModalVisible: false
    }
  },
  mounted() {
    // Fetch all activities when component is mounted
    this.getActivities()
  },
  methods: {
    async getActivities() {
      // Toggle loading state 
      this.$store.commit('toggleReload')

      await getAllActivities('relations[0]=participants.entity.trees&relations[1]=trees.planter.participant')
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
      this.$emit('updateSelectedRow', row)
    },
    showActivityOutputModal(row) {
      this.activity = row
      this.$store.commit('updateActivityOutputModalState', true)
    },
    async reloadOutputModal(activity) {
      await this.getActivities()
      this.activity = this.items.filter(item => item.id === activity.id)[0] 
      this.$store.commit('updateActivityOutputModalState', true)
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