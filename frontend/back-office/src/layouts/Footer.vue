<template>
  <footer class="footer py-3 bg-light border-top">
    <div class="container-fluid">
      <div class="row align-items-center">
        <div class="col">
          <p class="mb-0 text-muted">&copy; {{ currentYear }} ETU-002716. All rights reserved.</p>
        </div>
        <div class="col-auto">
          <ul class="nav">
            <li class="nav-item">
              <a class="nav-link text-muted" href="#">Terms</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-muted" href="#">Privacy</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-muted" href="#">Help</a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </footer>
</template>

<script>
export default {
  name: 'Footer',
  computed: {
    currentYear() {
      return new Date().getFullYear();
    }
  }
}
</script>

<style scoped>
.footer {
  min-height: 60px;
}
</style>