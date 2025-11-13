class Sidebar {
  constructor() {
    this.isSidebarOpen = false; // وضعیت پیش‌فرض سایدبار
    this.sidebar = document.getElementById('sidebar');
    this.toggleButton = document.querySelector('.sidebar-toggle');
    this.initialize();
  }

  initialize() {
    if (this.toggleButton) {
      this.toggleButton.addEventListener('click', () => this.toggleSidebar());
    }
  }

  toggleSidebar() {
    // this.isSidebarOpen = !this.isSidebarOpen;
    // if (this.isSidebarOpen) {
    //   this.sidebar.classList.add('open');
    // } else {
    //   this.sidebar.classList.remove('open');
    // }
  }
}

// ایجاد یک نمونه از کلاس سایدبار
document.addEventListener('DOMContentLoaded', function () {
  new Sidebar();
});