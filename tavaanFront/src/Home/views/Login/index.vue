<template>
  <div class="min-h-screen bg-light d-flex justify-content-center align-items-center">
    <div class="card shadow-lg border-0 rounded-3 p-0 w-100" style="max-width: 420px;">

      <!-- Header -->
      <div class="p-4 text-center border-bottom">
        <h1 class="h4 mb-1 fw-bold">خوش‌آمدید</h1>
        <p class="text-muted mb-0">برای ادامه وارد حساب‌کاربری شوید</p>
      </div>

      <!-- Login Form -->
      <form id="loginForm" class="p-4" novalidate>

        <!-- mobile -->
        <div class="mb-3">
          <label for="email" class="form-label fw-semibold">شماره موبایل</label>
          <input
            type="text"
            id="email"
            name="email"
             v-model="from.mobile"
            class="form-control rounded-md py-2"
            placeholder="09100000000"
            required
          />
        </div>

        <!-- پسورد -->
        <div class="mb-3">
          <label for="password" class="form-label fw-semibold">گذرواژه</label>
          <input
            type="password"
            id="password"
            name="password"
            class="form-control rounded-md py-2"
            placeholder="••••••••"
            minlength="6"
            required
            v-model="from.password"
          />
        </div>

        <!-- Button -->
        <button type="button" @click="btn_login()" class="btn btn-primary form-control btn-danger" :disabled="loading">
              <span v-if="loading">
                     <LoadingSpinner/>
               </span>
                <span v-else>ورود
                </span>
              </button>

      </form>
    </div>
  </div>
</template>

<script setup>


import {myErrors} from "@/commons/helpers/errors.js";
import {toast} from "vue3-toastify";
import LoadingSpinner from "@/commons/components/LoadingSpinner.vue";
import {reactive} from "vue";
import {$ref} from "unplugin-vue-macros/macros";
let loading = $ref(false)
import axios from "axios";
const from = reactive({
    mobile: "",
    password: "",
})
async function btn_login() {
  loading =true;
    try {
        const response = await axios.post('authentications', from);
        const {status, data, messages} = response.data;
        if (status === 'true') {
          loading = false;
            localStorage.setItem('users', JSON.stringify(data.list));
            localStorage.setItem('token', data.access_token);
            toast.success(messages);
            window.location.replace('/home');
        }
    } catch (error) {
      loading = false;
        myErrors(error)
    }
}
</script>
