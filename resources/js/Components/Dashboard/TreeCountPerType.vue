<template>
  <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-3">
    <CContainer>
      <CRow>
        <template v-for="treeType in treeTypes" :key="treeType.id">
          <CCol v-if="treeType.type == 'tree.type'">
            <CWidgetStatsC 
              :value="shortenNum(treeType.treeCount)" 
              :title="treeType.description"
              inverse 
              class="text-light"  style="background-color: #76b5c5 !important;">
              <template #icon>
                <img :src=" treeType.key == 'fruit' ? 'fruit.svg': treeType.key == 'hardwood' ? 'tree.svg': '' ">
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
      default: []
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