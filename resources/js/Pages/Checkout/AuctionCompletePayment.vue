<script setup>
import CheckoutLayout from '@/Layouts/CheckoutLayout.vue';
import { defineProps, ref } from 'vue';
import { router } from '@inertiajs/vue3';

const props = defineProps({
  order: Object,
  auction: Object,
});

const isModalOpen = ref(false);
const currentPaymentMethod = ref('');
const maxBid = ref(0); 

const formData = ref({
  accountNumber: '',
  amount: '',
  reference: '',
});

const payWithStripe = () => {
  router.get(route('auctions.checkout.process', { 
    auction: props.auction.id,
    max_bid: maxBid.value
  }));
};

const openModal = (method) => {
  currentPaymentMethod.value = method;
  isModalOpen.value = true;
};

const closeModal = () => {
  isModalOpen.value = false;
  formData.value = {
    accountNumber: '',
    amount: '',
    reference: '',
  };
};

const submitPayment = () => {
  router.post(route('auctions.checkout.processAlternativePayment'), {
    payment_method: currentPaymentMethod.value,
    ...formData.value,
    auction_id: props.auction.id,
    order_id: props.order.id,
  }, {
    onSuccess: () => {
      closeModal();
    },
    onError: (errors) => {
      console.error('Error al procesar el pago:', errors);
    }
  });
};
</script>

<template>
  <CheckoutLayout>
    <div class="flex flex-col space-y-4 text-gray-700 bg-gray-100 p-8 rounded">
      <h1 class="text-7xl tracking-wider font-helvetica text-center">{{ auction.name }}</h1>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="flex flex-col p-4 bg-gray-50 rounded-lg shadow-xl shadow-greenBold">
          <h2 class="text-4xl tracking-wider font-helvetica text-center py-4">Detalles de la Orden</h2>
          <span class="text-lg">Orden ID: {{ order.id }}</span>
          <span class="text-lg">Precio Total: {{ order.total_amount }}$</span>
          <span class="text-lg">Estado: {{ order.status }}</span>
          <span class="text-lg">Precio del Vehículo: {{ auction.vehicle_price }}$</span>
          <span class="text-lg">Tarifa de Reserva: {{ auction.reserve_fee }}$</span>
          
          <div class="mt-4">
            <label for="maxBid" class="block text-lg font-medium text-gray-700">Monto máximo de puja:</label>
            <input
              type="number"
              id="maxBid"
              v-model="maxBid"
              placeholder="Ingrese el monto máximo"
              class="w-full p-2 border rounded"
            />
          </div>
        </div>

        <div class="flex flex-col space-y-4 p-4 bg-gray-50 rounded-lg shadow-xl shadow-greenBold">
          <h2 class="text-4xl tracking-wider font-helvetica text-center py-4">Completar Pago</h2>
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
      </div>

      <!-- Modal para métodos de pago alternativos -->
      <div v-if="isModalOpen" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
        <div class="bg-white p-8 rounded-lg">
          <h3 class="text-2xl font-bold mb-4">Pagar con {{ currentPaymentMethod }}</h3>
          <form @submit.prevent="submitPayment">
            <div class="space-y-4">
              <input
                type="text"
                v-model="formData.accountNumber"
                placeholder="Número de cuenta"
                class="w-full p-2 border rounded"
              />
              <input
                type="text"
                v-model="formData.amount"
                placeholder="Monto"
                class="w-full p-2 border rounded"
              />
              <input
                type="text"
                v-model="formData.reference"
                placeholder="Referencia"
                class="w-full p-2 border rounded"
              />
            </div>
            <div class="mt-4 flex justify-end space-x-4">
              <button
                type="button"
                @click="closeModal"
                class="bg-gray-500 text-white px-4 py-2 rounded"
              >
                Cancelar
              </button>
              <button
                type="submit"
                class="bg-primary text-white px-4 py-2 rounded"
              >
                Pagar
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </CheckoutLayout>
</template>