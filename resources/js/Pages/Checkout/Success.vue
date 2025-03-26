<script>
import CheckoutLayout from '@/Layouts/CheckoutLayout.vue';

export default {
  components: {
    CheckoutLayout,
  },
  props: {
    checkoutSession: Object,
  },
};
</script>

<template>
    <CheckoutLayout>
      <div class="min-h-screen flex flex-col items-center justify-center bg-gray-100 p-6">
        <div class="bg-white shadow-lg rounded-lg p-8 max-w-md w-full text-center">
          <h2 class="text-2xl font-bold text-green-600 mb-4">¡Pago Exitoso!</h2>
          <p class="text-gray-700 mb-6">Gracias por tu compra. Tu sesión de pago es: <span class="font-mono text-gray-900 w-16">{{ checkoutSession.id }}</span></p>
          <a :href="route('vehicles.index')" class="inline-block bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-blue-700 transition duration-300">
            Volver a la lista de vehículos
          </a>
        </div>
      </div>
    </CheckoutLayout>
</template>

<style scoped>
/* No es necesario agregar estilos adicionales ya que Tailwind maneja todo */
</style>