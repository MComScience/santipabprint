<template>
  <div class="mainContent full-width clearfix">
    <div class="container">
      <div v-if="loading" class="page-loader">Loading...</div>
      <div v-show="!loading">
        <h1>About page</h1>
        <p>
          This is the About page 555
        </p>
        <router-link to="/login">Go to Login</router-link>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'AboutPage',
  head: {
    // if no subcomponents specify a metaInfo.title, this title will be used
    title: 'Default Title',
    // all titles will be injected into this template
    titleTemplate: '%s | บริษัท สันติภาพแพ็คพริ้นท์ จำกัด'
  },
  data() {
    return {
      loading: true
    }
  },
  mounted: function() {
    this.$nextTick(function() {
      this.loading = false
    })
  }
}
</script>

<style scoped></style>
