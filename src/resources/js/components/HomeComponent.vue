<template>
  <div class="container col-md-12 mt-3">
    <ul class="ps-0">
      <li class="card" v-for="tweet in tweets" v-if="userNamesList">
        <Tweet :tweet="tweet" :isLoginUser="authId === tweet.userId ? 1 : 0"
          :userName="userNamesList[tweet.timelineUserId]" :isFavorite="favoriteIds.includes(tweet.id)"
          :isRetweet="retweetIds.includes(tweet.id)" @emitFavorite="emitFavorite" @emitRetweet="emitRetweet"></Tweet>
      </li>
    </ul>
  </div>
</template>
<script>
import { onMounted, ref } from 'vue';
import Tweet from './TweetComponent.vue';
import axios from 'axios';

export default {
  components: {
    Tweet
  },
  setup() {
    const tweets = ref([])
    const is_loading = ref(true)
    const page = ref(0)
    const favoriteIds = ref([])
    const retweetIds = ref([])
    const authId = ref()
    const userNamesList = ref();

    const getData = async () => {
      const getTweet = axios.get(`/api/timelines?page=${++page.value}`);
      const getTweetStatus = axios.get('/api/tweetStatus');
      const getAuthId = axios.get('/api/authId');
      const userNames = axios.get('/api/timelines/userNames');

      const tweetData = await getTweet;
      if (tweetData.data.last_page >= page.value) {
        for (const element of tweetData.data.data) {
          tweets.value.push(element);
        }
      }

      const userNamesData = await userNames;
      userNamesList.value = userNamesData.data;

      const tweetStatus = await getTweetStatus;
      favoriteIds.value = tweetStatus.data.favoriteIds;
      retweetIds.value = tweetStatus.data.retweetIds;

      const authIdData = await getAuthId;
      authId.value = authIdData.data;
      is_loading.value = false;
    }
    async function addData() {
      is_loading.value = true;
      const getTweet = axios.get(`/api/timelines?page=${++page.value}`);
      const tweetData = await getTweet;
      if (tweetData.data.last_page >= page.value) {
        for (const element of tweetData.data.data) {
          tweets.value.push(element);
        }
        is_loading.value = false;
      }
    }
    const emitFavorite = (bool, tweetId) => {
      if (bool) {
        favoriteIds.value.push(tweetId);
      } else {
        const index = favoriteIds.value.indexOf(tweetId);
        favoriteIds.value.splice(index, 1)
      }
    }
    const emitRetweet = (bool, tweetId) => {
      if (bool) {
        retweetIds.value.push(tweetId);
      } else {
        const index = retweetIds.value.indexOf(tweetId);
        retweetIds.value.splice(index, 1)
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
      tweets,
      is_loading,
      favoriteIds,
      retweetIds,
      authId,
      userNamesList,
      emitFavorite,
      emitRetweet
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

.is_loading {
  pointer-events: none;
}

img {
  object-fit: cover;
}
</style>
