<template>
  <div class="wrapper">
    <button class="tweet" @click="execEmit">
      <img :class="[props.isFavorite ? 'is_favorite' : '']" src="/images/heart.svg" alt="create tweet icon">
    </button>
  </div>
</template>
<script>
import { ref } from 'vue';
import axios from 'axios';

export default {
  props: {
    'isFavorite': Boolean,
    'tweetId': Number
  },
  setup(props, context) {
    const is_loading = ref(true)
    const is_favorite = ref()
    async function favorite() {
      try {
        await axios.post('/api/tweets/' + props.tweetId + '/favorite');
      } catch (error) {
        alert("エラーが発生しました。")
      }
    }
    async function unfavorite() {
      try {
        await axios.post('/api/tweets/' + props.tweetId + '/unfavorite');
      } catch (error) {
        alert("エラーが発生しました。")
      }
    }
    const doFavorite = () => {
      props.isFavorite ? unfavorite() : favorite();
    }
    const execEmit = () => {
      doFavorite();
      context.emit('emitFavorite', !props.isFavorite);
    }
    return {
      is_loading,
      is_favorite,
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

.tweet .is_favorite {
  filter: invert(15%) sepia(88%) saturate(7495%) hue-rotate(359deg) brightness(109%) contrast(108%);
  opacity: 1;
}

.is_loading {
  pointer-events: none;
}
</style>
