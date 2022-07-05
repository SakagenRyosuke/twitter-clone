<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="container col-md-12">
        <div class="my-3 p-3 bg-body rounded shadow-sm" v-show="user">
          <div class="d-flex mb-3">
            <div class="img me-5">
              <img class="rounded-circle w-100 h-100" v-if="user" :src="user.profileImage" alt="profileImage">
            </div>
            <div class="d-flex align-items-end">
              <div class="me-3 px-3 text-center">
                <h2 class="fs-4" v-if="user">{{ tweetsCount }}</h2>
                <p>Tweets</p>
              </div>
              <div class="me-3 px-3 text-center">
                <h2 class="fs-4" v-if="user">{{ followingCount }}</h2>
                <p>Following</p>
              </div>
              <div class="me-3 px-3 text-center">
                <h2 class="fs-4" v-if="user">{{ followedCount }}</h2>
                <p>Followed</p>
              </div>
            </div>
          </div>
          <div class="name mb-3">
            <h1 class="p-0 m-0 fs-2 text-center" v-if="user">{{ user.screenName }}</h1>
            <p class="p-0 m-0 text-center" v-if="user">{{ user.name }}</p>
          </div>
          <FollowButton v-show="isLoginUser === 0" :id="id"></FollowButton>
          <EditButton v-show="isLoginUser === 1"></EditButton>
        </div>
      </div>
      <div class="container col-md-12" v-show="user, tweets">
        <ul class="ps-0">
          <li class="card" v-for="tweet in tweets">
            <router-link :to="'/tweet/detail/' + tweet.id">
              <div class="card-haeder p-3">
                <div class="ms-5">
                  <div class="d-flex">
                    <p v-if="user">{{ user.screenName }}</p>
                    <span class="ms-2" v-if="user">{{ user.name }}</span>
                  </div>
                  <div class="tweet-text" v-if="tweets">
                    <p>{{ tweet.text }}</p>
                    <span>{{ tweet.created_at }}</span>
                  </div>
                </div>
              </div>
            </router-link>
            <div class="profileImage">
              <router-link :to="'/home/user-profile/' + id">
                <img class="rounded-circle" width="50" height="50" v-if="user" :src="user.profileImage" alt="">
              </router-link>
            </div>
          </li>
          <div class="mt-4 mb-5 d-flex justify-content-center">
            <button :class="[is_showMore ? 'is_showMore' : '', is_loading ? 'is_loading' : '']" @click="addData">{{ text
            }}</button>
          </div>
        </ul>
      </div>
    </div>
  </div>
</template>
<script>
import { onMounted, ref, watch } from 'vue';
import FollowButton from './FollowButtonComponent.vue';
import EditButton from './EditButtonComponent.vue';
import axios from 'axios';
export default {
  components: {
    FollowButton,
    EditButton
  },
  props: {
    id: String
  },
  setup(props) {
    const user = ref()
    const isLoginUser = ref(0)
    const id = ref(Number(props.id))
    const followingCount = ref(0)
    const followedCount = ref(0)
    const tweetsCount = ref(0)
    const tweets = ref([])
    const is_showMore = ref(true);
    const is_loading = ref(true);
    const page = ref(0);
    const text = ref("Show More");

    const getData = async () => {
      const getProfile = axios.get(`/api/userProfile/${props.id}`);
      const getTweet = axios.get(`/api/timeLine/${props.id}?page=${++page.value}`);
      const profileData = await getProfile;
      user.value = profileData.data.user;
      isLoginUser.value = profileData.data.isAuthUser;
      followingCount.value = profileData.data.followingCount;
      followedCount.value = profileData.data.followedCount;
      tweetsCount.value = profileData.data.tweetsCount;

      const tweetData = await getTweet;
      if (tweetData.data.last_page >= page.value) {
        for (const element of tweetData.data.data) {
          tweets.value.push(element);
        }
        is_loading.value = false;
        if (tweetData.data.last_page < (page.value + 1)) {
          is_loading.value = true;
          is_showMore.value = false;
          text.value = "No More";
        }
      } else {
        is_showMore.value = false;
        text.value = "No Tweet";
      }
    }
    async function addData() {
      is_loading.value = true;
      const getTweet = axios.get(`/api/timeLine/${props.id}?page=${++page.value}`);
      const tweetData = await getTweet;
      if (tweetData.data.last_page >= page.value) {
        for (const element of tweetData.data.data) {
          tweets.value.push(element);
        }
        is_loading.value = false;
      } 
      if(tweetData.data.last_page < (page.value + 1)){
        is_loading.value = true;
        is_showMore.value = false;
        text.value = "No More";
      }
    }
    onMounted(() => {
      getData()
    })
    return {
      user,
      id,
      followedCount,
      followingCount,
      isLoginUser,
      tweets,
      is_showMore,
      text,
      tweetsCount,
      is_loading,
      addData
    }
  },
};
</script>
<style scoped>
.img {
  width: 100px;
  height: 100px;
}

.name {
  width: 100px;
}

li {
  list-style: none;
  transition: all .3s;
  position: relative;
}

li:hover {
  background-color: rgba(245, 245, 245, 0.8) !important;
}

.showMoreButton {
  margin-top: 30px;
}

button {
  cursor: default;
  padding: 5px 12px;
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

.is_loading {
  pointer-events: none;
}

a {
  text-decoration: none;
}

p,
span {
  color: #333;
}

span {
  opacity: .8;
}

.profileImage {
  position: absolute;
  top: 10px;
  left: 10px;
  cursor: pointer;
}

.tweet-text {
  color: #333;
}
</style>
