<template>
  <div class="container mx-auto p-4">
    <div class="card shadow-lg p-4">
      <h2 class="card-title mb-3 text-xl font-bold">آپلود فایل اکسل</h2>

      <!-- انتخاب فایل -->
      <div class="mb-3">
        <label class="form-label block mb-1">فایل اکسل (xls / xlsx)</label>
        <input
          ref="fileInput"
          type="file"
          accept=".xls,.xlsx,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.ms-excel"
          @change="onFileChange"
          class="form-control block w-full p-2 border rounded"
        />
      </div>

      <!-- اطلاعات فایل انتخاب شده -->
      <div v-if="file" class="mb-3">
        <div class="d-flex align-items-center justify-content-between">
          <div>
            <strong>نام فایل:</strong> {{ file.name }} <br />
            <strong>حجم:</strong> {{ humanFileSize(file.size) }}
          </div>
          <div>
            <button class="btn btn-sm btn-outline-secondary me-2" @click="clearFile">حذف</button>
          </div>
        </div>
      </div>

      <!-- خطا -->
      <div v-if="error" class="alert alert-danger my-2">
        {{ error }}
      </div>

      <!-- نوار پیشرفت -->
      <div v-if="uploading" class="mb-3">
        <div class="progress" style="height: 22px;">
          <div
            class="progress-bar"
            role="progressbar"
            :style="{ width: progress + '%' }"
            :aria-valuenow="progress"
            aria-valuemin="0"
            aria-valuemax="100"
          >
            {{ progress }}%
          </div>
        </div>
      </div>

      <!-- دکمه ارسال -->
      <div class="d-flex gap-2">
        <button
          class="btn btn-primary"
          :disabled="!file || uploading"
          @click="upload"
        >
          ارسال به سرور
        </button>

        <button
          class="btn btn-secondary"
          @click="resetAll"
          :disabled="uploading && !file"
        >
          ریست
        </button>
      </div>

      <!-- پیام موفقیت -->
      <div v-if="successMessage" class="alert alert-success mt-3">
        {{ successMessage }}
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import axios from 'axios';
import {$ref} from "unplugin-vue-macros/macros";

const file = ref(null);
const error = ref('');
const progress = ref(0);
const uploading = ref(false);
const successMessage = ref('');
let url = $ref("visits");


function onFileChange(event) {
  error.value = '';
  successMessage.value = '';
  const selectedFile = event.target.files[0];
  if (!selectedFile) return;

  // اعتبارسنجی نوع فایل
  const allowedTypes = [
    'application/vnd.ms-excel',
    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
  ];
  if (!allowedTypes.includes(selectedFile.type)) {
    error.value = 'فایل انتخاب شده اکسل نیست!';
    clearFile();
    return;
  }

  // اعتبارسنجی حجم فایل (مثلاً کمتر از 5 مگابایت)
  const maxSize = 5 * 1024 * 1024;
  if (selectedFile.size > maxSize) {
    error.value = 'حجم فایل نباید بیشتر از 5 مگابایت باشد!';
    clearFile();
    return;
  }

  file.value = selectedFile;
}

function clearFile() {
  file.value = null;
  progress.value = 0;
  error.value = '';
  successMessage.value = '';

  if (refs.fileInput) refs.fileInput.value = '';
}

function resetAll() {
  clearFile();
}

// تبدیل سایز فایل به readable
function humanFileSize(size) {
  const i = size === 0 ? 0 : Math.floor(Math.log(size) / Math.log(1024));
  return (
    (size / Math.pow(1024, i)).toFixed(2) * 1 +
    ' ' +
    ['B', 'KB', 'MB', 'GB', 'TB'][i]
  );
}

async function upload() {
  if (!file.value) return;

  uploading.value = true;
  error.value = '';
  progress.value = 0;

  const formData = new FormData();
  formData.append('excel_file', file.value);

  try {
    const response = await axios.post(url, formData, {
      headers: { 'Content-Type': 'multipart/form-data' },
      onUploadProgress: (e) => {
        progress.value = Math.round((e.loaded * 100) / e.total);
      }
    });
    console.log(response);
    successMessage.value = 'فایل با موفقیت آپلود شد!';
    file.value = null;
  } catch (err) {
    if (err.response && err.response.data?.message) {
      error.value = err.response.data.message;
    } else {
      error.value = 'خطا در آپلود فایل!';
    }
  } finally {
    uploading.value = false;
    progress.value = 0;
  }
}
</script>
