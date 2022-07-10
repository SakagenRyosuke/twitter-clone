<template>
  <div class="container">
    <h1>tweet{{ id }}</h1>
  </div>
</template>
<script>
import { onMounted, ref } from 'vue';
export default {
  props: {
    id: String
  },
  setup(props) {
    const id = ref(Number(props.id))

    onMounted(() => {
    })
    return {
      id,
    }
  },
};
</script>
