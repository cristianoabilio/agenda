<template>
  <div class="overflow-auto">
    <b-table
      id="my-table"
      striped hover
      :items="items"
      :per-page="perPage"
      :current-page="currentPage"
      :fields="fields"
      small
    ></b-table>

    <div class="mt-3">
      <b-pagination 
        v-model="currentPage" 
        :total-rows="rows"
        :per-page="perPage"
        size="sm">
        </b-pagination>
    </div>
  </div>
</template>

<script>
  export default {
    props: {
        perPage: Number,
        items: Array,
        fields: Array
    },      
    data() {
      return {
        currentPage: 1,
      }
    },
    computed: {
      rows() {
        return this.items.length
      }
    }
  }
</script>