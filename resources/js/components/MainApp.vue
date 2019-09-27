<template>
    <div class="">
        <h1>main app</h1>
        <router-view>
        </router-view>
    </div>
</template>

<script>
  import Home from "./Home";
  import Login from "./auth/Login";

  export default {
    name: 'main-app',
    components: {
      Home,
      Login
    },
    props: {},
  };
</script>
