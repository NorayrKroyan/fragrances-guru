<template>
  <PublicLayout>
    <section class="section">
      <div class="container" v-if="product">
        <div class="productDetail luxuryProductDetail smootherDetail">
          <div class="productDetailImageWrap luxuryDetailImageWrap">
            <img v-if="product.image_url" :src="product.image_url" :alt="product.name" class="productDetailImage" />
            <div v-else class="productImagePlaceholder largePlaceholder">{{ product.brand?.[0] }}{{ product.name?.[0] }}</div>
          </div>

          <div class="productDetailBody luxuryDetailBody">
            <div class="eyebrow">{{ product.brand }}</div>
            <h1>{{ product.name }}</h1>
            <p class="productPrice">{{ product.currency }} {{ Number(product.price || 0).toFixed(2) }}</p>
            <p class="productDescription">{{ product.description }}</p>

            <div class="detailInfoGrid">
              <div class="detailInfoCard">
                <span>Collection</span>
                <strong>{{ product.brand }} selection</strong>
              </div>
              <div class="detailInfoCard">
                <span>Availability</span>
                <strong>{{ product.stock > 0 ? `${product.stock} in stock` : 'Out of stock' }}</strong>
              </div>
              <div class="detailInfoCard">
                <span>Service</span>
                <strong>Fast private contact</strong>
              </div>
            </div>

            <div class="contactPanel inquiryLuxuryPanel">
              <h3>Contact us about this fragrance</h3>
              <p class="panelLead">Send your request and continue directly from the contact flow.</p>
              <InquiryForm :product-id="product.id" :product-title="`${product.brand} ${product.name}`" />
            </div>
          </div>
        </div>
      </div>
    </section>
  </PublicLayout>
</template>

<script setup>
import { onMounted, ref } from 'vue'
import { useRoute } from 'vue-router'
import http from '../api/http'
import PublicLayout from '../layouts/PublicLayout.vue'
import InquiryForm from '../components/InquiryForm.vue'

const route = useRoute()
const product = ref(null)

async function loadProduct() {
  const { data } = await http.get(`/products/${route.params.slug}`)
  product.value = data.data
}

onMounted(loadProduct)
</script>
