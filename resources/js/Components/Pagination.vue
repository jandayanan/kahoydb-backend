<template>
  <VPagination
    v-model:currentPage="currentPage"
    :total-pages="totalPages"
    :boundary-links="true">
  </VPagination>
</template>

<script>
export default {
  props: {
    totalPages: {
      type: Number,
      default: 0
    }
  },
  data(){
    return {
      currentPage: 1
    }
  },
  methods: {

  }
}
</script>

<style>

</style>