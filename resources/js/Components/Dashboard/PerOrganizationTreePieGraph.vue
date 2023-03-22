<template>
  <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-3">
    <div class="card text-white">
      <CChart
        type="pie"
        :redraw="true"
        :data="orgData"
      />
    </div>
  </div>
</template>

<script>
import  { getAllOrganizations, getTreeSumarry } from '@/service/api'

export default {
  data() {
    return {
      organizations: [],
      orgData: {},
      data: [],
      treeSumarry: []
    }
  },
  async mounted(){
    await this.getOrganizations()
    await this.setTreeSummary()
    await this.setData()
  },
  methods: {
    setData()  {
      var labels = []
      var colors = []
      var data = []     
      this.organizations.forEach(org => {
        let treeSummary = this.treeSumarry
        let treeCount = 0

        treeSummary = treeSummary.filter(summary => _.get(summary, 'organization[0].id') == org.id)
        treeSummary.forEach(summary => treeCount += summary.total)

        labels.push(org.entity.full_name)
        colors.push(this.generateColor())
        data.push(treeCount)
      })

      this.orgData = {
        labels: labels,
        datasets: [
          {
            backgroundColor: colors,
            data: data
          }
        ]
      }

    },
    async getOrganizations(){
      await getAllOrganizations()
      .then(res => {
        this.organizations = res.data.data.organizations
        this.organizations = this.organizations.filter(organization => organization.parent_organization_id === null)
      })
    },
    async setTreeSummary(){
      await getTreeSumarry()
      .then(res => {
        this.treeSumarry = res.data.data
      })
    },
    generateColor() {
      return `#${Math.floor(Math.random()*16777215).toString(16)}`
    }
  }
}
</script>

<style>

</style>