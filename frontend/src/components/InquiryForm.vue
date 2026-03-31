<template>
  <form class="inquiryForm" @submit.prevent="submit">
    <div class="formGrid">
      <label>
        <span>Name</span>
        <input v-model="form.name" type="text" required />
      </label>

      <label>
        <span>Phone</span>
        <input v-model="form.phone" type="text" required />
      </label>

      <label>
        <span>Email</span>
        <input v-model="form.email" type="email" />
      </label>

      <label class="fullSpan">
        <span>Message</span>
        <textarea v-model="form.message" rows="5" required />
      </label>
    </div>

    <div class="formActions leftAligned">
      <button class="btnPrimary" :disabled="loading">
        {{ loading ? 'Sending...' : 'Contact us' }}
      </button>
      <span v-if="successMessage" class="successText">{{ successMessage }}</span>
      <span v-if="errorMessage" class="errorText">{{ errorMessage }}</span>
    </div>
  </form>
</template>

<script setup>
import { reactive, ref, watch } from 'vue'
import http from '../api/http'

const props = defineProps({
  productId: {
    type: Number,
    default: null,
  },
  productTitle: {
    type: String,
    default: '',
  },
})

const form = reactive({
  name: '',
  phone: '',
  email: '',
  message: '',
})

const loading = ref(false)
const successMessage = ref('')
const errorMessage = ref('')

watch(
  () => props.productTitle,
  (value) => {
    if (value && !form.message) {
      form.message = `Hello, I want to ask about ${value}.`
    }
  },
  { immediate: true },
)

async function submit() {
  loading.value = true
  successMessage.value = ''
  errorMessage.value = ''

  const contactWindow = window.open('', '_blank', 'noopener,noreferrer')

  try {
    const { data } = await http.post('/inquiries', {
      product_id: props.productId,
      name: form.name,
      phone: form.phone,
      email: form.email || null,
      message: form.message,
      source: props.productId ? 'product-page' : 'contact-page',
    })

    if (data.whatsapp_url) {
      if (contactWindow) {
        contactWindow.location.href = data.whatsapp_url
      } else {
        window.open(data.whatsapp_url, '_blank', 'noopener,noreferrer')
      }
    } else if (contactWindow) {
      contactWindow.close()
    }

    successMessage.value = 'Your request was sent successfully.'

    form.name = ''
    form.phone = ''
    form.email = ''
    form.message = props.productTitle ? `Hello, I want to ask about ${props.productTitle}.` : ''
  } catch (error) {
    if (contactWindow) {
      contactWindow.close()
    }

    errorMessage.value =
      error?.response?.data?.message || 'Could not send your request. Please try again.'
  } finally {
    loading.value = false
  }
}
</script>
