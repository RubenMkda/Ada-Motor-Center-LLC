<script>
import CheckoutLayout from '@/Layouts/CheckoutLayout.vue';

export default {
  components: {
    CheckoutLayout,
  },
  props: {
    vehicle: Object,
    vehicleMake: String,
    vehicleModel: String,
  },
  methods: {
    proceedToPayment() {
      this.$inertia.post(route('vehicles.checkout.createOrder', { vehicle: this.vehicle.id }));
    },
  },
};
</script>

<template>
  <CheckoutLayout>
    <div class="flex flex-col space-y-4 text-gray-700 bg-gray-100 p-8 rounded">
      <h1 class="text-7xl tracking-wider font-helvetica text-center">{{ vehicleMake }} {{ vehicleModel }}</h1>

      <div class="grid grid-cols-2 py-4">
        <div class="flex justify-center space-x-4">
          <img
            v-for="photo in vehicle.photos"
            :key="photo.id"
            :src="`/storage/${photo.photo_path}`" 
            :alt="`Imagen del vehículo ${vehicle.make.name} ${vehicle.model.name}`"
            class="w-64 h-64 object-cover rounded-md shadow-green-950 shadow-xl "
          />
        </div>

        <div class="flex flex-col p-4 bg-gray-50 rounded-lg shadow-xl shadow-greenBold">
          <h2 class="text-4xl tracking-wider font-helvetica text-center py-4">Especificaciones</h2>
          <span class="text-lg">Precio: {{ vehicle.price }}$</span>
          <span class="text-lg">Año: {{ vehicle.year }}</span>
          <span class="text-lg">VIN: {{ vehicle.VIN }}</span>
          <span class="text-lg">Estado: {{ vehicle.status }}</span>
        </div>
     </div>

      <button
        @click="proceedToPayment"
        class="bg-primary text-gray-700 px-4 py-2 rounded font-bold"
      >
        Pagar Ahora
      </button>
    </div>
  </CheckoutLayout>
</template>