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
      <tr v-for="row in rows" :key="row">
        <td>{{ $_.get(row, 'id', null) }}</td>
        <td>{{ $_.get(row, 'name', null) }}</td>
        <td>{{ $_.get(row, 'start_date', null) }}</td>
        <td>{{ $_.get(row, 'end_date', null) }}</td>
        <td>{{ ($_.get(row, 'activity_status', null)) ? $_.get(row, 'activity_status', null).toUpperCase():null }}</td>
      </tr>
    </template>
  </VTable>
</template>

<script>
export default {
  name: 'ParticipantActivitiesTable',
  inject: ['$_'],
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