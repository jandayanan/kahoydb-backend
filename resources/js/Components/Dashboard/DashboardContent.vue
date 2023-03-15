<template>
  <CContainer>
    <CRow class="mt-4">
      <CCol sm="6">
        <TreeCountPerType :treeTypes="variables"/>
      </CCol>
      <CCol sm="6">
        <TreeCountBySpecie 
          :items="treesPerSpecie"
          :treeTypeOptions="treeTypeOptions"
          :treesPlanted="treesPlanted"
          @treeTypeSelected="treeTypeChanged"
          @organizationSelected="organizationChanged" 
          @refresh="refresh" />
      </CCol>
      <CCol>
      </CCol>
    </CRow>
  </CContainer>
  
</template>

<script>
import { tree } from '@/Assets/icons/tree'
import { getAllVariables, getAllTrees } from '@/service/api'
import DashboardBanner from './DashboardBanner.vue'
import TreeCountPerType from './TreeCountPerType.vue'
import TreeCountBySpecie from './TreeCountBySpecieTable.vue'

export default {
  components: {
    DashboardBanner,
    TreeCountPerType,
    TreeCountBySpecie
  },
  data() {
    return {
      trees: [],
      variables: [],
      treesPerSpecie: [],
      treeTypeSelected: 'All Types',
      organizationSelected: 'All Organizations',
      treesPlanted: 0,
      treeTypeOptions: [{ label: 'All Types', value:'All Types' }]
    }
  },
  async created() {
    this.$store.commit('toggleReload')
    await this.getVariables()
    this.getTreeCountPerType()
    this.getTreesPerSpecies()
  },
  methods: {
    async getTrees(args=''){
      getAllTrees(args)
      .then(res => {
        this.trees = res.data.data.trees
      })
    },
    async getVariables() {
      await getAllVariables()
      .then(res => {

        if(res.data.code == 200) {
          this.variables = res.data.data.variables
          this.variables.forEach(variable => {
            if(variable.type == 'tree.type') {
              this.treeTypeOptions.push({ label: variable.value, value: variable.value })
            }
          })
        }
      })
    },
    async getTreeCountPerType(){
      // Filter trees per type
      this.variables.forEach(async variable => {
        if(variable.type == 'tree.type'){
          await getAllTrees(`tree_type=${variable.value}&tree_status=Planted`)
          .then(res => {

            if(res.data.code == 200){
              variable.treeCount = res.data.data.trees.length
            }
          })
          .catch(err => {
            variable.treeCount = 0
          })
        }
      })
    },
    async getTreesPerSpecies(){
      var args = `relations[0]=activity.parentOrganization.entity&
        relations[1]=activity.childOrganization.entity`
      var trees = []
      var treesPlanted = []
      var treesPending = []
      var treesPerSpecie = []
      this.treesPerSpecie = []
      
      if(this.treeTypeSelected != 'All Types') {
        

        await getAllTrees(`tree_type=${this.treeTypeSelected}&${args}`)
        .then(res => {
          if(res.data.code == 200) {
            trees = res.data.data.trees
          }
        })
      } else {
        await getAllTrees(args)
        .then(res => {
          if(res.data.code == 200) {
            trees = res.data.data.trees
          }
        })
      }

      // Get species available on the tree list
      var species = [...new Set(trees.map(tree => tree.tree_species))]
      var treesPlantedCtr = 0

      species.forEach(async specie => { 
        treesPlanted = trees.filter(tree => {
          return (tree.tree_species == specie) && (tree.tree_status != 'Planting')
        }) 

        treesPending = trees.filter(tree => {
          return (tree.tree_species == specie) && (tree.tree_status == 'Planting')
        }) 
        treesPerSpecie.push({
          name: specie,
          planted: this.filterByOrganization(treesPlanted).length,
          pending: this.filterByOrganization(treesPending).length
        })

        treesPlantedCtr += this.filterByOrganization(treesPlanted).length
      })
      this.$store.commit('toggleReload')
      this.treesPerSpecie = treesPerSpecie
      this.treesPlanted = treesPlantedCtr
    },
    filterByOrganization(trees) {{
      if(this.organizationSelected != 'All Organizations'){
        let treesFiltered = trees.filter(tree => {
          return _.get(tree.activity.parent_organization, 'entity.full_name') == this.organizationSelected ||
          (tree.activity.child_organization && _.get(tree.activity.child_organization, 'entity.full_name') == this.organizationSelected)
        })
        return treesFiltered
      } 
      return trees      
    }},
    treeTypeChanged(treeType){
      this.treeTypeSelected = treeType
      this.refresh()
    },
    organizationChanged(organization) {
      this.organizationSelected = organization
      this.refresh()
    },
    refresh(){
      this.$store.commit('toggleReload')
      this.getTreesPerSpecies()
    }
  }
}
</script>

<style>

</style>