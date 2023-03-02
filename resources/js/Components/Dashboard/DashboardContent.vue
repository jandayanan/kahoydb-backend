<template>
  <CContainer>
    <CRow>
      <CCol sm="12">
        <DashboardBanner />
      </CCol>
    </CRow>
    <CRow class="mt-4">
      <CCol sm="6">
        <TreeCountPerType :treeTypes="variables"/>
      </CCol>
      <CCol sm="6">
        <TreeCountBySpecie 
          :items="treesPerSpecie"
          :treeTypeOptions="treeTypeOptions"
          @treeTypeSelected="treeTypeChanged"/>
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
      treeTypeOptions: [{ label: 'All Types', value:'All Types' }]
    }
  },
  async created() {
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
        this.variables = res.data.data.variables
        this.variables.forEach(variable => {
          if(variable.type == 'tree.type') {
            this.treeTypeOptions.push({ label: variable.value, value: variable.value })
          }
          
        })
      })
    },
    async getTreeCountPerType(){
      // Filter trees per type
      this.variables.forEach(async variable => {
        if(variable.type == 'tree.type'){
          await getAllTrees(`tree_type=${variable.value}&tree_status=Planted`)
          .then(res => {
            variable.treeCount = res.data.data.trees.length
          })
        }
      })
    },
    async getTreesPerSpecies(){
      var trees = []
      var treesPlanted = []
      var treesPending = []
      var treesPerSpecie = []
      
      if(this.treeTypeSelected != 'All Types') {
        await getAllTrees(`tree_type=${this.treeTypeSelected}`)
        .then(res => {
          trees = res.data.data.trees
          console.log(trees)
        })
      } else {
        await getAllTrees()
        .then(res => {
          trees = res.data.data.trees
        })
      }

      // Get species available on the tree list
      var species = [...new Set(trees.map(tree => tree.tree_species))]

      species.forEach(async specie => { 
        treesPlanted = trees.filter(tree => {
          return (tree.tree_species == specie) && (tree.tree_status != 'Planting')
        }).length 

        treesPending = trees.filter(tree => {
          return (tree.tree_species == specie) && (tree.tree_status == 'Planting')
        }).length 

        treesPerSpecie.push({
          name: specie,
          planted: treesPlanted,
          pending: treesPending
        })
        console.log(treesPerSpecie)
      })
      this.treesPerSpecie = treesPerSpecie
      console.log(this.treesPerSpecie)
    },
    treeTypeChanged(treeType){
      this.treeTypeSelected = treeType
      this.getTreesPerSpecies()
    }
  }
}
</script>

<style>

</style>