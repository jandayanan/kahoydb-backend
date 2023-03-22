<template>
  <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-3">
    <select v-model="organization" @change="getOrganizationSummary" class="form-select mb-2">
      <option value="">-- All Organizations --</option>
      <option :value="org.id" v-for="org in organizations" :key="org.id">{{ org.entity.full_name }}</option>
    </select>
    <select v-model="year" @change="getOrganizationSummary" class="form-select mb-2">
      <option value="">-- All Years --</option>
      <option :value="year" v-for="year in years" :key="year">{{ year }}</option>
    </select>
    <div class="card text-white">
      <CChart
        type="bar"
        :redraw="true"
        :data="data"
        labels="months"
      />
    </div>
  </div>
</template>

<script>
import { getAllOrganizations, getTreeSumarry } from '@/service/api'

export default {
  data() {
    return {
      organization: "",
      year: "",
      organizations: [],
      years: [],
      months: [
        'January', 
        'February', 
        'March', 
        'April', 
        'May', 
        'June', 
        'July',
        'August',
        'September',
        'October',
        'November',
        'December'
      ],
      monthlyData: [0, 0, 0, 0 ,0 ,0 ,0, 0, 0, 0, 0, 0],
      data: [],
      treeSummary: []
    }
  },
  async mounted() {
    await this.getOrganizations()
    await this.getOrganizationSummary()
    this.getYears()
  },
  methods: {
    setData() {
      this.data = {
        labels: this.months, 
        datasets: [
          {
            label: 'Tree count',
            backgroundColor: '#f87979',
            data: this.monthlyData,
          }
        ]
      }
    },
    clearDataSet(){
      this.monthlyData = [0, 0, 0, 0 ,0 ,0 ,0, 0, 0, 0, 0, 0],
      this.data = []
    },
    async getOrganizations(){
      await getAllOrganizations()
      .then(res => {
        this.organizations = res.data.data.organizations
        this.organizations = this.organizations.filter(organization => organization.parent_organization_id === null)
      })
    },
    async setTreeSummary(args) {
      await getTreeSumarry(args)
      .then(res => {
        this.treeSummary = res.data.data
      })
    },
    async getYears() {
      var treeSummary = this.treeSummary
      this.years = treeSummary.map(summary => summary.year)
      .filter((value, index, self) => self.indexOf(value) === index)      
    },
    async getOrganizationSummary() {
      this.clearDataSet()
      await this.setTreeSummary()

      if(this.year != "") {
        await this.setTreeSummary(`year=${this.year}`)
      }
      
      if(this.organization != "") {
        this.treeSummary = this.treeSummary.filter(summary => summary.organization[0].id == this.organization)
      }
      
      this.treeSummary.forEach(summary => {
        for(var i = 1; i <= 12; i++) {
          this.monthlyData[i-1] += summary.months[i]
        }
      })

      this.setData()
    }
  }
}
</script>

<style>

</style>