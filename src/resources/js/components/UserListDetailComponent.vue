<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="container col-md-12">
        <div class="my-3 py-3 bg-body rounded shadow-sm">
          <div class="d-flex">
            <div class="img">
              <img :src="show.profileImage" alt="">
            </div>
            <div class="d-flex">
              <div>
                <h2>mada</h2>
                <p>Tweets</p>
              </div>
              <div>
                <h2>{{ numFollowing }}</h2>
                <p>Following</p>
              </div>
              <div>
                <h2>{{ numFollowed }}</h2>
                <p>Followed</p>
              </div>
            </div>
          </div>
          <div>
            <h1>{{ show.screenName }}</h1>
            <p>{{ show.name }}</p>
          </div>
          <FollowButton :id="id"></FollowButton>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { onMounted, ref } from 'vue';
import FollowButton from './FollowButtonComponent.vue';
export default {
  components: {
    FollowButton
  },
  props: {
    id: String
  },
  setup(props) {
    const show = ref("")
    const id = ref(props.id)
    const numFollowing = ref(0)
    const numFollowed = ref(0)
    const getUserList = () => {
      axios.get('/userProfile/' + props.id).then(response => show.value = response.data)
    }
    const getFollowing = () => {
      axios.get('/userProfile/' + props.id + '/following').then(response => numFollowing.value = response.data)
    }
    const getFollowed = () => {
      axios.get('/userProfile/' + props.id + '/followed').then(response => numFollowed.value = response.data)
    }
    onMounted(() => {
      getUserList(),
      getFollowing(),
      getFollowed()
    })
    return {
      show,
      id,
      numFollowed,
      numFollowing
    }
  },
};
</script>
<style scoped>
.img {
  border-radius: 50%;
  width: 50px;
  height: 50px;
}

img {
  border-radius: 50%;
  width: 100%;
  height: 100%;
}

h2 {
  font-size: 17px;
}

h1 {
  font-size: 20px;
}
</style>
