<script setup>
import { ref, onMounted } from 'vue';
import { Head } from '@inertiajs/vue3';
import Carousel from '@/Components/Carousel.vue';
import HomeLayout from '@/Layouts/HomeLayout.vue'; 

const elements = ref<HTMLElement[]>([]);

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
});

onMounted(() => {
    elements.value = document.querySelectorAll('.fade-target');
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.remove('invisible');
                entry.target.classList.add('fade-in');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.3 });
    
    elements.value.forEach(el => observer.observe(el));
});
</script>

<template>
    <HomeLayout :can-login="canLogin" :can-register="canRegister">
        <Head title="Welcome" />
        <Carousel />
                    <article class="fade-target invisible grid gap-6 lg:grid-cols-1 px-2 lg:gap-8 container mx-auto py-12">
                        <h1 class="uppercase font-helvetica-bold">Bienvenido a ADA Motor Center:
                            <span class="text-8xl"><br>Los Mejores</span>
                            <span class="text-8xl"><br>Vehículos</span>
                            <span class="text-8xl"><br>Al mejor precio</span>
                        
                        </h1>
                        <p class="text-secondary px-8 mt-2 text-lg">
                            <strong>ADA Motor Center</strong> es tu mejor opción para comprar automóviles nuevos y usados en Georgia. 
                            Descubre nuestra amplia selección de vehículos certificados y encuentra el auto perfecto para ti hoy mismo. 
                            Visítanos y experimenta la excelencia en servicio y calidad que nos distingue.
                        </p>
                    </article>
                    <article class="fade-target invisible grid grid-cols-1 text-white md:grid-cols-2 bg-greenBold text-center space-x-6 px-4 py-12">
                        <div class="flex flex-col justify-center items-center cols-span-1 px-4">
                            <svg xmlns="http://www.w3.org/2000/svg"  width="80"  height="80"  viewBox="0 0 24 24"  fill="none"  stroke="white"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-car"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 17m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M17 17m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M5 17h-2v-6l2 -5h9l4 5h1a2 2 0 0 1 2 2v4h-2m-4 0h-6m-6 -6h15m-6 0v-5" /></svg>
                            <h2 class="py-4 uppercase text-xl font-helvetica-bold">Vehículos usados</h2>
                            <p class="text-seconday">
                                Explora nuestra impresionante selección de vehículos usados en ADA Motor Center.
                                Cada automóvil ha sido meticulosamente inspeccionado para garantizar la calidad y confiabilidad que mereces. 
                                Desde sedanes familiares hasta camionetas robustas, tenemos el vehículo perfecto para adaptarse a tu estilo de vida y presupuesto. 
                                Visítanos hoy y encuentra tu próximo automóvil usado con total confianza.
                            </p>
                        </div>
                        <div class="flex flex-col justify-center items-center cols-span-1 px-4">
                            <svg  xmlns="http://www.w3.org/2000/svg"  width="80"  height="80"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-tags"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 8v4.172a2 2 0 0 0 .586 1.414l5.71 5.71a2.41 2.41 0 0 0 3.408 0l3.592 -3.592a2.41 2.41 0 0 0 0 -3.408l-5.71 -5.71a2 2 0 0 0 -1.414 -.586h-4.172a2 2 0 0 0 -2 2z" /><path d="M18 19l1.592 -1.592a4.82 4.82 0 0 0 0 -6.816l-4.592 -4.592" /><path d="M7 10h-.01" /></svg>                            <h2 class="py-4 uppercase text-xl font-helvetica-bold">Autos Nuevos</h2>
                            <p class="text-seconday">
                                Descubre lo último en innovación automotriz con nuestra línea de vehículos nuevos en ADA Motor Center. 
                                Desde modelos deportivos hasta SUVs familiares, cada automóvil nuevo en nuestro inventario combina tecnología avanzada, 
                                diseño elegante y rendimiento excepcional. Ya sea que busques eficiencia energética, seguridad avanzada o lujo sin igual, 
                                estamos aquí para ayudarte a encontrar tú automóvil nuevo.
                            </p>
                        </div>
                    </article>

                    <article class="fade-target invisible grid grid-cols-1 md:grid-cols-3 container mx-auto my-7 text-center">
                        <div class="my-4 py-2 px-2">
                            <header class="py-4 text-xl">
                                <h3>Nuevos y Usados</h3>
                            </header>
                            <main>
                                <p>
                                    En ADA Motor Center, ofrecemos una amplia gama de vehículos nuevos y usados, 
                                    cada uno cuidadosamente seleccionado para asegurar calidad y satisfacción en tu experiencia de compra
                                </p>
                            </main>
                        </div>
                        <div class="my-4 py-2 px-2">
                            <header class="py-4 text-xl">
                                <h3>0% APR Financiamiento</h3>
                            </header>
                            <main>
                                <p>
                                    Ofrecemos financiamiento con 0% APR para que puedas comprar tu auto sin intereses y con pagos mensuales accesibles.
                                    ¡Visítanos y descubre cómo calificar para este beneficio exclusivo!
                                </p>
                            </main>
                        </div>
                        <div class="my-4 py-2 px-2">
                            <header class="py-4 text-xl">
                                <h3>Paquete de Mantenimiento</h3>
                            </header>
                            <main>
                                <p>
                                    Ofrecemos paquetes de mantenimiento completos para mantener tu auto en óptimas condiciones. 
                                    ¡Aprovecha nuestros servicios y garantiza el mejor rendimiento para tu vehículo!
                                </p>
                            </main>
                        </div>
                        <div class="my-4 py-2 px-2">
                            <header class="py-4 text-xl">
                                <h3>Informes del historial del vehículo</h3>
                            </header>
                            <main>
                                <p>
                                    Proporcionamos informes detallados del historial del vehículo para que compres con total confianza. 
                                    ¡Conoce todo sobre tu próximo auto antes de realizar la compra!
                                </p>
                            </main>
                        </div>
                        <div class="my-4 py-2 px-2">
                            <header class="py-4 text-xl">
                                <h3>Comprar, vender, intercambiar</h3>
                            </header>
                            <main>
                                <p>
                                    Facilitamos el proceso de comprar, vender e intercambiar autos. 
                                    Ofrecemos las mejores ofertas y una experiencia sin complicaciones para que encuentres el vehículo ideal o vendas el tuyo rápidamente. 
                                    ¡Visítanos hoy mismo!
                                </p>
                            </main>
                        </div>
                        <div class="my-4 py-2 px-2">
                            <header class="py-4 text-xl">
                                <h3>Nuevos y Usados</h3>
                            </header>
                            <main>
                                <p>
                                    En ADA Motor Center, ofrecemos una amplia gama de vehículos nuevos y usados, 
                                    cada uno cuidadosamente seleccionado para asegurar calidad y satisfacción en tu experiencia de compra
                                </p>
                            </main>
                        </div>
                    </article>
    </HomeLayout>
</template>