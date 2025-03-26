<script>
export default {
  name: 'CheckoutLayout',
};
</script>

<template>
  <div class="checkout-layout bg-greenBold">
    <header>
      <div id="logo">
        <img src="/images/logo-principal.png" class="h-10 w-10" alt="Logo">
      </div>
    </header>
    <main class="container mx-auto">
      <slot></slot>
    </main>
    <footer>
      <p>© 2023 Tu Empresa</p>
    </footer>
  </div>
</template>

<style scoped>
.checkout-layout {
  display: flex;
  flex-direction: column;
  min-height: 100vh;
  font-family: 'Roboto', sans-serif;
}

header {
  display: flex;
  justify-content: space-between;
  padding: 20px;
  margin-bottom: 20px;
}

header div {
  width: 100px;
  height: 40px;
  overflow: visible;
}

#logo img {
  width: 100%;
  height: auto;
}

#cart {
  width: 150px;
  min-width: 100px;
  border-radius: 10px;
  text-transform: uppercase;
  color: #fff;
  display: flex;
  align-items: center;
  justify-content: center;
}

main {
  flex: 1;
  padding: 2rem;
}

footer {
  text-align: center;
  padding: 10px;
  color: #FBFBFB;
}

footer a {
  color: #FBFBFB;
  padding: 0 20px;
  text-decoration: none;
}

footer a:hover {
  color: #336AC9;
}
</style>