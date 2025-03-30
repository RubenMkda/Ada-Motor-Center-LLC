<script setup lang="ts">
import { defineProps } from "vue";
import HomeLayout from '@/layouts/HomeLayout.vue';

interface Photo {
  id: number;
  photo_path: string;
}

interface Vehicle {
  id: number;
  make: string;
  model: string;
  year: number;
  price: number;
  status: string;
  VIN: string;
  photos: Photo[];
}

const props = defineProps<{
  vehicle: Vehicle;
}>();
</script>

<template>
  <HomeLayout>
    <div class="container mx-auto px-4 py-8">
      <h1 class="text-3xl font-bold mb-6">{{ vehicle.make }} {{ vehicle.model }}</h1>

      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mb-8">
        <div v-for="photo in vehicle.photos" :key="photo.id" class="bg-white rounded-lg shadow-md overflow-hidden">
          <img 
            :src="`/storage/${photo.photo_path}`" 
            alt="Foto del vehículo" 
            class="w-full h-48 object-cover"
          />
        </div>
      </div>

      <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-xl font-semibold mb-4">Detalles del Vehículo</h2>
        <div class="space-y-2">
          <p><span class="font-medium">Marca:</span> {{ vehicle.make }}</p>
          <p><span class="font-medium">Modelo:</span> {{ vehicle.model }}</p>
          <p><span class="font-medium">Año:</span> {{ vehicle.year }}</p>
          <p><span class="font-medium">Precio:</span> {{ vehicle.price }} €</p>
          <p><span class="font-medium">Estado:</span> {{ vehicle.status }}</p>
          <p><span class="font-medium">VIN:</span> {{ vehicle.VIN }}</p>
        </div>
      </div>

      <div class="mt-6">
        <a 
          :href="route('vehicles.index')" 
          class="px-4 py-2 bg-gray-200 border rounded hover:bg-gray-300"
        >
          Volver a la lista
        </a>
       
      </div>
    </div>
  </HomeLayout>
</template>

<style scoped>
/* Estilos adicionales si los necesitas */
</style>