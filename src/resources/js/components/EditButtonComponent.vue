<template>
  <div class="wrapper">
    <button class="edit" :class="is_loading ? 'is_loading' : ''" @click="open">Edit</button>
    <div class="content" :class="is_show ? '' : 'close'" v-show="is_show">
      <form action="" encType="multipart/form-data" @submit="fileUpload">
        <div class="form-header d-flex">
          <button class="form-header_button" disabled><img src="/images/xmark.svg" alt="xmark icon"
              @click="close"></button>
          <h2 class="ms-3">Edit Profile</h2>
          <button id="store" class="ms-auto btn btn-primary form-header_store" type="submit">store</button>
        </div>
        <div class="image">
          <img v-if="authUserData" :src="url === '' ? authUserData.profileImage : url" alt="">
          <label class="image_label">
            <span></span>
            <img class="image_icon" src="/images/editPhotoIcon.svg" alt="edit photo icon" />
            <input class="image_input" type="file" name="profileImage" id="file"
              accept="image/png, image/jpeg, image/webp" @change="uploadFile">
          </label>
        </div>
        <div class="screenName">
          <h3>Screen Name</h3>
          <input type="text" name="screenName" v-if="authUserData" :value="authUserData.screenName" maxlength="20"
            required>
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
    const url = ref("");
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
    const uploadFile = (e) => {
      const file = e.target.files[0];
      if (typeof file != "undefined") {
        if (file.size > 1024 * 1024 * 1) {
          alert("ファイルサイズを1MB以下にしてください")
        } else {
          url.value = URL.createObjectURL(file);
        }
      }
    }
    const fileUpload = async (e) => {
      is_loading.value = true;
      close();
      e.preventDefault();
      let userData = new FormData();
      const profileImage = e.target.profileImage.files[0];
      const screenName = e.target.screenName.value;

      // 画像が選択されてない時は追加しない
      if (profileImage) {
        userData.append("profileImage", profileImage);
      }
      userData.append("screenName", screenName);
      await axios.post('/api/editUser', userData);
      location.reload();
    }
    onMounted(() => {
      getData()
    })
    return {
      authUserData,
      is_show,
      is_loading,
      url,
      open,
      close,
      uploadFile,
      fileUpload
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
}

.content form {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  width: 80%;
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
  object-fit: cover;
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

.no_scroll {
  overflow: hidden;
}
</style>
