<template>
  <div class="wrapper">
    <button :class="[is_follow ? 'is_follow' : '',is_loading ? 'is_loading': '']" @click="doFollow">{{ text }}</button>
    <!-- -->
  </div>
</template>
<script>
import { onMounted, ref } from 'vue';
export default {
  props: {
    id: Number
  },
  setup(props) {
    const followList = ref()
    const is_follow = ref(false)
    const text = ref("Follow")
    const is_loading = ref(true);
    const isFollow = async () => {
      // ログインユーザーのフォローリストを取得してpropsで受け取ったIDが入っているかでフォロースタイルにする
      const isFollow = await axios.get('/api/users/followList/' + props.id);
      if (isFollow.data === 1) {
        is_follow.value = true;
        text.value = "Following";
      }
      is_loading.value = false;
    }
    async function follow() {
      try {
        await axios.post('/api/users/' + props.id + '/follow');
      } catch (error) {
        alert("エラーが発生しました。")
      }
    }
    async function unfollow() {
      try {
        await axios.post('/api/users/' + props.id + '/unfollow');
      } catch (error) {
        alert("エラーが発生しました。")
      }
    }
    const doFollow = () => {
      is_follow.value = !is_follow.value;
      if (is_follow.value === true) {
        text.value = "Following";
        follow()
      } else {
        text.value = "Follow";
        unfollow();
      }
    }
    onMounted(() => {
      isFollow()
    })
    return {
      is_follow,
      text,
      followList,
      is_loading,
      doFollow
    }
  },
};
</script>
<style scoped>
button {
  cursor: pointer;
  padding: 3px 12px;
  border-radius: 15px;
  background-color: #fff;
  border: 1px #333 solid;
  font-size: 12px;
  color: #333;
  transition: all .3s;
}

button:hover {
  border: 1px #0d6efd solid;
  color: #0d6efd;
}

.is_follow {
  background-color: #0d6efd;
  border: 1px #0d6efd solid;
  color: #fff;
}

.is_loading {
  pointer-events: none;
}

.is_follow:hover {
  opacity: .85;
  color: #fff;
}
</style>
