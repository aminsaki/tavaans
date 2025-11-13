<template>
  <div class="container-fluid mx-auto p-4">
    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
      <!-- فرم سرچ -->
      <div class="p-3 border-bottom">
        <form class="row g-2 align-items-center" @submit.prevent="onSearch">
          <div class="col-12 col-md-6">
            <input
              v-model="searchQuery"
              type="text"
              class="form-control w-full"
              placeholder="جستجو بر اساس نام و نام‌خانوادگی"
            />
          </div>
          <div class="col-12 col-md-6 d-flex gap-2 justify-content-start justify-content-md-end">
            <button
              type="button"
              class="btn btn-outline-secondary px-3 py-1 text-sm"
              @click="resetSearch"
            >
              پاک کردن
            </button>
          </div>
        </form>
      </div>

      <div class="overflow-auto max-h-[85vh]">
        <table class="table table-border border table-striped-columns text-center">
          <thead class="bg-gray-100 sticky top-0 z-10">
            <tr>
              <th class="px-4 py-2 text-gray-700">نام و نام‌خانوادگی</th>
              <th class="px-4 py-2 text-gray-700">شماره تماس</th>
              <th class="px-4 py-2 text-gray-700">تعداد نفرات</th>
              <th class="px-4 py-2 text-gray-700">خودرو</th>
              <th class="px-4 py-2 text-gray-700">اکشن</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <tr
              v-for="(list, index) in lists"
              :key="list.id"
              class="hover:bg-gray-50"
            >
              <td class="px-4 py-2 whitespace-nowrap" data-label="نام و نام‌خانوادگی">
                {{ list.fullName }}
              </td>
              <td class="px-4 py-2 whitespace-nowrap" data-label="شماره تماس">
                {{ list.phone }}
              </td>

              <!-- تعداد نفرات -->
              <td class="px-4 py-2 whitespace-nowrap" data-label="تعداد نفرات">
                <select
                  v-model="list.companions"
                  class="min-w-[120px] bg-gray-50 border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-400 text-sm"
                >
                  <option value="" disabled="disabled">0 نفر </option>
                  <option value="1">1 نفر</option>
                  <option value="2">2 نفر</option>
                  <option value="3">3 نفر</option>
                  <option value="4">4 نفر</option>
                </select>
              </td>

              <!-- خودرو -->
              <td class="px-4 py-2 whitespace-nowrap" data-label="خودرو">
                <select
                  v-model="list.has_car"
                  class="min-w-[120px] bg-gray-50 border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-400 text-sm"
                >
                  <option value="" disabled>انتخاب نمایید</option>
                  <option value="false">خیر</option>
                  <option value="true">بله</option>
                </select>
              </td>

              <!-- دکمه‌ها -->

              <td class="px-4 py-2 flex flex-col sm:flex-row gap-2 justify-center whitespace-nowrap">

                <button
                  :disabled=" (list.entry_time)? true : false "
                  @click="sendData(list.id, 'entry_time')"
                  class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-sm disabled:opacity-50 disabled:cursor-not-allowed"
                >
                  ارسال پیامک ورود
                </button>
                <button
                  :disabled="(list.exit_time)?  true : false"
                  @click="sendData(list.id, 'exit_time')"
                  class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm disabled:opacity-50 disabled:cursor-not-allowed"
                >
                  ارسال پیامک خروجی
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Pagination -->
      <div
        class="card-footer d-flex justify-content-center align-items-center py-3 card"
        v-if="paginatetion"
        style="direction: rtl;"
      >
        <nav aria-label="Page navigation">
          <ul class="pagination pagination-sm flex-wrap mb-0">
            <li class="page-item" :class="{ disabled: paginatetion.current_page === 1 }">
              <button class="page-link" @click="foreachPaginateUsers(1)">«</button>
            </li>
            <li class="page-item" :class="{ disabled: !paginatetion.prev_page_url }">
              <button class="page-link" @click="foreachPaginateUsers(paginatetion.current_page - 1)">‹</button>
            </li>
            <li
              v-for="page in visiblePages"
              :key="page"
              class="page-item"
              :class="{ active: page === paginatetion.current_page }"
            >
              <button class="page-link" @click="foreachPaginateUsers(page)">{{ page }}</button>
            </li>
            <li class="page-item" :class="{ disabled: !paginatetion.next_page_url }">
              <button class="page-link" @click="foreachPaginateUsers(paginatetion.current_page + 1)">›</button>
            </li>
            <li class="page-item" :class="{ disabled: paginatetion.current_page === paginatetion.last_page }">
              <button class="page-link" @click="foreachPaginateUsers(paginatetion.last_page)">»</button>
            </li>
          </ul>
        </nav>
      </div>
    </div>
  </div>
</template>

<script setup>
import { $ref } from 'unplugin-vue-macros/macros'
import ApiService from '@/commons/servers/ApiService.js'
import { myErrors } from '@/commons/helpers/errors.js'
import { computed, onMounted } from 'vue'
import {toast} from "vue3-toastify";

let paginatetion = $ref([])
let searchQuery = $ref('')
let lists = $ref([])
let url = $ref('visits')

// Pagination
const visiblePages = computed(() => {
  const total = paginatetion.last_page || 1
  const current = paginatetion.current_page || 1
  const delta = 2
  const pages = []
  for (let i = Math.max(1, current - delta); i <= Math.min(total, current + delta); i++) pages.push(i)
  if (pages[0] > 1) pages.unshift('...')
  if (pages[pages.length - 1] < total) pages.push('...')
  return pages
})

// دریافت داده
async function getReports() {
  try {
    const response = await ApiService.get(url)
    if (response.status === 'true') {
      lists = response.data.data.map(item => ({
        ...item,
        companions: item.companions || '',
        has_car: item.has_car || ''
      }))
      makePaginatetion(response.data)
    }
  } catch (e) {
    myErrors(e)
  }
}

// ارسال داده
async function sendData(id, type) {
  const selectedRow = lists.find(item => item.id === id)
  const btnData = {
    id,
    method: type,
    companions: selectedRow.companions,
    has_car: selectedRow.has_car
  }
  try {
    const response = await ApiService.post('updateVisits', btnData)
    if (response.status === 'true'){
         toast.success(response.messages);
    }
  } catch (e) {
    myErrors(e)
  }
}

// Pagination helper
function makePaginatetion(data) {
  paginatetion = {
    current_page: data.current_page,
    last_page_url: data.last_page_url,
    next_page_url: data.next_page_url,
    prev_page_url: data.prev_page_url,
    first_page_url: data.first_page_url,
    total: data.total,
    to: data.last_page,
    count: data.to,
    last_page: data.last_page
  }
}

function foreachPaginateUsers(page) {
  url = `visits?page=${page}`
  getReports()
}

// جستجو
async function onSearch() {
  try {
    const response = await ApiService.post('serachVisits', [{ data: searchQuery }])
    if (response.status === 'true') {
      lists = response.data.data.map(item => ({
        ...item,
        companions: item.companions || '',
        has_car: item.has_car || ''
      }))
      makePaginatetion(response.data)
    }
  } catch (e) {
    myErrors(e)
  }
}

// پاک کردن سرچ
function resetSearch() {
  searchQuery = ''
  getReports()
}

onMounted(() => getReports())
</script>
