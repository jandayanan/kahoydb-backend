<template>
  <CFormInput
    type="text"
    size="md"
    placeholder="Search entity"
    aria-label="lg input"
    v-model="filters.name.value"
    class="mb-3"
  />
  <VTable 
    :data="items" 
    :filters="filters" 
    :selectOnClick="true"
    class="table table-striped table-hover">
    <template #head>
      <tr>
        <th>#</th>
        <th>Type</th>
        <th>Planted at</th>
        <th>Donated At</th>
        <th>Latitude</th>
        <th>Longitude</th>
        <th>Status</th>
      </tr>
    </template>
    <template #body="{rows}">
      <tr v-for="row in rows" :key="row.id">
        <td>{{ row.id }}</td>
        <td>{{ row.tree_type }}</td>
        <td>{{ row.planted_at }}</td>
        <td>{{ row.donated_at }}</td>
        <td>{{ row.latitude }}</td>
        <td>{{ row.longitude }}</td>
        <td>{{ row.tree_status }}</td>
      </tr>
    </template>
  </VTable>
</template>

<script>
export default {
  name: 'ParticipantTreesTable',
  props: {
    items: {
      type: Array,
      default: []
    }
  },
  data() {
    return {
      filters: {
        name: {
          value: '',
          keys: [
            'planted_at', 
            'tree_status', 
            'tree_type'
          ]
        }
      }
    }
  }
}
</script>

<style>

</style>