<template>
    <div class="">
        {{welcome}}
        <h2>Home</h2>
    </div>
</template>

<script>
  export default {
    name: 'home',
    props: {},
    computed: {
      welcome() {
        return this.$store.getters.welcome
      }
    }
  };
</script>
