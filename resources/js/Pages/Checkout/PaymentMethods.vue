
<script>
import CheckoutLayout from '@/Layouts/CheckoutLayout.vue';

export default {
  components: {
    CheckoutLayout,
  },
  props: {
    vehicle: Object,
    order: Object,
  },
  data() {
    return {
      isModalOpen: false,
      currentPaymentMethod: '',
      formData: {
        accountNumber: '',
        amount: '',
        reference: '',
      },
    };
  },
  methods: {
    payWithStripe() {
      this.$inertia.get(route('checkout.process', { vehicle: this.vehicle.id }));
    },
    openModal(method) {
      this.currentPaymentMethod = method;
      this.isModalOpen = true;
    },
    closeModal() {
      this.isModalOpen = false;
      this.formData = {
        accountNumber: '',
        amount: '',
        reference: '',
      };
    },
    submitPayment() {
      console.log('Datos del formulario:', this.formData);
      this.closeModal();
    },
  },
};
</script>
<template>
    <CheckoutLayout>
      <div class="flex flex-col space-y-4 text-gray-700 bg-gray-100 p-8 rounded">
        <h1 class="text-7xl tracking-wider font-helvetica text-center">{{ vehicle.make.name }} {{ vehicle.model.name }}</h1>
  
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
  
        <h2 class="text-4xl tracking-wider font-helvetica text-center py-4">Métodos de Pago</h2>
  
        <div class="flex flex-col space-y-4">
          <button
            @click="payWithStripe"
            class="bg-primary text-gray-700 px-4 py-2 rounded font-bold"
          >
            Pagar con Stripe
          </button>
  
          <button
            @click="openModal('zelle')"
            class="bg-primary text-gray-700 px-4 py-2 rounded font-bold"
          >
            Pagar con Zelle
          </button>
  
          <button
            @click="openModal('transfer')"
            class="bg-primary text-gray-700 px-4 py-2 rounded font-bold"
          >
            Pagar con Transferencia
          </button>
  
          <button
            @click="openModal('deposit')"
            class="bg-primary text-gray-700 px-4 py-2 rounded font-bold"
          >
            Pagar con Depósito Bancario
          </button>
        </div>
  
        <!-- Modal para métodos de pago -->
        <div v-if="isModalOpen" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
          <div class="bg-white p-8 rounded-lg">
            <h3 class="text-2xl font-bold mb-4">Pagar con {{ currentPaymentMethod }}</h3>
            <form @submit.prevent="submitPayment">
              <div class="space-y-4">
                <input type="text" v-model="formData.accountNumber" placeholder="Número de cuenta" class="w-full p-2 border rounded">
                <input type="text" v-model="formData.amount" placeholder="Monto" class="w-full p-2 border rounded">
                <input type="text" v-model="formData.reference" placeholder="Referencia" class="w-full p-2 border rounded">
              </div>
              <div class="mt-4 flex justify-end space-x-4">
                <button type="button" @click="closeModal" class="bg-gray-500 text-white px-4 py-2 rounded">Cancelar</button>
                <button type="submit" class="bg-primary text-white px-4 py-2 rounded">Pagar</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </CheckoutLayout>
</template>
  
 