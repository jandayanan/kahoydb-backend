<template>
  <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-3">
    <CContainer>
      <CRow>
        <template v-for="(specie, i) in species" :key="specie.id" >
          <!-- Top 4 tree species planted -->
          <CCol lg="6" v-if="i < 4" class="mb-2">
            <CWidgetStatsC 
              :value="shortenNum(specie.treeCount)" 
              :title="specie.value"
              inverse 
              class="text-light"  style="background-color: #76b5c5 !important;">
              <template #icon>
                <img v-if="specie.key == 'fruit'" src="@/Assets/fruit.svg" alt="">
                <img v-if="specie.key == 'hardwood'" src="@/Assets/tree.svg" alt="">
              </template>
            </CWidgetStatsC>
          </CCol>
        </template>
      </CRow>
    </CContainer>
  </div>
</template>

<script>
export default {
  props: {
    treeSpecies: {
      type: Array,
      default: [
        {
          type: 'tree.species',
          description: 'Durian',
          treeCount: 0
        },
        {
          type: 'tree.species',
          description: 'Mango',
          treeCount: 0
        }
      ]
    }
  },
  data() {
    return {
      assetsUrl: `${location.host}/resources/js/Assets`,
      species: []
    }
  },
  watch: {
    treeSpecies: {
      handler(species) {
        this.species = species.filter(specie => {
          return specie.type == 'tree.species'
        })

        this.species.sort((specieA, specieB) => {
          return specieB.treeCount - specieA.treeCount
        })
      },
      deep: true
    }
  },
  methods: {
    shortenNum(num) {
      return Intl.NumberFormat().format(num)
    },
  }
}
</script>

<style>

</style>