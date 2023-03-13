<template>
  <CContainer fluid style="background-color: #18583E;" class="p-4">
    <CRow>
      <p class="text-center text-uppercase text-white font-weight-bolder">Army 2040: World-Class. Multi-mission Ready. Cross-domain capable</p>
    </CRow>
    <CRow>
      <CCol md="4" class="d-flex justify-content-end justify-center-mobile mt-4">
        <img src="@/Assets/placeholder.png" style="height: 16vh;" alt="">
      </CCol>
      <CCol md="4" class="d-flex justify-content-center">
        <CRow>
          <CCol md="6" class="mt-4 d-flex justify-content-center">
            <img src="@/Assets/logo.png" style="height: 16vh;" alt="">
          </CCol>
          <CCol md="6" class="mt-4 d-flex justify-content-center">
            <img src="@/Assets/doa_logo.png" style="height: 16vh;" alt="">
          </CCol>
        </CRow>
        
      </CCol>
      <CCol md="4" class="text-center-mobile mt-4 d-flex justify-center-mobile" style="font-size: 1.6rem;">
        <div>
          <strong class="text-white text-uppercase">The Philippine Army</strong>
          <p class="text-white my-0 font-weight-bolder">in partnership with</p>
          <strong class="text-white text-uppercase">Department of Agriculture</strong>
        </div>
      </CCol>
    </CRow>
    
    
  </CContainer>  
  <CContainer fluid class="px-0">
    <div class="banner">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <CContainer>
          <h3 style="color: #18583E; font-size: 6rem;" class="my-0 h1-mobile text-center-mobile">Raising</h3>
          <h2 style="color: #0B4C08; font-size: 10rem;" class="text-uppercase h2-mobile text-center-mobile">One Million</h2>
        </CContainer>
      </div>
      
    </div>
    <div class="banner-background">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h3 style="color: #FCDB02; font-size: 6rem;" class="my-0 h1-mobile text-center-mobile text-uppercase">Fruit-bearing Trees</h3>
      </div>
    </div>
  </CContainer>
  <CContainer fluid style="background-color: #18583E;" class="p-4">
    <slot />
  </CContainer>
  <CContainer fluid style="background-color: #18583E;" class="py-2 mt-5">
    <CRow>
      <CCol md-4>
        <img src="@/Assets/placeholder.png" style="height: 10vh;" alt="">
      </CCol>
      <CCol md-4 class="d-flex justify-content-center py-4">
        <div class="text-center text-uppercase text-white font-weight-bolder d-flex align-items-center">Honor. Patriotism. Duty</div>
      </CCol>
      <CCol md-4 class="d-flex justify-content-end">
        <img src="@/Assets/placeholder.png" style="height: 10vh;" alt="">
      </CCol>
    </CRow>
  </CContainer>  

</template>

<script>
export default {

}
</script>

<style scoped>
  .banner {
    
  }
  .banner-background {
    background-image: url(../planting_soldier.jpg);
    width: 100vw;
    min-height: 500px;
    -webkit-box-shadow: inset 0px 68px 18px 4px rgba(0,0,0,0.26);
    -moz-box-shadow: inset 0px 68px 18px 4px rgba(0,0,0,0.26);
    box-shadow: inset 0px 68px 18px 4px rgba(0,0,0,0.26);
  }
  @media only screen and (max-width: 767px){

    .text-center-mobile {
      text-align: center;
    }

    .justify-center-mobile {
      justify-content: center!important;
    }

    .h1-mobile {
      font-size: 3rem !important;
    }

    .h2-mobile {
      font-size: 5rem !important;
    }
  }

</style>