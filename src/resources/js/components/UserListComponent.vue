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
              <FollowButton :id="user.id" :isFollow="followIdsData.includes(user.id)"></FollowButton>
            </div>
          </li>
          <div class="mt-4 mb-5 d-flex justify-content-center">
            <button :class="[is_showMore ? 'is_showMore' : '', is_loading ? 'is_loading' : '']" @click="getData">{{ text
            }}</button>
          </div>
        </ul>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import { onMounted, ref } from 'vue';
import FollowButton from './FollowButtonComponent.vue';
export default {
  components: {
    FollowButton
  },
  setup() {
    const userList = ref([]);
    const is_showMore = ref(true);
    const page = ref(0);
    const text = ref("Show More");
    const is_loading = ref(true);
    const followIdsData = ref([]);

    const getData = async () => {
      is_loading.value = true;
      const getData = await axios.get(`/api/index?page=${++page.value}`);
      if (getData.data.users.last_page >= page.value) {
        for (const element of getData.data.users.data) {
          userList.value.push(element);
        }
        is_loading.value = false;
      };
      if (getData.data.users.last_page < (page.value + 1)) {
        is_loading.value = true;
        is_showMore.value = false;
        text.value = "No More";
      }
    }
    async function getFollowIds() {
      const followIds = await axios.get(`/api/followIds`);
      followIdsData.value = followIds.data;
      getData();
    }
    onMounted(() => {
      getFollowIds()
    })
    return {
      userList,
      is_showMore,
      text,
      is_loading,
      followIdsData,
      getData
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

.is_loading {
  pointer-events: none;
}

.is_showMore:hover {
  opacity: .85;
  color: #fff;
}
</style>
