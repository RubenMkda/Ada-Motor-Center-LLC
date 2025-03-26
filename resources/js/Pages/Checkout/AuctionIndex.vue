<script setup>
import CheckoutLayout from '@/Layouts/CheckoutLayout.vue';
import { defineProps } from 'vue';
import { router } from '@inertiajs/vue3';

const props = defineProps({
  auction: Object,
});

const proceedToReserveFeePayment = () => {
  router.post(route('auctions.checkout.createOrder', { auction: props.auction.id }));
};
</script>

<template>
  <CheckoutLayout>
    <div class="flex flex-col space-y-4 text-gray-700 bg-gray-100 p-8 rounded">
      <h1 class="text-7xl tracking-wider font-helvetica text-center">{{ auction.name }}</h1>

      <div class="grid grid-cols-2 py-4">
        <div class="flex justify-center space-x-4">
          <img
            v-for="image in auction.images"
            :key="image.id"
            :src="image.url"
            :alt="`Imagen de la subasta ${auction.name}`"
            class="w-64 h-64 object-cover rounded-md shadow-green-950 shadow-xl"
          />
        </div>

        <!-- Sección de detalles de la subasta -->
        <div class="flex flex-col p-4 bg-gray-50 rounded-lg shadow-xl shadow-greenBold">
          <h2 class="text-4xl tracking-wider font-helvetica text-center py-4">Detalles de la Subasta</h2>
          <span class="text-lg">Precio Inicial: {{ auction.starting_price }}$</span>
          <span class="text-lg">Precio Actual: {{ auction.current_price }}$</span>
          <span class="text-lg">Fecha de Inicio: {{ auction.start_date }}</span>
          <span class="text-lg">Fecha de Fin: {{ auction.end_date }}</span>
          <span class="text-lg">Estado: {{ auction.status }}</span>
          <span class="text-lg">Tarifa de Reserva: {{ auction.reserve_fee }}$</span>
          <span class="text-lg">Precio del Vehículo: {{ auction.vehicle_price }}$</span>
        </div>
      </div>

      <!-- Botón para proceder al pago de la tarifa de reserva -->
      <button
        @click="proceedToReserveFeePayment"
        class="bg-primary text-gray-700 px-4 py-2 rounded font-bold"
      >
        Pagar Tarifa de Reserva
      </button>
    </div>
  </CheckoutLayout>
</template>