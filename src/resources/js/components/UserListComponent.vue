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
            <div class="followButton">
              <FollowButton :id="user.id"></FollowButton>
            </div>
          </li>
          <div class="mt-4 d-flex justify-content-center">
            <button :class="[is_showMore ? 'is_showMore' : '']" @click="is_addUserList">{{ text }}</button>
          </div>
        </ul>
      </div>
    </div>
  </div>
</template>

<script>
import { onMounted, ref } from 'vue';
import FollowButton from './FollowButtonComponent.vue';
export default {
  components: {
    FollowButton
  },
  setup() {
    const moreButton = ref("Show More")
    const userList = ref("")
    const is_showMore = ref(true);
    const page = ref(0);
    const maxPage = ref(0);
    const text = ref("Show More");
    const getMaxPage = () => {
      axios.get('/maxPage').then(response => {
        maxPage.value = response.data;
      })
    }
    const getUserList = () => {
      axios.get('/userList/' + (page.value + 1)).then(response => {
        userList.value = response.data;
        page.value++;
      })
    }
    const addUserList = () => {
      axios.get('/userList/' + (page.value + 1)).then(response => {
        userList.value = response.data
        page.value++;
      })
    }
    const is_addUserList = () => {
      if (maxPage.value == page.value) {
        is_showMore.value = false;
        text.value = "No More";
      } else {
        addUserList()
      }
    }
    onMounted(() => {
      getUserList(),
        getMaxPage()
    })
    return {
      userList,
      moreButton,
      is_showMore,
      text,
      is_addUserList
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

.followButton {
  position: absolute;
  left: 90%;
  top: 50%;
  transform: translate(-50%, -50%);
}

li:hover {
  background-color: rgba(245, 245, 245, 0.8) !important;
}

.showMoreButton {
  margin-top: 30px;
}

button {
  cursor: default;
  padding: 4px 12px;
  border-radius: 3px;
  font-size: 14px;
  color: #333;
  border: none;
  background-color: #f8f9fa;
}

.is_showMore {
  cursor: pointer;
  background-color: #0d6efd;
  border: 1px #0d6efd solid;
  color: #fff;
  transition: all .3s;
}

.is_showMore:hover {
  opacity: .85;
  color: #fff;
}
</style>

