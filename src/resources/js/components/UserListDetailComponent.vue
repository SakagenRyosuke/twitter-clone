<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="container col-md-12">
        <div class="my-3 p-3 bg-body rounded shadow-sm" v-show="user">
          <div class="d-flex mb-3 profile">
            <div class="img me-5">
              <img class="rounded-circle w-100 h-100" v-if="user" :src="user.profileImage" alt="profileImage">
            </div>
            <div class="d-flex align-items-end counts">
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
          <FollowButton v-if="is_follow" v-show="isLoginUser === 0" :id="id" :isFollow="is_follow"></FollowButton>
          <EditButton v-show="isLoginUser === 1"></EditButton>
        </div>
      </div>
      <div class="container col-md-12" v-show="user, tweets">
        <ul class="ps-0">
          <li class="card" v-for="tweet in tweets">
            <Tweet :tweet="tweet" :isLoginUser="isLoginUser" :isFavorite="favoriteIds.includes(tweet.id)" :isRetweet="retweetIds.includes(tweet.id)"></Tweet>
          </li>
        </ul>
      </div>
    </div>
  </div>
</template>
<script>
import { onMounted, ref } from 'vue';
import FollowButton from './FollowButtonComponent.vue';
import EditButton from './EditButtonComponent.vue';
import Tweet from './TweetComponent.vue';
import axios from 'axios';
export default {
  components: {
    FollowButton,
    EditButton,
    Tweet
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
    const is_loading = ref(true);
    const is_follow = ref();
    const page = ref(0);
    const favoriteIds = ref([]);
    const retweetIds = ref([]);

    const getData = async () => {
      const getProfile = axios.get(`/api/userProfile/${props.id}`);
      const getTweet = axios.get(`/api/timeLine/${props.id}?page=${++page.value}`);
      const getTweetStatus = axios.get('/api/tweetStatus');
      const profileData = await getProfile;
      user.value = profileData.data.user;
      isLoginUser.value = profileData.data.isAuthUser;
      followingCount.value = profileData.data.followingCount;
      followedCount.value = profileData.data.followedCount;
      tweetsCount.value = profileData.data.tweetsCount;
      is_follow.value = profileData.data.isFollow === 1 ? true : false;

      const tweetData = await getTweet;
      if (tweetData.data.last_page >= page.value) {
        for (const element of tweetData.data.data) {
          tweets.value.push(element);
        }
        is_loading.value = false;
      }

      const tweetStatus = await getTweetStatus;
      favoriteIds.value = tweetStatus.data.favoriteIds;
      retweetIds.value = tweetStatus.data.retweetIds;
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
    }
    onMounted(() => {
      getData(),
        window.addEventListener('scroll', () => {
          if (document.body.clientHeight - window.innerHeight - window.pageYOffset < 400
            && is_loading.value === false) {
            addData()
          }
        })
    })
    return {
      is_follow,
      user,
      id,
      followedCount,
      followingCount,
      isLoginUser,
      tweets,
      tweetsCount,
      is_loading,
      favoriteIds,
      retweetIds
    }
  },
  watch: {
    $route(to, from) {
      if (from.name === to.name && from.params.id != to.params.id) {
        location.reload();
      }
    }
  }
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

.is_loading {
  pointer-events: none;
}

img {
  object-fit: cover;
}

@media only screen and (max-width:700px) {
  .profile img, .img {
    width: 75px !important;
    height: 75px !important;
  }
  .img {
    margin-right: 10px !important;
  }
  .counts div {
    margin: 5px !important;
    padding: 5px !important;
  }
  .profile h2, .profile p {
    font-size: 14px !important;
  }
}
</style>
