<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DashboardContent from '@/Components/Dashboard/DashboardContent.vue'
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    page: String
})
</script>

<template>
    <Head title="Dashboard" />
    <AuthenticatedLayout :page="page">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <DashboardContent />
            </div>
        </div>
    </AuthenticatedLayout>
</template>
