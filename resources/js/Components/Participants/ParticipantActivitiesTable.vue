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
        <th>Name</th>
        <th>Start Date</th>
        <th>End Date</th>
        <th>Status</th>
      </tr>
    </template>
    <template #body="{rows}">
      <tr v-for="row in rows" :key="row.id">
        <td>{{ row.id }}</td>
        <td>{{ row.name }}</td>
        <td>{{ row.start_date }}</td>
        <td>{{ row.end_date }}</td>
        <td>{{ row.activity_status.toUpperCase() }}</td>
      </tr>
    </template>
  </VTable>
</template>

<script>
export default {
  name: 'ParticipantActivitiesTable',
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
          keys: ['name']
        }
      }
    }
  }
}
</script>

<style>

</style>