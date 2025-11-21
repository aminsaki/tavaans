<template>
  <div class="container-fluid" >
      <div class="row">
         <div class="col-md-2 position: absolute;">
               <Sidebar/>
         </div>
         <div  class="col-md-10">
           <slot/>
        </div>
      </div>
  </div>
</template>

<script setup>
 import  Sidebar from "@/commons/components/Sidebar/index.vue"

</script>

