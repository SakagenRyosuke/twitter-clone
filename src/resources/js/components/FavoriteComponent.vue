<template>
  <div class="wrapper">
    <button class="tweet" @click="doFavorite">
      <img :class="[is_favorite ? 'is_favorite' : '']" src="/images/heart.svg" alt="create tweet icon">
    </button>
  </div>
</template>
<script>
import { ref, onMounted } from 'vue';
import axios from 'axios';

export default {
  props: {
    'isFavorite': Boolean,
    'tweetId': Number
  },
  setup(props) {
    const is_loading = ref(true)
    const is_favorite = ref(props.isFavorite)

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
      is_favorite.value = !is_favorite.value;
      is_favorite.value ? favorite() : unfavorite();
    }
    onMounted(() => {
      // 19行目の時点でpropsが反映されていない。（isFavorite）
      setTimeout(() => { is_favorite.value = props.isFavorite }, 100);
      is_loading.value = false;
    })
    return {
      is_loading,
      is_favorite,
      doFavorite
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
