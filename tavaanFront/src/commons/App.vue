<template>
  <component :is="layout" >
    <router-view/>
  </component>
</template>

<script setup>
import { computed, ref, onMounted } from 'vue'
import { useRoute } from 'vue-router'

const route = useRoute()
;
const layout = computed(() => {
  return route.meta.layout ? route.meta.layout : 'default-layout';
});

const showLoader = ref(true)
onMounted(() => {
  setTimeout(() => {
    showLoader.value = false
  }, 3000);
})


</script>
