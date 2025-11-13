<template>
  <div class="w-full   justify-content-center d-flex">
    <div class="card shadow-lg glass rounded-2xl overflow-hidden">
      <div class="card-body p-0">
        <!-- header -->
        <div class="p-5 text-center border-b border-gray-200">
          <h1 class="h4 mb-1 font-medium">خوش‌آمدید</h1>
          <p class="text-muted mb-0">برای ادامه وارد حساب‌کاربری شوید</p>
        </div>
        <!-- form -->
        <form id="loginForm" class="p-5" novalidate>
          <!-- ایمیل -->
          <div class="mb-4">
            <label for="email" class="form-label">ایمیل</label>
            <input type="email"
                   class="form-control rounded-md py-2"
                   id="email"
                   name="email"
                   placeholder="example@domain.com"
                   required
                   aria-describedby="emailHelp">
            <div class="invalid-feedback">لطفاً یک ایمیل معتبر وارد کنید.</div>
          </div>
          <!-- گذرواژه -->
          <div class="mb-3">
            <label for="password" class="form-label">گذرواژه</label>
            <div class="input-group">
              <input type="password"
                     class="form-control rounded-start-md py-2"
                     id="password"
                     name="password"
                     placeholder="••••••••"
                     required minlength="6" />

            </div>
          </div>
          <!-- دکمه ورود -->
          <div class="d-grid mb-3">
            <button type="submit" class="btn btn-primary btn-lg rounded-md">ورود</button>
          </div>

        </form>
      </div>
    </div>
  </div>

</template>

<script setup>

</script>


