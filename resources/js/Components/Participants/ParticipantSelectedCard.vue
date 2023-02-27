<template>
  <div class="card bg-secondary text-high-emphasis-inverse">
    <div class="card-body pb-0 d-flex justify-content-between align-items-start">
      <div class="mb-3"> 
        <span class="fw-normal text-wrap text-center mb-5" style="font-size: 0.7rem;">
          {{ entity.full_name }}
        </span>
      </div>
      <CCloseButton @click="remove" />
    </div>
  </div>
</template>

<script>
import { CWidgetStatsA } from '@coreui/vue';

export default {
    name: "ParticipantSelectedCard",
    props: {
      entity: {
        type: Object,
        default: {}
      }
    },
    components: { CWidgetStatsA },
    methods: {
      remove(){
        this.$emit('removed', this.entity)
      }
    }
}
</script>

<style>

</style>