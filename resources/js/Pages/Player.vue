<template>
  <div class="page-padding">
    <!-- Player info -->
    <p class="player-title">{{ playerInfo.name }}
      <p v-if="playerInfo.clanName != ''" class="pointer gray-link">
        {{ playerInfo.clanName }}
      </p>
    </p>
    <p class="player-info">Created at: {{ playerInfo.createdAt }}</p>
    <!-- ### Player info -->
    <!-- Player statistics -->
    <div v-if="playerStatistics === null">Loading</div>
    <div class="shadow4" v-else>
      <Table :tableHead="tableHead" :tableData="statistics['topPlayersLast24Hours']" />
    </div>
    <!-- ### Player statistics -->
    <!-- Player vehicles -->
    <div v-if="playerVehicles.length === 0">Loading</div>
    <div v-else class="shadow4 table-container">
      <Table :tableHead="tableHead" :tableData="statistics['topPlayersLast24Hours']" />
    </div>
    <!-- ### Player vehicles -->
  </div>
</template>

<script setup>
import Table from '../Components/Table.vue';

defineProps({
  playerInfo: Object,
  playerStatistics: Object,
  playerVehicles: Array,
});

const tableHeadStatistics = ['Stats', 'Overall', 'Last Day', 'Last 7 days', 'Last month'];
const tableHeadVehicles = ['Nation', 'Name', 'Tier', 'Battles', 'Frags', 'Damage', 'Wins', 'WN8'];
</script>
