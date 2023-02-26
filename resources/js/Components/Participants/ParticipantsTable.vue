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
        </tr>
      </template>
      <template #body="{rows}">
        <tr v-for="row in rows" :key="row.id" @click="showInfoModal(row)">
          <td>{{ row.id }}</td>
          <td>{{ row.full_name }}</td>
          <td>{{ row.email }}</td>
          <td>{{ row.contact_number }}</td>
          <td>{{ row.status }}</td>
        </tr>
      </template>
    </VTable>
    <ParticipantInfoModal :entity="modalData"/>
  </div>
</template>

<script>
import { mapState } from 'vuex'
import { getAllEntities} from '@/service/api'
import ParticipantInfoModal from './ParticipantInfoModal.vue'

export default {
  name: 'ParticipantsTable',
  components: {
    ParticipantInfoModal
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
      modalData: [],
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
    showInfoModal(row){
      this.modalData = row
      this.$store.commit('updateParticipantInfoModalState', true)
    }
  },
  computed: {
    ...mapState({
      isLoading: state => state.isReloading,
    })
  }
}
</script>

<style>
  tr {
    cursor: pointer;
  }
</style>