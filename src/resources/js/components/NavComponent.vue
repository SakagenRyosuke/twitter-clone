<template>
  <div class="fixed-top nav-content">
    <div class="d-flex flex-column p-3 bg-light nav-content">
      <router-link to="/home" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">
        <span class="fs-5">Twitter Clone</span>
      </router-link>
      <hr>
      <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
          <router-link to="/home" class="nav-link link-dark" :class="{ 'active': $route.path === '/home' }">
            Home
          </router-link>
        </li>
        <li class="nav-item">
          <router-link to="/home/user-list" class="nav-link link-dark"
            :class="{ 'active': $route.path === '/home/user-list' }">
            User List
          </router-link>
        </li>
        <li class="nav-item">
          <router-link :to="'/home/user-profile/' + user.id" class="nav-link link-dark"
            :class="{ 'active': $route.path === '/home/user-profile/' + user.id }">
            Profile
          </router-link>
        </li>
      </ul>
      <hr>
      <div class="dropdown">
        <a href="#" class="d-flex align-items-center link-dark text-decoration-none dropdown-toggle" id="dropdownUser2"
          data-bs-toggle="dropdown" aria-expanded="false">
          <img :src="user.profileImage" alt="profile image" width="32" height="32" class="rounded-circle me-2">
          <strong>{{ user.screenName }}</strong>
        </a>
        <ul class="dropdown-menu text-small shadow" aria-labelledby="dropdownUser2">
          <li><button class="dropdown-item" @click="logout">
              logout
            </button></li>
        </ul>
      </div>
    </div>
  </div>
</template>

<script>
import { onMounted, ref } from 'vue';
import CreateTweet from './CreateTweetComponent.vue';

export default {
  components: {
    CreateTweet
  },
  setup() {
    const user = ref("")
    const getUser = () => {
      axios.get('/api/loginUser').then(response => user.value = response.data)
    }
    const logout = () => {
      axios
        .post("/api/logout")
        .then(() => {
          location.reload();
        })
        .catch(error => {
          console.log(error);
        });
    }
    onMounted(() => {
      getUser()
    })
    return {
      user,
      logout
    }
  },
};
</script>
<style scoped>
.nav-content {
  width: 200px;
  height: 100%;
}

a {
  text-decoration: none;
}

img {
  object-fit: cover;
}
</style>
