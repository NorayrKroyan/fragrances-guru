<template>
  <router-link class="productCard premiumCard" :to="`/product/${product.slug}`">
    <div class="productCardImageWrap">
      <img v-if="product.image_url" :src="product.image_url" :alt="product.name" class="productCardImage" />
      <div v-else class="productImagePlaceholder">{{ initials }}</div>

      <div class="productOverlayBadges">
        <span v-if="product.is_featured" class="productBadge">Featured</span>
        <span class="productBadge softBadge">{{ product.brand }}</span>
      </div>
    </div>

    <div class="productCardBody">
      <div class="productCardTopline">{{ product.brand }}</div>
      <h3>{{ product.name }}</h3>
      <p>{{ product.short_description || 'Refined fragrance selection.' }}</p>

      <div class="productCardFooter">
        <strong>{{ product.currency }} {{ Number(product.price || 0).toFixed(2) }}</strong>
        <span>View details</span>
      </div>
    </div>
  </router-link>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  product: {
    type: Object,
    required: true,
  },
})

const initials = computed(() => `${props.product.brand?.[0] || ''}${props.product.name?.[0] || ''}`)
</script>
