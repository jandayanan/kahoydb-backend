<template>
  <swiper
    :slidesPerView="3"
    :spaceBetween="30"
    :loop="true"
    :modules="modules"
    navigation
    class="mySwiper"
  >
    <swiper-slide>
      <img src="@/Assets/logo.png" alt="">
    </swiper-slide>
    <swiper-slide>
      <img src="@/Assets/doa_logo.png" alt="">
    </swiper-slide>
    <swiper-slide>
      <img src="@/Assets/placeholder.png" alt="">
    </swiper-slide>
     <swiper-slide>
      <img src="@/Assets/placeholder.png" alt="">
    </swiper-slide>
     <swiper-slide>
      <img src="@/Assets/placeholder.png" alt="">
    </swiper-slide>
  </swiper>
</template>
<script>
  // Import Swiper Vue.js components
  import { Swiper, SwiperSlide } from 'swiper/vue';

  // Import Swiper styles
  import 'swiper/css';

  import 'swiper/css/pagination';
  import 'swiper/css/navigation';

  // import required modules
  import { Pagination, Navigation } from 'swiper';

  export default {
    components: {
      Swiper,
      SwiperSlide,
      Navigation
    },
    setup() {
      return {
        modules: [Pagination, Navigation],
      };
    },
  };
</script>
<style scoped>
.swiper {
  width: 100%;
  height: 100%;
}

.swiper-slide {
  text-align: center;
  font-size: 18px;
  background: transparent;

  /* Center slide text vertically */
  display: flex;
  justify-content: center;
  align-items: center;
}

.swiper-slide img {
  display: block;
  width: 50%;
  height: 100%;
  object-fit: cover;
}

</style>