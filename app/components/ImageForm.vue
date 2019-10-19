<template>
  <div class="row">
    <div class="col-md-6 col-md-offset-3">
      <img src="/images/document.png" width="50px" alt class="img-responsive center-block" />
      <p class="text-center">{{ step === 1 ? "ข้อมูลทั่วไป" : "เลือกจำนวน" }}</p>
    </div>
  </div>
</template>

<script>
export default {
  name: "ImageForm",
  props: ['step']
};
</script>