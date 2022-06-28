<template>
  <div class="fixed-top nav-content">
    <div class="d-flex flex-column p-3 bg-light nav-content">
      <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">
        <svg class="bi me-2" width="40" height="32">
          <use xlink:href="#bootstrap"></use>
        </svg>
        <span class="fs-4">Twitter Clone</span>
      </a>
      <hr>
      <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
          <router-link to="/home" class="nav-link link-dark" :class="{ 'active': $route.path === '/home' }">
            <svg class="bi me-2" width="16" height="16">
              <use xlink:href="#home"></use>
            </svg>
            Home
          </router-link>
        </li>
        <li class="nav-item">
          <router-link to="/home/user-list" class="nav-link link-dark" :class="{ 'active': $route.path === '/home/user-list' }">
            <svg class="bi me-2" width="16" height="16">
              <use xlink:href="#home"></use>
            </svg>
            User List
          </router-link>
        </li>
        <li class="nav-item">
          <router-link to="/home/create-tweet" class="nav-link link-dark" :class="{ 'active': $route.path === '/home/create-tweet' }">
            <svg class="bi me-2" width="16" height="16">
              <use xlink:href="#home"></use>
            </svg>
            Create Tweet
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
          <li><a class="dropdown-item" href="#">New project...</a></li>
          <li><a class="dropdown-item" href="#">Settings</a></li>
          <router-link :to="'/home/user-profile/' + user.id"><li><a class="dropdown-item">Profile</a></li></router-link>
          <li>
            <hr class="dropdown-divider">
          </li>
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

export default {
  setup() {
    const user = ref("")
    const getUser = () => {
      axios.get('/loginUser').then(response => user.value = response.data)
    }
    const logout = () => {
      axios
        .post("/logout")
        .then(() => {
          // login.vueを用意するつもり（時間があったら）
          // this.$router.push("/login");
          let url = location.href;
          location.href = url;
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
    width: 280px;
    height: 100%;
  }
  a {
    text-decoration: none;
  }
</style>
