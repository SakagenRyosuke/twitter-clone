<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="container col-md-12">
        <div class="my-3 py-3 bg-body rounded shadow-sm">
          <h6 class="border-bottom px-3 pb-2 mb-0">userList</h6>
          <ul class="ps-0">
            <li class="px-3" v-for="user in userList">
              <router-link :to="'/home/user-list/' + user.id">
                <div class="d-flex text-muted pt-3">
                  <img class="bd-placeholder-img flex-shrink-0 me-2 rounded" width="32" height="32"
                    :src="user.profileImage" alt="">
                  <div class="pb-3 mb-0 small lh-sm border-bottom w-100">
                    <div class="d-flex justify-content-between">
                      <strong class="text-gray-dark">{{ user.name }}</strong>
                    </div>
                    <span class="d-block">{{ user.screenName }}</span>
                  </div>
                </div>
              </router-link>
              <button>Follow</button>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { onMounted, ref } from 'vue';
import UserList from './UserListDetailComponent.vue';
export default {
  components: {
    UserList
  },
  setup() {
    const userList = ref("")
    const getUserList = () => {
      axios.get('/userList').then(response => userList.value = response.data)
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

button {
  cursor: pointer;
  position: absolute;
  left: 90%;
  top: 50%;
  transform: translate(-50%, -50%);
  padding: 2px 10px;
  border-radius: 15px;
  background-color: #fff;
  border: 1px #333 solid;
  font-size: 12px;
  color: #333;
  transition: all .3s;
}

button:hover {
  border: 1px #0d6efd solid;
  color: #0d6efd;
}

li:hover {
  background-color: rgba(245, 245, 245, 0.8) !important;
}
</style>
