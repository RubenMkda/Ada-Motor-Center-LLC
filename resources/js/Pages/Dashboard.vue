<script setup>
    import AppLayout from '@/Layouts/AppLayout.vue';

    const props = defineProps({
        auctionVehicles: {
            type: Array,
            required: true,
        },
    });
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="text-gray-700">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-4">Auction Vehicles</h3>
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Auction</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created At</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="vehicle in auctionVehicles" :key="vehicle.id">
                                <td class="px-6 py-4 whitespace-nowrap">{{ vehicle.id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ vehicle.auction.name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ vehicle.status }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ vehicle.created_at }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AppLayout>
</template>