<script>
import CheckoutLayout from '@/Layouts/CheckoutLayout.vue';

export default {
  components: {
    CheckoutLayout,
  },
};
</script>

<template>
    <CheckoutLayout>
      <div class="checkout-cancel">
        <h2>Pago Cancelado</h2>
        <p>Tu pago ha sido cancelado. Puedes intentarlo de nuevo.</p>
        <a :href="route('vehicles.index')">Volver a la lista de vehículos</a>
      </div>
    </CheckoutLayout>
</template>

<style scoped>
    .checkout-cancel {
        text-align: center;
    }
</style>