<template>
  <div class="wrapper">
    <button class="tweet" @click="execEmit">
      <img :class="[props.isRetweet ? 'is_retweet' : '']" src="/images/retweet.svg" alt="create tweet icon">
    </button>
  </div>
</template>
<script>
import { ref, onMounted } from 'vue';
import axios from 'axios';

export default {
  props: {
    'isRetweet': Boolean,
    'tweetId': Number
  },
  setup(props, context) {
    const is_loading = ref(true)
    const is_retweet = ref(props.isRetweet)

    async function retweet() {
      try {
        await axios.post('/api/tweets/' + props.tweetId + '/retweet');
      } catch (error) {
        alert("エラーが発生しました。")
      }
    }
    async function unretweet() {
      try {
        await axios.post('/api/tweets/' + props.tweetId + '/unretweet');
      } catch (error) {
        alert("エラーが発生しました。")
      }
    }
    const doRetweet = () => {
      props.isRetweet ? unretweet() : retweet();
    }
    const execEmit = () => {
      doRetweet();
      context.emit('emitRetweet', !props.isRetweet);
    }
    return {
      is_loading,
      is_retweet,
      execEmit,
      props
    }
  }
};
</script>
<style scoped>
.tweet {
  height: 20px;
  width: 20px;
  border: none;
  background-color: rgba(255, 255, 255, 0);
  color: #7fffd4;
  cursor: pointer;
}

.tweet img {
  filter: invert(12%) sepia(1%) saturate(3052%) hue-rotate(336deg) brightness(99%) contrast(79%);
  object-fit: contain;
  width: 20px;
  height: 20px;
  opacity: .8;
}

.tweet:hover {
  opacity: .85;
}

.tweet .is_retweet {
  filter: invert(76%) sepia(67%) saturate(262%) hue-rotate(101deg) brightness(103%) contrast(102%);
  opacity: 1;
}

.is_loading {
  pointer-events: none;
}
</style>
