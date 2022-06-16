<template>
  <Nav></Nav>
  <div class="main">
    <router-view />
  </div>
</template>
<script>
import Nav from "./components/NavComponent.vue";

export default {
  components: { Nav }
};
</script>
<style scoped>
.main {
  width: 60%;
  min-width: 600px;
  margin-left: 300px;
}
</style>
