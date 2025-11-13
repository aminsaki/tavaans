import * as msg from "./msg.js";
import {success} from "./msg.js";

export function myErrors(error) {
  let errorMessage = ''; // مقدار اولیه را خالی نگه می‌داریم
  if (error?.response?.status === 422 && error?.response?.data?.errors) {
    const errorEntries = Object.entries(error.response.data.errors);
    if (errorEntries.length > 0 && Array.isArray(errorEntries[0][1])) {
      errorMessage = errorEntries[0][1][0]; // اولین پیام خطا را دریافت کن
    }
  } else if (error?.response?.status === 404) {
    errorMessage = error?.response?.data?.messages || 'یک خطای غیرمنتظره رخ داد.';
  }

  // فقط در صورتی که پیامی داریم، آن را نمایش دهیم
  if (errorMessage) {
    msg.Errors(errorMessage);
  }
}
