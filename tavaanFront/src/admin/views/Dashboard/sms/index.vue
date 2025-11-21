<template>
  <div class="container mt-5 p-4 bg-white rounded shadow-sm">
    <h4 class="mb-4 text-center font-semibold">مدیریت شماره تماس‌ها</h4>
    <!-- افزودن شماره -->
    <div class="input-group mb-3 flex gap-2">
      <input
        v-model="newPhone"
        type="text"
        placeholder="شماره تلفن را وارد کنید"
        class="form-control border rounded p-2"
      />

      <button class="btn btn-primary px-4" @click="addPhone">
        افزودن
      </button>
    </div>
    <!-- لیست شماره‌ها -->
    <table class="table table-striped-columns">
     <thead>
         <tr>
            <th>شماره موبایل</th>
            <th>عملیات</th>

         </tr>
     </thead>
      <tbody>
         <tr v-for="(item, index) in list" :key="item.id">
             <td>{{item.mobile}}</td>
             <td class="text-center">
                 <button class="btn btn-danger btn-sm " @click="removePhone(item.id)">
          حذف
             </button>
             </td>
         </tr>

      </tbody>
    </table>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";
import {$ref} from "unplugin-vue-macros/macros";

const newPhone = ref("");
const mobile = ref([]);
let  list = $ref();

// 1) گرفتن لیست از دیتابیس
async function loadPhones() {
  const res = await axios.get('configs');
   list = res.data.data;
}

// 2) افزودن شماره
async function addPhone() {
  if (!newPhone.value) return;

  await axios.post('configs', {
    mobile: newPhone.value,
  });

  newPhone.value = "";
  loadPhones(); // رفرش لیست
}

// 3) حذف شماره
async function removePhone(id) {
  await axios.delete(`configs/${id}`);
  loadPhones();
}

// هنگام لود صفحه
onMounted(() => {
  loadPhones();
});
</script>
