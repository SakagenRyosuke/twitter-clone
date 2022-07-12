<template>
  <div class="container col-md-12">
    <div class="card mt-5 mb-2">
      <Tweet v-if="tweet" :tweet="tweet.tweet" :isFavorite="tweet.isFavorite === 1 ? true : false"
        :isRetweet="tweet.isRetweet === 1 ? true : false" :isLoginUser="authId === tweet.tweet.userId ? 1 : 0"></Tweet>
    </div>
    <div class="container col-md-12" v-show="comments">
      <ul class="ps-0">
        <li class="card" v-for="comment in comments">
          <div>
            <div class="card-haeder p-3">
              <div class="ms-5">
                <div class="d-flex">
                  <p>{{ comment.screenName }}</p>
                  <span class="ms-2">{{ comment.name }}</span>
                </div>
                <div class="tweet-text">
                  <p>{{ comment.text }}</p>
                  <span>{{ comment.created_at }}</span>
                </div>
              </div>
            </div>
            <div class="profileImage">
              <router-link :to="'/home/user-profile/' + comment.userId">
                <img class="rounded-circle" width="50" height="50" :src="comment.profileImage" alt="">
              </router-link>
            </div>
          </div>
        </li>
      </ul>
    </div>
  </div>
</template>
<script>
import { onMounted, ref } from 'vue';
import Tweet from './TweetComponent.vue';

export default {
  props: {
    id: String
  },
  components: {
    Tweet
  },
  setup(props) {
    const page = ref(0);
    const comments = ref([]);
    const is_loading = ref(false);
    const tweet = ref();
    const authId = ref();
    const getData = async () => {
      is_loading.value = true;
      const getTweet = axios.get(`/api/tweet/${props.id}`);
      const getComments = axios.get(`/api/comments/${props.id}?page=${++page.value}`);
      const getAuthId = axios.get('/api/authId');

      const tweetData = await getTweet;
      tweet.value = tweetData.data;

      const commentsData = await getComments;
      if (commentsData.data.last_page >= page.value) {
        for (const element of commentsData.data.data) {
          comments.value.push(element);
        }
      };

      const authIdData = await getAuthId;
      authId.value = authIdData.data;
      is_loading.value = false;
    }
    async function addData() {
      is_loading.value = true;
      const getComments = axios.get(`/api/comments/${props.id}?page=${++page.value}`);
      const commentsData = await getComments;
      if (commentsData.data.last_page >= page.value) {
        for (const element of commentsData.data.data) {
          comments.value.push(element);
        }
        is_loading.value = false;
      };
    }
    onMounted(() => {
      getData()
      window.addEventListener('scroll', () => {
        if (document.body.clientHeight - window.innerHeight - window.pageYOffset < 400
          && is_loading.value === false) {
          addData()
        }
      })
    })
    return {
      tweet,
      comments,
      authId
    }
  },
};
</script>
<style scoped>
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
  white-space: pre-wrap;
}

img {
  object-fit: cover;
}

.buttons {
  width: 100%;
  display: flex;
}

.buttons button {
  height: 20px;
  width: 20px;
  border: none;
  background-color: rgba(255, 255, 255, 0);
  color: #7fffd4;
  cursor: pointer;
}

.buttons div {
  width: 20px;
  height: 20px;
  margin-right: 25px;
}

.buttons img {
  filter: invert(12%) sepia(1%) saturate(3052%) hue-rotate(336deg) brightness(99%) contrast(79%);
  object-fit: contain;
  width: 20px;
  height: 20px;
  opacity: .8;
}
</style>
