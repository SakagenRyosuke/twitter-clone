<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div>{{ message }}</div>
                <div class="card">
                    <div class="card-header">Example Component</div>

                    <div class="card-body">
                        I'm an example component.
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { onMounted, ref } from "vue";
export default {
    setup() {
        const message = ref("Hello Laravel Vue 3");
        onMounted(() => {
            console.log('Component is mounted!')
        })
        return {
            message
        };
    },
}
</script>
