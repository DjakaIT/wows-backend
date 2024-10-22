<template>
    <div>Homepage - {{ user }}</div>
</template>

<script setup>
    // Laravel passing data trough Inertia, recieving trough props in VUE
    defineProps({
        user: String,
    });
</script>