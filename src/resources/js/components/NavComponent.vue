<template>
  <div class="fixed-top" style="width: 280px;">
    <div class="d-flex flex-column p-3 bg-light" style="width: 280px; height: 100vh;">
      <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">
        <svg class="bi me-2" width="40" height="32">
          <use xlink:href="#bootstrap"></use>
        </svg>
        <span class="fs-4">title</span>
      </a>
      <hr>
      <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
          <router-link to="/home" class="nav-link link-dark" :class="{'active': $route.path === '/home'}">
            <svg class="bi me-2" width="16" height="16">
              <use xlink:href="#home"></use>
            </svg>
            Home
          </router-link>
        </li>
      </ul>
      <hr>
      <div class="dropdown">
        <a href="#" class="d-flex align-items-center link-dark text-decoration-none dropdown-toggle" id="dropdownUser2"
          data-bs-toggle="dropdown" aria-expanded="false">
          <img :src="user.profileImage" alt="" width="32" height="32" class="rounded-circle me-2">
          <strong>{{ user.screenName }}</strong>
        </a>
        <ul class="dropdown-menu text-small shadow" aria-labelledby="dropdownUser2">
          <li><a class="dropdown-item" href="#">New project...</a></li>
          <li><a class="dropdown-item" href="#">Settings</a></li>
          <li><a class="dropdown-item" href="#">Profile</a></li>
          <li>
            <hr class="dropdown-divider">
          </li>
          <li><a class="dropdown-item" @click="logout">
              logout
            </a></li>
        </ul>

      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      user: "",
    };
  },
  mounted() {
    axios.post('/home').then(response => this.user = response.data)
  },
  methods: {
    logout() {
      axios
        .post("/logout")
        .then(() => {
          // login.vueを用意するつもり（時間があったら）
          // this.$router.push("/login");
          location.href = 'http://localhost:8080/login';
        })
        .catch(error => {
          console.log(error);
        });
    }
  },
};
</script>
<style scoped>
</style>
