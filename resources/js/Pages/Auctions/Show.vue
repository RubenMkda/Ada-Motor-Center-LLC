<script setup>
import { defineProps } from 'vue';
import HomeLayout from '@/Layouts/HomeLayout.vue';

const props = defineProps({
  auction: Object,
});
</script>

<template>
  <HomeLayout>
    <div class="container mx-auto px-4 py-8">
      <h1 class="text-3xl font-bold mb-6">{{ auction.name }}</h1>

      <div class="bg-white rounded-lg shadow-md p-6">
        <p class="text-gray-700 mb-4">{{ auction.description }}</p>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <h2 class="text-xl font-semibold mb-2">Detalles de la Subasta</h2>
            <ul class="space-y-2">
              <li><strong>Precio Inicial:</strong> {{ auction.starting_price }} €</li>
              <li><strong>Precio Actual:</strong> {{ auction.current_price }} €</li>
              <li><strong>Fecha de Inicio:</strong> {{ auction.start_date }}</li>
              <li><strong>Fecha de Fin:</strong> {{ auction.end_date }}</li>
            </ul>
          </div>

          <div>
            <h2 class="text-xl font-semibold mb-2">Imágenes</h2>
            <div class="grid grid-cols-2 gap-4">
              <img 
                v-for="image in auction.images" 
                :key="image.id" 
                :src="image.url" 
                :alt="auction.name" 
                class="rounded-lg shadow-md"
              />
            </div>
          </div>
        </div>

        <div class="mt-6 flex justify-between items-center">
          <a :href="auction.url" target="_blank" class="text-blue-500 hover:underline">
            Visitar Subasta Externa
          </a>
          <a 
            :href="route('auctions.checkout.show', { auction: auction.id })" 
            class="bg-blue-600 text-blue-500 px-6 py-2 rounded-lg hover:bg-blue-700 transition duration-300"
          >
            Pagar Ahora
          </a>
        </div>
      </div>
    </div>
  </HomeLayout>
</template>

<style scoped>
</style>