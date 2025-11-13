import { toast } from "vue3-toastify";
import "vue3-toastify/dist/index.css";

export function Errors(msg) {

  toast.error(msg, {
    "theme": "colored",
    "type": "error",
    "rtl":true,
    "position": "top-center",
    "transition": "flip",
    "autoClose": 6000,
    "dangerouslyHTMLString": true
  })

}
export function success(msg) {

  toast.success(msg, {
    "theme": "dark",
    "type": "error",
    "rtl":true,
    "position": "top-center",
    "transition": "flip",
    "autoClose": 6000,
    "dangerouslyHTMLString": true
  })

}
