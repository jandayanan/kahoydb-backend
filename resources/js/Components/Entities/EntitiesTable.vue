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
          <th>Status</th>
          <th v-if="permission == 'write'">Actions</th>
        </tr>
      </template>
      <template #body="{rows}">
        <tr v-for="row in rows" :key="row.id" @click="selectedRow(row)">
          <td>{{ row.id }}</td>
          <td>{{ `${row.first_name} ${row.last_name}`}}</td>
          <td>{{ row.email }}</td>
          <td>{{ row.contact_number }}</td>
          <td>{{ row.status.toUpperCase() }}</td>
          <td v-if="permission == 'write'">
            <div class="d-flex">
              <CButton color="success" @click="updateRow(row)">
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
  </div>
</template>

<script>
import { mapState } from 'vuex'

export default {
  name: 'EntitiesTable',
  props: {
    items: {
      type: Array,
      default: []
    },
    permission: {
      type: String,
      default: 'write'
    }
  },
  data(){
    return {
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
  methods: {
    deleteRow(row) {
      this.$emit('deleteSelectedRow', row)
      this.$store.commit('updateDeleteModalState', true)
    },
    updateRow(row){
      this.$emit('updateSelectedRow', row)
    },
    selectedRow(row) {
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

</style>