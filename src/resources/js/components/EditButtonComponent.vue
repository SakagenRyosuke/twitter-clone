<template>
  <div class="wrapper">
    <!-- <button class="[is_follow ? 'is_follow' : '']" @click="doFollow">{{ text }}</button> -->
    <button class="edit">Edit</button>
  </div>
</template>
<script>
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

.edit {
  background-color: #0d6efd;
  border: 1px #0d6efd solid;
  color: #fff;
}

.edit:hover {
  opacity: .85;
  color: #fff;
}
</style>
