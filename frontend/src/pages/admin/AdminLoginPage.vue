<template>
  <div class="adminLoginWrap">
    <form class="adminLoginCard solidLuxuryCard" @submit.prevent="login">
      <div class="eyebrow">Admin panel</div>
      <h1>Login</h1>
      <p>Default seeded admin: admin@fragrances.guru / Admin12345!</p>

      <label>
        <span>Email</span>
        <input v-model="form.email" type="email" required />
      </label>

      <label>
        <span>Password</span>
        <input v-model="form.password" type="password" required />
      </label>

      <button class="btnPrimary" :disabled="loading">
        {{ loading ? 'Logging in...' : 'Login' }}
      </button>

      <span v-if="errorMessage" class="errorText">{{ errorMessage }}</span>
    </form>
  </div>
</template>

<script setup>
import { reactive, ref } from 'vue'
import { useRouter } from 'vue-router'
import http from '../../api/http'
import { setToken } from '../../services/auth'

const router = useRouter()

const form = reactive({
  email: 'admin@fragrances.guru',
  password: 'Admin12345!',
})

const loading = ref(false)
const errorMessage = ref('')

async function login() {
  loading.value = true
  errorMessage.value = ''

  try {
    const { data } = await http.post('/admin/login', form)
    setToken(data.token)
    router.push({ name: 'admin-products' })
  } catch (error) {
    errorMessage.value =
      error?.response?.data?.message || 'Login failed. Please check credentials.'
  } finally {
    loading.value = false
  }
}
</script>
