<template>
  <div>
    <router-link :to="'/home/tweet/detail/' + tweet.id">
      <div class="card-haeder p-3">
        <div class="ms-5">
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
      <div>
        <button disabled>
          <img v-if="is_favo" :class="is_favo ? 'is_favo' : ''" src="/images/heart.svg" alt="heart">
        </button>
      </div>
      <div>
        <button disabled>
          <img v-if="is_retweet" :class="is_retweet ? 'is_retweet' : ''" src="/images/retweet.svg" alt="retweet">
        </button>
      </div>
      <div>
        <button disabled>
          <img src="/images/comment.svg" alt="comment">
        </button>
      </div>
      <UpdateTweet v-if="tweet" v-show="isLoginUser === 1" :tweetId="tweet.id" :tweetContent="tweet.text"></UpdateTweet>
      <DestroyTweet v-if="tweet" v-show="isLoginUser === 1" :tweetId="tweet.id"></DestroyTweet>
    </div>
  </div>
</template>
<script>
import { ref } from 'vue';
import UpdateTweet from './UpdateTweetComponent.vue';
import DestroyTweet from './DestroyTweetComponent.vue';
export default {
  props: {
    'tweet': Object,
    'isLoginUser': Number
  },
  components: {
    UpdateTweet,
    DestroyTweet
  },
  setup() {
    const is_favo = ref(true);
    const is_retweet = ref(true);
    return {
      is_favo,
      is_retweet
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

.buttons div  {
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

.buttons .is_favo {
  filter: invert(15%) sepia(88%) saturate(7495%) hue-rotate(359deg) brightness(109%) contrast(108%);
  opacity: 1;
}

.buttons .is_retweet {
  filter: invert(76%) sepia(67%) saturate(262%) hue-rotate(101deg) brightness(103%) contrast(102%);
  opacity: 1;
}
</style>
