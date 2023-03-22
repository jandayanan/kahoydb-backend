<template>
  <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-3">
    <div class="card text-white bg-success">
      <div class="card-body text-center">
        <h1 class="font-weight-bold">
          <vue3-autocounter ref='counter' :startAmount='0' :endAmount="count" :duration='3' />
        </h1>
        <h4>Trees planted</h4>
      </div>
    </div>
  </div>
</template>
<script>  
import Vue3autocounter from 'vue3-autocounter';
import { getAllTrees } from '@/service/api'

export default {
  components: {
    'vue3-autocounter': Vue3autocounter
  },
  data() {
    return {
      count: 0
    }
  },
  async mounted() {
    await this.getTreeCount()
  },
  methods: {
    async getTreeCount() {
      await getAllTrees(`tree_status=Planted`)
      .then(res => {
        this.count = res.data.data.trees.length
      })
    }
  }
}
</script>