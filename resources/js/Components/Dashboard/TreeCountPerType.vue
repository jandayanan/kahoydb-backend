<template>
  <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-3">
    <CContainer>
      <CRow>
        <template v-for="treeType in treeTypes" :key="treeType.id">
          <CCol lg="6" v-if="treeType.type == 'tree.type'" class="mb-2">
            <CWidgetStatsC 
              :value="shortenNum(treeType.treeCount)" 
              :title="treeType.description"
              inverse 
              class="text-light"  style="background-color: #76b5c5 !important;">
              <template #icon>
                <img v-if="treeType.key == 'fruit'" src="@/Assets/fruit.svg" alt="">
                <img v-if="treeType.key == 'hardwood'" src="@/Assets/tree.svg" alt="">
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
    treeTypes: {
      type: Array,
      default: [
        {
          type: 'tree.type',
          description: 'Fruit-bearing trees planted',
          treeCount: 0
        },
        {
          type: 'tree.type',
          description: 'Hardwood trees planted',
          treeCount: 0
        }
      ]
    }
  },
  data() {
    return {
      assetsUrl: `${location.host}/resources/js/Assets`
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