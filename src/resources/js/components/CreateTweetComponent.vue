<template>
  <div class="wrapper">
    <button class="tweet" :class="is_loading ? 'is_loading' : ''" @click="open">
      <img src="/images/createTweet.svg" alt="create tweet icon">
    </button>
    <div class="content" :class="is_show ? '' : 'close'" v-show="is_show">
      <form action="" encType="multipart/form-data" @submit="fileUpload">
        <div class="form-header d-flex">
          <button class="form-header_button" disabled><img src="/images/xmark.svg" alt="xmark icon"
              @click="close"></button>
          <h2 class="ms-3">Create Tweet</h2>
          <button id="store" class="ms-auto btn btn-primary form-header_store" type="submit">tweet</button>
        </div>
        <div class="tweetarea">
          <textarea name="tweet" maxlength="140" required></textarea>
        </div>
      </form>
    </div>
  </div>
</template>
<script>
import axios from 'axios';
import { onMounted, ref } from 'vue';
import { useRouter } from 'vue-router';

function scroll_control(event) {
  event.preventDefault();
}

export default {
  setup() {
    const authUserData = ref();
    const is_show = ref(false);
    const is_loading = ref(true);
    const router = useRouter();

    const getData = async () => {
      is_loading.value = true;
      const getData = await axios.get('/api/loginUser');
      authUserData.value = getData.data;
      is_loading.value = false;
    }
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
    const fileUpload = async (e) => {
      is_loading.value = true;
      close();
      e.preventDefault();
      let tweetData = new FormData();
      const tweet = e.target.tweet.value;
      tweetData.append("tweet", tweet);
      await axios.post('/api/createTweet', tweetData);
      e.target.tweet.value = "";
      is_loading.value = false;
      router.push({ path: '/home'});
    }
    onMounted(() => {
      getData()
    })
    return {
      authUserData,
      is_show,
      is_loading,
      open,
      close,
      fileUpload
    }
  }
};
</script>
<style scoped>
.tweet {
  cursor: pointer;
  transition: all .3s;
  position: fixed;
  width: 50px;
  height: 50px;
  left: 90%;
  top: 90%;
  transform: translate(-100%, -100%);
  background-color: #fff;
  border: none;
  border-radius: 50%;
}

.tweet img {
  filter: invert(27%) sepia(92%) saturate(3206%) hue-rotate(211deg) brightness(101%) contrast(98%);
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

.form-header_store {
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

.screenName input {
  width: 100%;
  height: 30px;
  border-radius: 15px;
  border: solid #333 1px;
  padding-left: 10px;
}

.is_loading {
  pointer-events: none;
}
</style>
