<template>
  <span class="help-block">{{ message }}</span>
</template>

<script>
export default {
  name: 'HelpBlock',
  props: {
    message: {
      type: String,
      default: ''
    }
  }
}
</script>

<style scoped></style>
