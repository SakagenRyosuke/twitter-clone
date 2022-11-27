<template>
  <Nav class="nav-content" :class="show ? 'show' : ''"></Nav>
  <button class="fs-4 toggleBtn" @click="action">Menu</button>
  <div class="container main">
    <router-view />
  </div>
  <CreateTweet></CreateTweet>
</template>
<script>
import Nav from "./components/NavComponent.vue";
import CreateTweet from './components/CreateTweetComponent.vue';
import { ref } from 'vue';
import axios from 'axios';

axios.defaults.headers.common = {
  'X-Requested-With': 'XMLHttpRequest',
  'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
};

export default {
  components: { Nav, CreateTweet },
  setup() {
    const show = ref(false);
    const action = () => {
      show.value = !show.value;
    }
    return {
      show,
      action
    }
  }
};
</script>
<style scoped>
.main {
  max-width: 700px;
}

.toggleBtn {
  visibility: hidden;
  position: fixed;
  top: 14px;
  right: 14px;
  width: 100px;
  padding: 2px;
  border: none;
  color: #0d6efd;
  z-index: 3000;
  background-color: rgba(255, 255, 255, 0);
}

@media only screen and (max-width:1100px) {
  .nav-content {
    left: 0%;
    transform: translateX(-100%);
    transition: all .3s;
  }

  .show {
    transform: translateX(0%) !important;
  }

  .toggleBtn {
    visibility: visible !important;
  }
}
</style>
