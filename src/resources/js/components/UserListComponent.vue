<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="container col-md-12 mt-5">
        <ul class="ps-0">
          <li class="card" v-for="user in userList">
            <router-link :to="'/home/user-profile/' + user.id">
              <div class="card-haeder p-3 w-100 d-flex">
                <img class="rounded-circle" width="50" height="50" :src="user.profileImage" alt="">
                <div class="ms-2 d-flex flex-column">
                  <p class="mb-0">{{ user.name }}</p>
                  <p class="text-secondary">{{ user.screenName }}</p>
                </div>
              </div>
            </router-link>
            <div class="button">
              <Button :id="user.id"></Button>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </div>
</template>

<script>
import { onMounted, ref } from 'vue';
import Button from './ButtonComponent.vue';
export default {
  components: {
    Button
  },
  setup() {
    const userList = ref("")
    const getUserList = () => {
      axios.get('/userList').then(response => {
        userList.value = response.data;
      })
    }
    onMounted(() => {
      getUserList()
    })
    return {
      userList,
    }
  }
};
</script>
<style scoped>
li {
  list-style: none;
  transition: all .3s;
  position: relative;
}

a {
  text-decoration: none;
}

p {
  color: #333;
}

.button {
  position: absolute;
  left: 90%;
  top: 50%;
  transform: translate(-50%, -50%);
}

li:hover {
  background-color: rgba(245, 245, 245, 0.8) !important;
}
</style>
