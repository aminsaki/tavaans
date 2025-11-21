<template>
  <div class="d-flex" style="position: absolute">
    <!-- Sidebar -->
    <div
      :class="[
        'bg-dark text-white vh-100 p-1 transition-all duration-300',
        isOpen ? 'w-64' : 'w-8',
      ]"
    >
      <!-- Toggle Button -->
      <button class="btn btn-light w-100 mb-3" @click="isOpen = !isOpen">
        <i :class="isOpen ? 'fa fa-angle-right' : 'fa fa-angle-left'"></i>
      </button>

      <!-- Menu Items -->
      <ul class="list-unstyled">
        <li class="py-2 hover:bg-gray-700 rounded px-2 cursor-pointer d-flex align-items-center">
          <i class="bi bi-house"></i>
          <span class="ms-2">
            {{ isOpen ? '' : '' }}
            <router-link to="/panel/dashboard/excel" class="text-white btn">
              <span class="align-middle"> {{ isOpen ? 'فایل اکسل' : '' }}</span>
            </router-link>
          </span>
        </li>
        <li class="py-2 hover:bg-gray-700 rounded px-2 cursor-pointer d-flex align-items-center">
          <i class="bi bi-house"></i>
          <span class="ms-2">
            {{ isOpen ? '' : '' }}
            <router-link to="/home" class="text-white btn">
              <span class="align-middle"> {{ isOpen ? 'مشاهد لیست' : '' }}</span>
            </router-link>
          </span>
        </li>
        <!-- خانه -->
        <li class="py-2 hover:bg-gray-700 rounded px-2 cursor-pointer d-flex align-items-center">
          <i class="bi bi-house"></i>
          <span class="ms-2">
            {{ isOpen ? '' : '' }}
            <router-link to="/panel/dashboard/sms" class="text-white btn">
              <span class="align-middle"> {{ isOpen ? 'اضافه کردن شماره تماس' : '' }}</span>
            </router-link>
          </span>
        </li>
      </ul>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'

const isOpen = ref(true)
</script>

<style>
.transition-all {
  transition: all 0.3s ease;
}
</style>
