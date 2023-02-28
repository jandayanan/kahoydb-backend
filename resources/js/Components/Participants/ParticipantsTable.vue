<template>
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
    :data="data" 
    :filters="filters" 
    :selectOnClick="true"
    :page-size="pageSize"
    v-model:currentPage="currentPage"
    @totalPagesChanged="totalPages = $event"
    class="table table-striped table-hover">
    <template #head>
      <tr>
        <th>#</th>
        <th>Name</th>
        <th>Email</th>
        <th>Contact #</th>
        <th v-if="type == 'write'">Actions</th>
      </tr>
    </template>
    <template #body="{rows}">
      <tr v-for="row in rows" :key="row.id" @click="showInfoModal(row)">
          <td>{{ row.id }}</td>
          <td>{{ row.full_name }}</td>
          <td>{{ row.email }}</td>
          <td>{{ row.contact_number }}</td>
      </tr>
    </template>
  </VTable>
  <v-pagination
    v-model="currentPage"
    :pages="totalPages"
    :range-size="1"
    active-color="#DCEDFF"
  />
</template>

<script>
import { mapState } from 'vuex'
import ParticipantInfoModal from './ParticipantInfoModal.vue'
import _ from 'lodash'

export default {
  name: 'ParticipantsTable',
  components: {
    ParticipantInfoModal
  },  
  props: {
    items: {
      type: Array,
      default: []
    },
    tableType: {
      type: String,
      default: 'read'
    }
  },
  data(){
    return { 
      data: [],
      pageSize: 25,
      totalPages: 1,
      currentPage: 1,
      filters: {
        name: {
          value: '',
          keys: ['full_name', 'email']
        }
      }
    }
  },
  updated(){
    this.data = this.items
  },
  methods: {
    showInfoModal(row){
      this.$emit('selectedRow', row)
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