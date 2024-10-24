<template>
    <div>
        <header>
            <nav>
                <Link href="/">Home</Link>
                <Link href="/wiki">Wiki</Link>
            </nav>
        </header>
    </div>
    <main>
        <!-- Page slot-->
        <slot />
    </main>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
</script>
