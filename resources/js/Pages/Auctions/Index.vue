<script setup>
import { reactive, computed, watch } from 'vue';
import { router } from '@inertiajs/vue3';
import HomeLayout from '@/Layouts/HomeLayout.vue';

const props = defineProps({
  auctions: Object,
  filters: Object,
  priceRange: Object,
  canLogin: Boolean,
  canRegister: Boolean,
  sort: String, // Nuevo: Campo de ordenamiento actual
  direction: String, // Nuevo: Dirección de ordenamiento actual
});

const form = reactive({
  min_price: props.filters.min_price ?? props.priceRange.min,
  max_price: props.filters.max_price ?? props.priceRange.max,
});

// Función para actualizar el ordenamiento
const sortBy = (field) => {
  let direction = 'asc';
  if (props.sort === field && props.direction === 'asc') {
    direction = 'desc';
  }
  router.get(route('auctions.index'), {
    ...form,
    sort: field,
    direction: direction,
  }, {
    preserveState: true,
    replace: true,
  });
};

const updateMinPrice = (e) => {
  form.min_price = Math.min(Number(e.target.value), form.max_price);
};

const updateMaxPrice = (e) => {
  form.max_price = Math.max(Number(e.target.value), form.min_price);
};

const applyFilters = () => {
  router.get(route('auctions.index'), {
    ...form,
    min_price: form.min_price !== props.priceRange.min ? form.min_price : null,
    max_price: form.max_price !== props.priceRange.max ? form.max_price : null,
  }, {
    preserveState: true,
    replace: true,
  });
};

watch(
  () => ({ ...form }),
  () => {
    applyFilters(); 
  },
  { deep: true }
);
</script>

<template>
  <HomeLayout :can-login="canLogin" :can-register="canRegister">
    <div class="container mx-auto px-4">
      <h1 class="text-xl font-bold mb-4">Lista de Subastas</h1>

      <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h2 class="text-xl font-semibold mb-4">Filtrar Subastas</h2>
        
        <form @submit.prevent="applyFilters" class="space-y-4">
          <div class="space-y-2">
            <label class="block text-sm font-medium text-gray-700">Rango de Precio (€)</label>
            <div class="flex items-center gap-4">
              <div class="flex-1">
                <input
                  type="range"
                  v-model="form.min_price"
                  :min="priceRange.min"
                  :max="priceRange.max"
                  step="100"
                  class="w-full"
                  @input="updateMinPrice"
                />
                <span class="text-sm">{{ form.min_price }} €</span>
              </div>
              <div class="flex-1">
                <input
                  type="range"
                  v-model="form.max_price"
                  :min="priceRange.min"
                  :max="priceRange.max"
                  step="100"
                  class="w-full"
                  @input="updateMaxPrice"
                />
                <span class="text-sm">{{ form.max_price }} €</span>
              </div>
            </div>
          </div>
        </form>
      </div>

      <!-- DataTable -->
      <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <table class="min-w-full">
          <thead class="bg-gray-50">
            <tr>
              <th 
                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer"
                @click="sortBy('name')"
              >
                Nombre
                <span v-if="sort === 'name'">
                  {{ direction === 'asc' ? '↑' : '↓' }}
                </span>
              </th>
              <th 
                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer"
                @click="sortBy('description')"
              >
                Descripción
                <span v-if="sort === 'description'">
                  {{ direction === 'asc' ? '↑' : '↓' }}
                </span>
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Enlace</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <tr v-for="auction in auctions.data" :key="auction.id">
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ auction.name }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ auction.description }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-blue-500 hover:text-blue-700">
                <a :href="auction.url" target="_blank">Enlace de la subasta</a>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-blue-500 hover:text-blue-700">
                <a :href="route('auctions.show', auction.id)" target="_blank">Vista detallada</a>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <div class="mt-6 flex justify-center space-x-2">
        <button
          v-if="auctions.prev_page_url"
          @click="$inertia.visit(auctions.prev_page_url)"
          class="px-4 py-2 bg-gray-200 border rounded hover:bg-gray-300"
        >
        </button>
        <button
          v-if="auctions.next_page_url"
          @click="$inertia.visit(auctions.next_page_url)"
          class="px-4 py-2 bg-gray-200 border rounded hover:bg-gray-300"
        >
        </button>
      </div>
    </div>
  </HomeLayout>
</template>

<style scoped>
</style>