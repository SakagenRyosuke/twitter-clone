<template>
  <div class="wrapper">
    <button :class="[is_follow ? 'is_follow' : '']" @click="doFollow">{{ text }}</button>
    <!-- -->
  </div>
</template>
<script>
import { onMounted, ref } from 'vue';
export default {
  props: {
    id: null
  },
  setup(props) {
    const followList = ref("")
    const is_follow = ref(false)
    const text = ref("Follow")
    const isFollow = () => {
      // ログインユーザーのフォローリストを取得してpropsで受け取ったIDが入っているかどうかでフォローしているか
      axios.get('/users/followList').then(response => {
        response.data.forEach(object => {
          if (object.followedId == props.id) {
            is_follow.value = true;
            text.value = "Following";
          }
        })
      });
    }
    function follow() {
      axios.post('/users/' + props.id + '/follow');
    }
    function unfollow() {
      axios.post('/users/' + props.id + '/unfollow');
    }
    const doFollow = () => {
      is_follow.value = !is_follow.value;
      text.value = is_follow.value === true ? "Following" : "Follow";
      is_follow.value === true ? follow() : unfollow();
    }
    onMounted(() => {
      isFollow()
    })
    return {
      is_follow,
      text,
      followList,
      doFollow
    }
  },
};
</script>
<style scoped>
button {
  cursor: pointer;
  padding: 2px 10px;
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

.is_follow:hover {
  opacity: .85;
  color: #fff;
}
</style>
