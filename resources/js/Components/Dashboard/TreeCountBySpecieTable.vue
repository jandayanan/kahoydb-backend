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
      :options="treeTypeOptions">
    </CFormSelect>
    <CFormSelect
      v-model="organization"
      aria-label="Select Organizataion"
      class="mt-3"
      :options="organizationOptions">
    </CFormSelect>
    <div class="d-flex mt-3">
      <span class="font-weight-bold">Trees Planted: {{ treesPlanted }}</span> 
    </div>
    <div class="d-flex justify-content-end">
      <CButton color="primary" @click="refresh">Refresh</CButton>
    </div>
    <div class="d-flex justify-content-center mt-3" v-if="isLoading">
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
import { getAllOrganizations } from '@/service/api'
import { mapState } from 'vuex';

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
    },
    treesPlanted: {
      type: Number,
      default: 0
    }
  },
  data(){
    return { 
      data: [],
      treeType: 'All Types',
      organization: '',
      organizationOptions: [{ label: 'All Organizations', value: '' }],
      pageSize: 5,
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
    },
    organization() {
      this.filterOrganizations()
    }

  },
  mounted(){
    this.getOrganizationOptions()
  },
  methods: {
    changeTreeType() {
      this.$emit('treeTypeSelected', this.treeType)
    },
    getOrganizationOptions(){
      getAllOrganizations()
      .then(res => {
        let organizationOptions = res.data.data.organizations.map(organization => {
          return {
            label: _.get(organization.entity, 'full_name', ''),
            value: _.get(organization.entity, 'full_name', '')
          }
        })

        this.organizationOptions = this.organizationOptions.concat(organizationOptions)
      })
    },
    filterOrganizations(){
      this.$emit('organizationSelected', this.organization)
    },
    refresh() {
      this.$emit('refresh')
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