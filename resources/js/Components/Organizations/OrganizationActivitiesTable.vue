<template>
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
      </tr>
    </template>
    <template #body="{rows}">
      <tr v-for="row in rows" :key="row.id" >
        <td>{{ row.id }}</td>
        <td>{{ row.name }}</td>
        <td>{{ row.start_date }}</td>
        <td>{{ row.end_date }}</td>
        <td>{{ row.activity_status.toUpperCase() }}</td>
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

export default {
  name: 'OrganizationActivitiesTable',
  props: {
    items: {
      type: Array,
      default: []
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
          keys: ['name',]
        }
      }
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