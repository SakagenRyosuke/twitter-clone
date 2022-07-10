<template>
  <div class="wrapper">
    <button class="tweet" :class="is_loading ? 'is_loading' : ''" @click="open">
      <img src="/images/edit.svg" alt="create tweet icon">
    </button>
    <div class="content" :class="is_show ? '' : 'close'" v-show="is_show">
      <form action="" encType="multipart/form-data" @submit="updateTweet">
        <div class="form-header d-flex">
          <button class="form-header_button" disabled><img src="/images/xmark.svg" alt="xmark icon"
              @click="close"></button>
          <h2 class="ms-3">Update Tweet</h2>
          <button class="ms-auto btn btn-primary form-header_update" type="submit">update</button>
        </div>
        <div class="tweetarea">
          <textarea name="tweet" maxlength="140" required>{{ tweetContent }}</textarea>
        </div>
      </form>
    </div>
  </div>
</template>
<script>
import axios from 'axios';
import { ref } from 'vue';
import { useRouter } from 'vue-router';

function scroll_control(event) {
  event.preventDefault();
}

export default {
  props: {
    'tweetContent': String,
    'tweetId': Number
  },
  setup(props) {
    const is_show = ref(false);
    const is_loading = ref(false);
    const router = useRouter();

    const open = () => {
      is_show.value = true;
      document.addEventListener('touchmove', scroll_control, { passive: false });
      document.addEventListener('mousewheel', scroll_control, { passive: false });
    }
    const close = () => {
      is_show.value = false;
      document.removeEventListener('touchmove', scroll_control, { passive: false });
      document.removeEventListener('mousewheel', scroll_control, { passive: false });
    }
    const updateTweet = async (e) => {
      is_loading.value = true;
      close();
      e.preventDefault();
      let tweetData = new FormData();
      const tweet = e.target.tweet.value;
      tweetData.append("tweet", tweet);
      await axios.post(`/api/updateTweet/${props.tweetId}`, tweetData);
      e.target.tweet.value = "";
      is_loading.value = false;
      router.push({ path: '/home'});
    }
    return {
      is_show,
      is_loading,
      open,
      close,
      updateTweet
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

.content {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.3);
  z-index: 2000;
  overflow-y: scroll;
}

.content form {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  width: 100%;
  max-width: 600px;
  height: 400px;
  background-color: #fff;
  border-radius: 30px;
}

.form-header {
  padding: 20px;
}

.form-header h2 {
  line-height: 50px;
  margin-bottom: 0;
}

.form-header_button {
  border: none;
  background-color: #fff;
}

.form-header_button img {
  width: 30px;
  height: 30px;
  cursor: pointer;
}

.form-header_update {
  height: 30px;
  margin: 10px;
  font-size: 14px;
  border-radius: 15px;
  line-height: 2px;
}

.tweetarea {
  position: absolute;
  width: 75%;
  height: 60%;
  left: 50%;
  top: 55%;
  font-size: 17px;
  transform: translate(-50%, -50%);
}

.tweetarea textarea {
  width: 100%;
  height: 100%;
  border-radius: 30px;
  padding: 30px;
  border: solid #eee 1px;
}

.is_loading {
  pointer-events: none;
}
</style>
