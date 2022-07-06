<template>
  <div class="wrapper">
    <button class="edit" :class="is_loading ? 'is_loading':''" @click="open">Edit</button>
    <div class="content" :class="is_show ? '':'close'" v-show="is_show">
      <form action="">
        <div class="form-header d-flex">
          <button class="form-header_button" disabled><img src="/images/xmark.svg" alt="xmark icon" @click="close"></button>
          <h2 class="ms-3">Edit Profile</h2>
          <input class="ms-auto btn btn-primary form-header_store" type="submit" name="submit" value="store">
        </div>
        <div class="image">
          <img v-if="authUserData" :src="authUserData.profileImage" alt="">
          <label class="image_label">
            <span></span>
            <img class="image_icon" src="/images/editPhotoIcon.svg" alt="edit photo icon" />
            <input class="image_input" type="file" name="profileImage" id="file" accept="image/png, image/jpeg">
          </label>
        </div>
        <div class="screenName">
          <h3>Screen Name</h3>
          <input type="text" name="screenName" v-if="authUserData" :value="authUserData.screenName">
        </div>
      </form>
    </div>
  </div>
</template>
<script>
import axios from 'axios';
import { onMounted, ref } from 'vue';
export default {
  setup() {
    const authUserData = ref();
    const is_show = ref(false);
    const is_loading = ref(true);

    const getData = async () => {
      is_loading.value = true;
      const getData = await axios.get('/api/loginUser');
      authUserData.value = getData.data;
      is_loading.value = false;
    }
    const open = () => {
      is_show.value = true;
    }
    const close = () => {
      is_show.value = false;
    }
    onMounted(() => {
      getData()
    })
    return {
      authUserData,
      is_show,
      is_loading,
      open,
      close
    }
  }
};
</script>
<style scoped>
.edit {
  cursor: pointer;
  padding: 3px 12px;
  border-radius: 15px;
  font-size: 12px;
  transition: all .3s;
  background-color: #0d6efd;
  border: 1px #0d6efd solid;
  color: #fff;
}

.edit:hover {
  border: 1px #0d6efd solid;
  color: #0d6efd;
}

.edit:hover {
  opacity: .85;
  color: #fff;
}

.content {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.3);
  z-index: 2000;
  transition: all .3s;
  opacity: 1;
}

.close {
  opacity: 0;
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

.image {
  width: 100px;
  height: 100px;
  top: 10px;
  left: 20px;
  position: relative;
  border-radius: 50%;
}

.image>img,
.image label {
  width: 100px;
  height: 100px;
  position: absolute;
  z-index: 2001;
  border-radius: 50%;
}

.image label {
  z-index: 2002;
  cursor: pointer;
}


.image span {
  position: absolute;
  display: block;
  width: 35px;
  height: 35px;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  z-index: 2003;
  background-color: rgba(0, 0, 0, 0.4);
  border-radius: 50%;
  transition: all .3s;
}

.image_icon {
  position: absolute;
  width: 20px;
  height: 20px;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  z-index: 2004;
}

.image label:hover span {
  width: 100px;
  height: 100px;
}

.image input {
  display: none;
}

.screenName {
  position: absolute;
  left: 20px;
  bottom: 100px;
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
