<script setup>
import ParticipateLayout from '@/Layouts/ParticipateLayout.vue';
import DashboardContent from '@/Components/Dashboard/DashboardContent.vue'
import { Head } from '@inertiajs/vue3';

</script>

<template>
    <Head title="Public Dashboard" />
    <ParticipateLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <DashboardContent />
            </div>
        </div>
    </ParticipateLayout>
</template>
