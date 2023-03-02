<template>
  <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-3">
    <h4>Tree count per Species</h4>
    <CFormInput
      type="text"
      size="md"
      placeholder="Search species"
      aria-label="lg input"
      v-model="filters.name.value"
      class="mt-3"
    />
    <CFormSelect
      v-model="treeType"
      aria-label="Select Tree Type"
      class="mt-3"
      :options="treeTypeOptions"
      @change="changeTreeType">
    </CFormSelect>
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
      class="table table-striped table-hover mt-3">
      <template #head>
        <tr>
          <th>Name</th>
          <th>Planted</th>
          <th>Pending</th>
        </tr>
      </template>
      <template #body="{rows}">
        <tr v-for="row in rows" :key="row.id">
            <td>{{ row.name }}</td>
            <td>{{ row.planted }}</td>
            <td>{{ row.pending }}</td>
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
export default {
  name: 'TreeCountBySpecieTable',
  props: {
    items: {
      type: Array,
      default: []
    },
    treeTypeOptions: {
      type: Array,
      default: []
    }
  },
  data(){
    return { 
      data: [],
      treeType: 'All Types',
      pageSize: 10,
      totalPages: 1,
      currentPage: 1,
      filters: {
        name: {
          value: '',
          keys: ['name']
        }
      }
    }
  },
  watch: {
    treeType(){
      this.changeTreeType()
    }
  },
  methods: {
    changeTreeType() {
      this.$emit('treeTypeSelected', this.treeType)
    }
  },
}
</script>

<style>
  tr {
    cursor: pointer;
  }
</style>