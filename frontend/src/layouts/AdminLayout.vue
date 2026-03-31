<template>
  <div class="adminShell">
    <aside class="adminSidebar">
      <div class="adminSidebarTop">
        <div class="adminSidebarBrand">fragrances.guru</div>
        <p>Admin studio</p>
      </div>

      <div class="adminNavGroup">
        <router-link to="/admin/products">Products</router-link>
        <router-link to="/admin/inquiries">Inquiries</router-link>
      </div>

      <button class="btnGhost" @click="logout">Logout</button>
    </aside>

    <main class="adminMain">
      <slot />
    </main>
  </div>
</template>

<script setup>
import { useRouter } from 'vue-router'
import http from '../api/http'
import { clearToken } from '../services/auth'

const router = useRouter()

async function logout() {
  try {
    await http.post('/admin/logout')
  } catch (error) {
    console.error(error)
  } finally {
    clearToken()
    router.push({ name: 'admin-login' })
  }
}
</script>
