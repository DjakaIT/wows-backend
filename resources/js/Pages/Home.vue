<template>
    <div>Homepage - {{ user }}</div>
    <Table
        :tableHead="tableHead"
        :tableData="statistics['topPlayersLast24Hours']" />
</template>

<script setup>
import Table from '../Components/Table.vue';
    // Laravel passing data trough Inertia, recieving trough props in VUE
    defineProps({
        user: String,
        statistics: Object,
    });

    const tableHead = ['Player', 'WN8']
</script>