<template>
  <CFormInput
    type="text"
    size="md"
    placeholder="Search organization"
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
        <th>Type</th>
        <th v-if="permission == 'write'">Actions</th>
      </tr>
    </template>
    <template #body="{rows}">
      <tr v-for="row in rows" :key="row.id">
          <td>{{ row.organization.id }}</td>
          <td>{{ row.full_name }}</td>
          <td>{{ $_.get(row, 'organization.organization_type', '').toUpperCase() }}</td>
          <td v-if="permission == 'write'">
            <div class="d-flex">
              <CButton color="success" @click="selectedRow(row)">
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
              <CButton color="danger" class="ml-2" @click="deleteRow(row)">
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
</template>

<script>
import { mapState } from 'vuex'
import OrganizationInfoModal from './OrganizationInfoModal.vue'
import _ from 'lodash'

export default {
  name: 'OrganizationsTable',
  inject: ['$_'],
  components: {
    OrganizationInfoModal
  },  
  props: {
    items: {
      type: Array,
      default: []
    },
    permission: {
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
          keys: ['full_name']
        }
      }
    }
  },
  updated(){
    this.data = this.items
  },
  methods: {
    updateRow(row) {
      this.$emit('updateSelectedRow', row)
    },
    deleteRow(row) {
      this.$emit('deleteSelectedRow', row)
      this.$store.commit('updateDeleteModalState', true)
    },
    selectedRow(row){
      this.$emit('selectedRow', row)
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