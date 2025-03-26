<script setup>
import { ref } from 'vue';
import { Swiper, SwiperSlide } from 'swiper/vue';
import 'swiper/css';
import 'swiper/css/effect-fade';
import 'swiper/css/navigation';
import 'swiper/css/pagination';
import { Navigation, Pagination, Autoplay, EffectFade } from 'swiper/modules';

const images = ref([
    { src: '/images/car-slider-2.webp', alt: 'Car-slider-2' },
    { src: '/images/car-slider-3.webp', alt: 'Car-slider-3' },
    { src: '/images/car-slider-4.webp', alt: 'Car-slider-4' },
    { src: '/images/car-slider-5.webp', alt: 'Car-slider-5' },
]);
</script>

<template>
    <Swiper
        :modules="[Navigation, Pagination, Autoplay, EffectFade]"
        :navigation="true"
        :pagination="{ clickable: true }"
        :autoplay="{ delay: 3000 }"
        :effect="'fade'"
        class="w-full h-96"
    >
        <SwiperSlide v-for="(image, index) in images" :key="index">
            <img :src="image.src" :alt="image.alt" class="w-full h-full object-cover" />
        </SwiperSlide>
    </Swiper>
</template>
