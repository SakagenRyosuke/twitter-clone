<template>
  <div>
    <router-link :to="'/home/tweet/detail/' + tweet.id">
      <div class="card-haeder p-3">
        <div class="ms-5">
          <div v-show="tweet.state != '0'">
            <span v-show="tweet.state === tweetStatus.favorite">{{ userName }}がいいねしました</span>
            <span v-show="tweet.state === tweetStatus.retweet">{{ userName }}がリツイートしました</span>
          </div>
          <div class="d-flex">
            <p>{{ tweet.screenName }}</p>
            <span class="ms-2">{{ tweet.name }}</span>
          </div>
          <div class="tweet-text">
            <p>{{ tweet.text }}</p>
            <span>{{ tweet.created_at }}</span>
          </div>
        </div>
      </div>
    </router-link>
    <div class="profileImage">
      <router-link :to="'/home/user-profile/' + tweet.userId">
        <img class="rounded-circle" width="50" height="50" :src="tweet.profileImage" alt="">
      </router-link>
    </div>
    <div class="ms-5 buttons mb-4">
      <Favorite v-if="tweet" :isFavorite="props.isFavorite" :tweetId="tweet.id" @emitFavorite="emitFavorite"></Favorite>
      <Retweet v-if="tweet" :isRetweet="isRetweet" :tweetId="tweet.id" @emitRetweet="emitRetweet"></Retweet>
      <Comment v-if="tweet" :tweetId="tweet.id"></Comment>
      <UpdateTweet v-if="tweet" v-show="isLoginUser === 1" :tweetId="tweet.id" :tweetContent="tweet.text"></UpdateTweet>
      <DestroyTweet v-if="tweet" v-show="isLoginUser === 1" :tweetId="tweet.id"></DestroyTweet>
    </div>
  </div>
</template>
<script>
import { ref, onMounted } from 'vue';
import Favorite from './FavoriteComponent.vue';
import Retweet from './RetweetComponent.vue';
import UpdateTweet from './UpdateTweetComponent.vue';
import DestroyTweet from './DestroyTweetComponent.vue';
import Comment from './CommentComponent.vue';
import TWEET_STATUS from '../consts.js';

export default {
  props: {
    'tweet': Object,
    'isLoginUser': Number,
    'isRetweet': Boolean,
    'isFavorite': Boolean
  },
  components: {
    Favorite,
    Retweet,
    UpdateTweet,
    DestroyTweet,
    Comment
  },
  setup(props, context) {
    const is_favo = ref(true);
    const is_retweet = ref(true);
    const userName = ref();
    const tweetStatus = ref(TWEET_STATUS);

    const getName = async () => {
      if (props.tweet.state != '0' && props.tweet.state != undefined) {
        const nameData = await axios.get(`/api/userName/${props.tweet.timelineUserId}`);
        userName.value = nameData.data.name
      }
    }
    const emitFavorite = (params) => {
      context.emit('emitFavorite', params, props.tweet.id);
    }
    const emitRetweet = (params) => {
      context.emit('emitRetweet', params, props.tweet.id);
    }
    onMounted(() => {
      getName()
    })
    return {
      is_favo,
      is_retweet,
      userName,
      emitFavorite,
      emitRetweet,
      props,
      tweetStatus
    }
  }
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
