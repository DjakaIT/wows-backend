<template>
  <div class="overflow-x-auto">
    <table class="min-w-full table-auto border-collapse border border-gray-200">
      <thead>
        <tr class="bg-gray-100 text-left">
          <th v-for="(item, index) in tableHead" :key="`th-${item.id}`" class="border-b" >
            {{ item }}
          </th>
        </tr>
      </thead>
      <tbody>
        <!-- Iterating over the passed 'tableData' prop -->
        <tr v-for="(item, index) in tableData" :key="`tr-${item.id}`" class="border-b">
          <td class="py-2 px-4">{{ item.name }}</td>
          <td class="py-2 px-4">{{ item.wn8 }}</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script setup>
import { defineProps } from 'vue';

// Defining the 'tableData' prop directly in the setup block
const props = defineProps({
  tableData: {
    type: Object,
    required: true
  },
  tableHead: {
    type: Array,
    required: true
  }
});

// tableData is automatically available in the template
</script>

<style scoped>
/* Optional custom styles for better table design */
table {
  width: 100%;
  border: 1px solid #ddd;
  border-radius: 8px;
}

th, td {
  text-align: left;
  padding: 10px;
}

th {
  background-color: #f3f4f6;
}
</style>
