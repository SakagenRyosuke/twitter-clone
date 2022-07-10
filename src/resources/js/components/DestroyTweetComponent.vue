<template>
  <div class="wrapper">
    <button class="tweet" :class="is_loading ? 'is_loading' : ''" @click="destroyTweet">
      <img src="/images/trash.svg" alt="create tweet icon">
    </button>
  </div>
</template>
<script>
import axios from 'axios';
import { ref } from 'vue';
import { useRouter } from 'vue-router';

export default {
  props: {
    'tweetId': Number
  },
  setup(props) {
    const is_loading = ref(false);
    const router = useRouter();

    const destroyTweet = async () => {
      if(confirm("Do you want to delete this tweet?")) {
        is_loading.value = true;
        await axios.post(`/api/destroyTweet/${props.tweetId}`);
        is_loading.value = false;
        router.push({ path: '/home'});
      }
    }
    return {
      is_loading,
      destroyTweet
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
  color: #fff;
}

.is_loading {
  pointer-events: none;
}
</style>
