<template>
  <Nav></Nav>
  <div class="main">
    <router-view />
  </div>
  <CreateTweet></CreateTweet>
</template>
<script>
import Nav from "./components/NavComponent.vue";
import CreateTweet from './components/CreateTweetComponent.vue';
import axios from 'axios';

axios.defaults.headers.common = {
  'X-Requested-With': 'XMLHttpRequest',
  'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
};

export default {
  components: { Nav, CreateTweet },
};
</script>
<style scoped>
.main {
  width: 60%;
  min-width: 600px;
  margin-left: 300px;
}
</style>
