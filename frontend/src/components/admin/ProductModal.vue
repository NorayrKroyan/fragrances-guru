<template>
  <div class="modalBackdrop" @click.self="$emit('close')">
    <div class="modalCard modalCardLuxury">
      <div class="modalHeader">
        <div>
          <div class="eyebrow">Admin editor</div>
          <h3>{{ form.id ? 'Edit product' : 'New product' }}</h3>
        </div>
        <button class="iconButton" @click="$emit('close')">✕</button>
      </div>

      <form class="adminForm" @submit.prevent="save">
        <div class="adminFormGrid">
          <label>
            <span>Brand</span>
            <input v-model="form.brand" type="text" required />
          </label>

          <label>
            <span>Name</span>
            <input v-model="form.name" type="text" required />
          </label>

          <label>
            <span>Slug</span>
            <input v-model="form.slug" type="text" placeholder="auto-generated if empty" />
          </label>

          <label>
            <span>Upload image</span>
            <input type="file" accept="image/*" @change="handleFileChange" />
          </label>

          <label class="fullSpan">
            <span>Or external image URL</span>
            <input v-model="form.image_url" type="text" placeholder="https://..." />
          </label>

          <label>
            <span>Price</span>
            <input v-model.number="form.price" type="number" min="0" step="0.01" required />
          </label>

          <label>
            <span>Currency</span>
            <input v-model="form.currency" type="text" maxlength="3" required />
          </label>

          <label>
            <span>Stock</span>
            <input v-model.number="form.stock" type="number" min="0" required />
          </label>

          <label>
            <span>Sort order</span>
            <input v-model.number="form.sort_order" type="number" min="0" />
          </label>

          <label class="fullSpan">
            <span>Short description</span>
            <input v-model="form.short_description" type="text" />
          </label>

          <label class="fullSpan">
            <span>Description</span>
            <textarea v-model="form.description" rows="5" />
          </label>
        </div>

        <div class="imagePreviewPanel" v-if="imagePreview || form.image_url">
          <div class="imagePreviewHeader">
            <span>Current preview</span>
            <button v-if="imagePreview || form.image_url" type="button" class="btnGhostSmall" @click="removeImage">
              Remove image
            </button>
          </div>
          <img class="imagePreview" :src="imagePreview || form.image_url" alt="Preview" />
        </div>

        <div class="toggleRow">
          <label class="checkboxLabel"><input v-model="form.is_active" type="checkbox" /> Active</label>
          <label class="checkboxLabel"><input v-model="form.is_featured" type="checkbox" /> Featured</label>
        </div>

        <div class="formActions">
          <button class="btnPrimary" :disabled="saving">
            {{ saving ? 'Saving...' : 'Save product' }}
          </button>
          <span v-if="errorMessage" class="errorText">{{ errorMessage }}</span>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { reactive, ref } from 'vue'
import http from '../../api/http'

const props = defineProps({
  product: {
    type: Object,
    default: null,
  },
})

const emit = defineEmits(['close', 'saved'])

const form = reactive({
  id: props.product?.id || null,
  brand: props.product?.brand || '',
  name: props.product?.name || '',
  slug: props.product?.slug || '',
  short_description: props.product?.short_description || '',
  description: props.product?.description || '',
  image_url: props.product?.image_url || '',
  price: Number(props.product?.price || 0),
  currency: props.product?.currency || 'USD',
  stock: Number(props.product?.stock || 0),
  sort_order: Number(props.product?.sort_order || 0),
  is_active: props.product?.is_active ?? true,
  is_featured: props.product?.is_featured ?? false,
  remove_image: false,
})

const imageFile = ref(null)
const imagePreview = ref(props.product?.image_url || '')
const saving = ref(false)
const errorMessage = ref('')

function handleFileChange(event) {
  const file = event.target.files?.[0] || null
  imageFile.value = file
  form.remove_image = false

  if (file) {
    imagePreview.value = URL.createObjectURL(file)
  } else {
    imagePreview.value = form.image_url || ''
  }
}

function removeImage() {
  imageFile.value = null
  imagePreview.value = ''
  form.image_url = ''
  form.remove_image = true
}

async function save() {
  saving.value = true
  errorMessage.value = ''

  const formData = new FormData()
  formData.append('brand', form.brand)
  formData.append('name', form.name)
  formData.append('slug', form.slug || '')
  formData.append('short_description', form.short_description || '')
  formData.append('description', form.description || '')
  formData.append('image_url', form.image_url || '')
  formData.append('price', String(form.price))
  formData.append('currency', form.currency)
  formData.append('stock', String(form.stock))
  formData.append('sort_order', String(form.sort_order))
  formData.append('is_active', form.is_active ? '1' : '0')
  formData.append('is_featured', form.is_featured ? '1' : '0')
  formData.append('remove_image', form.remove_image ? '1' : '0')

  if (imageFile.value) {
    formData.append('image_file', imageFile.value)
  }

  try {
    if (form.id) {
      formData.append('_method', 'PUT')
      await http.post(`/admin/products/${form.id}`, formData)
    } else {
      await http.post('/admin/products', formData)
    }

    emit('saved')
  } catch (error) {
    errorMessage.value =
      error?.response?.data?.message || 'Could not save product. Please check the fields.'
  } finally {
    saving.value = false
  }
}
</script>
