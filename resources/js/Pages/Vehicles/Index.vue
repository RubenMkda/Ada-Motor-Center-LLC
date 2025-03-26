<script setup>
import { reactive, computed, watch } from 'vue';
import { router } from '@inertiajs/vue3';
import HomeLayout from '@/Layouts/HomeLayout.vue';

const props = defineProps({
  vehicles: Object,
  filters: Object,
  makes: Array,
  models: Array,
  priceRange: Object,
  canLogin: Boolean,
  canRegister: Boolean,
});

const form = reactive({
  make_id: props.filters.make_id || '', // Cambiar a make_id
  model_id: props.filters.model_id || '', // Cambiar a model_id
  year: props.filters.year || '',
  min_price: props.filters.min_price ?? props.priceRange.min,
  max_price: props.filters.max_price ?? props.priceRange.max,
  status: props.filters.status || '',
});

// Filtrar modelos localmente en función de la marca seleccionada
const filteredModels = computed(() => {
  if (!form.make_id) return [];
  return props.models.filter(model => model.make_id === form.make_id);
});

const updateMinPrice = (e) => {
  form.min_price = Math.min(Number(e.target.value), form.max_price);
};

const updateMaxPrice = (e) => {
  form.max_price = Math.max(Number(e.target.value), form.min_price);
};

// Función para enviar los filtros automáticamente
const applyFilters = () => {
  router.get(route('vehicles.index'), {
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
      <h1 class="text-xl font-bold mb-4">Lista de Vehículos</h1>

      <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h2 class="text-xl font-semibold mb-4">Filtrar vehículos</h2>
        
        <form @submit.prevent="applyFilters" class="space-y-4">
          <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
            <!-- Select Marca -->
            <div>
              <label class="block text-sm font-medium text-gray-700">Marca</label>
              <select v-model="form.make_id">
                <option value="">Selecciona una marca</option>
                <option v-for="make in makes" :key="make.id" :value="make.id">
                  {{ make.name }}
                </option>
              </select>
            </div>

            <!-- Select Modelo -->
            <div>
              <label class="block text-sm font-medium text-gray-700">Modelo</label>
              <select v-model="form.model_id">
                <option value="">Selecciona un modelo</option>
                <option v-for="model in filteredModels" :key="model.id" :value="model.id">
                  {{ model.name }}
                </option>
              </select>
            </div>

            <!-- Año -->
            <div>
              <label class="block text-sm font-medium text-gray-700">Año</label>
              <input
                type="number"
                v-model="form.year"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                placeholder="Año"
              />
            </div>
          </div>

          <!-- Rango de Precio -->
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

      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        <a 
          v-for="vehicle in vehicles.data" 
          :key="vehicle.id" 
          :href="route('vehicles.show', vehicle.id)" 
          class="bg-white rounded-lg shadow-md overflow-hidden block hover:shadow-lg transition-shadow"
        >
          <img 
            v-if="vehicle.photos && vehicle.photos.length > 0"
            :src="`/storage/${vehicle.photos[0].photo_path}`" 
            alt="Foto del vehículo" 
            class="w-full h-48 object-cover"
          />
          <img 
            v-else
            src="/images/placeholder-car.jpg" 
            alt="Foto no disponible" 
            class="w-full h-48 object-cover"
          />

          <div class="p-4">
            <h2 class="text-lg font-semibold">{{ vehicle.make.name }} {{ vehicle.model.name }}</h2>
            <p class="text-gray-600">{{ vehicle.year }}</p>
            <p class="text-gray-800 font-bold">{{ vehicle.price }} €</p>
            <p class="text-sm text-gray-500">Estado: {{ vehicle.status }}</p>
          </div>
        </a>
      </div>

      <!-- Paginación -->
      <div class="mt-6 flex justify-center space-x-2">
        <button
          v-if="vehicles.prev_page_url"
          @click="$inertia.visit(vehicles.prev_page_url)"
          class="px-4 py-2 bg-gray-200 border rounded hover:bg-gray-300"
        >
          Anterior
        </button>
        <button
          v-if="vehicles.next_page_url"
          @click="$inertia.visit(vehicles.next_page_url)"
          class="px-4 py-2 bg-gray-200 border rounded hover:bg-gray-300"
        >
          Siguiente
        </button>
      </div>
    </div>
  </HomeLayout>
</template>

<style scoped>
</style>