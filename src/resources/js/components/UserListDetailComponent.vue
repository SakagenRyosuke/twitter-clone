<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="container col-md-12">
        <div class="my-3 p-3 bg-body rounded shadow-sm">
          <div class="d-flex mb-3">
            <div class="img me-5">
              <img class="rounded-circle w-100 h-100" :src="show.profileImage" alt="profileImage">
            </div>
            <div class="d-flex align-items-end">
              <div class="me-3 px-3 text-center">
                <h2 class="fs-4">mada</h2>
                <p>Tweets</p>
              </div>
              <div class="me-3 px-3 text-center">
                <h2 class="fs-4">{{ followingCount }}</h2>
                <p>Following</p>
              </div>
              <div class="me-3 px-3 text-center">
                <h2 class="fs-4">{{ followedCount }}</h2>
                <p>Followed</p>
              </div>
            </div>
          </div>
          <div class="name mb-3">
            <h1 class="p-0 m-0 fs-2 text-center">{{ show.screenName }}</h1>
            <p class="p-0 m-0 text-center">{{ show.name }}</p>
          </div>
          <FollowButton v-show="isLoginUser === 0" :id="id"></FollowButton>
          <EditButton v-show="isLoginUser === 1"></EditButton>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
// import router from 'vue-router'
import { onMounted, ref } from 'vue';
import FollowButton from './FollowButtonComponent.vue';
import EditButton from './EditButtonComponent.vue';
import axios from 'axios';
export default {
  components: {
    FollowButton,
    EditButton
  },
  props: {
    id: String
  },
  setup(props) {
    const show = ref({})
    const isLoginUser = ref(0)
    const id = ref(Number(props.id))
    const followingCount = ref(0)
    const followedCount = ref(0)
    const selectButton = () => {
      axios.get('/isLoginUser/' + props.id).then(response => isLoginUser.value = response.data)
    }
    const getUserList = () => {
      axios.get('/userProfile/' + props.id).then(response => show.value = response.data)
    }
    const getFollowingCount = () => {
      axios.get('/userProfile/' + props.id + '/followingCount').then(response => followingCount.value = response.data)
    }
    const getFollowedCount = () => {
      axios.get('/userProfile/' + props.id + '/followedCount').then(response => followedCount.value = response.data)
    }
    onMounted(() => {
      selectButton(),
      getUserList(),
      getFollowingCount(),
      getFollowedCount()
    })
    return {
      show,
      id,
      followedCount,
      followingCount,
      isLoginUser
    }
  },
};
</script>
<style scoped>
.img {
  width: 100px;
  height: 100px;
}
.name {
  width: 100px;
}
</style>
