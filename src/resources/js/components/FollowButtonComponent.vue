<template>
  <div class="wrapper">
    <button :class="[props.isFollow ? 'is_follow' : '']" @click="execEmit">{{ props.isFollow
        ? "Following" : "Follow"
    }}</button>
  </div>
</template>
<script>
export default {
  props: {
    id: Number,
    isFollow: Boolean
  },
  setup(props, context) {
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
      props.isFollow ? unfollow() : follow();
    }
    const execEmit = () => {
      doFollow();
      context.emit('emitFollow', !props.isFollow, props.id);
    }
    return {
      doFollow,
      execEmit,
      props
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
