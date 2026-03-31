<template>
  <AdminLayout>
    <div class="adminPage">
      <div class="adminPageHeader">
        <div>
          <div class="eyebrow">Admin</div>
          <h1>Products</h1>
          <p class="adminHeaderLead">Upload images, update product cards, and control the public collection.</p>
        </div>

        <button class="btnPrimary" @click="openNew">Add product</button>
      </div>

      <div class="adminTableWrap adminPanelSolid">
        <table class="adminTable">
          <thead>
            <tr>
              <th>ID</th>
              <th>Image</th>
              <th>Brand</th>
              <th>Name</th>
              <th>Price</th>
              <th>Stock</th>
              <th>Active</th>
              <th>Featured</th>
              <th></th>
            </tr>
          </thead>

          <tbody>
            <tr v-for="product in products" :key="product.id">
              <td>{{ product.id }}</td>
              <td>
                <div class="tableThumb">
                  <img v-if="product.image_url" :src="product.image_url" :alt="product.name" />
                  <span v-else>{{ product.brand?.[0] }}{{ product.name?.[0] }}</span>
                </div>
              </td>
              <td>{{ product.brand }}</td>
              <td>{{ product.name }}</td>
              <td>{{ product.currency }} {{ Number(product.price || 0).toFixed(2) }}</td>
              <td>{{ product.stock }}</td>
              <td>{{ product.is_active ? 'Yes' : 'No' }}</td>
              <td>{{ product.is_featured ? 'Yes' : 'No' }}</td>
              <td class="actionsCell">
                <button class="btnSmall" @click="openEdit(product)">Edit</button>
                <button class="btnDanger" @click="remove(product)">Delete</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <ProductModal v-if="showModal" :product="selectedProduct" @close="closeModal" @saved="handleSaved" />
    </div>
  </AdminLayout>
</template>

<script setup>
import { onMounted, ref } from 'vue'
import AdminLayout from '../../layouts/AdminLayout.vue'
import ProductModal from '../../components/admin/ProductModal.vue'
import http from '../../api/http'

const products = ref([])
const showModal = ref(false)
const selectedProduct = ref(null)

function openNew() {
  selectedProduct.value = null
  showModal.value = true
}

function openEdit(product) {
  selectedProduct.value = { ...product }
  showModal.value = true
}

function closeModal() {
  showModal.value = false
  selectedProduct.value = null
}

async function loadProducts() {
  const { data } = await http.get('/admin/products')
  products.value = data.data || []
}

async function handleSaved() {
  closeModal()
  await loadProducts()
}

async function remove(product) {
  if (!window.confirm(`Delete ${product.brand} ${product.name}?`)) {
    return
  }

  await http.delete(`/admin/products/${product.id}`)
  await loadProducts()
}

onMounted(loadProducts)
</script>
