<template>
  <PublicLayout>
    <section class="section">
      <div class="container">
        <div class="shopHeroCard smoothShopHero">
          <div>
            <div class="eyebrow">Luxury boutique</div>
            <h1>Shop the collection</h1>
            <p>
              A smoother, richer storefront for premium fragrance browsing, refined imagery, and more elegant product presentation.
            </p>
          </div>

          <div class="shopHeroMeta">
            <div>
              <span>Brands</span>
              <strong>{{ brands.length }}</strong>
            </div>
            <div>
              <span>Products</span>
              <strong>{{ filteredProducts.length }}</strong>
            </div>
          </div>
        </div>

        <div class="shopControls luxuryControls">
          <div class="filters luxurySearchWrap">
            <input
              v-model="search"
              type="text"
              placeholder="Search by brand, perfume, or description..."
              @keyup.enter="loadProducts"
            />
            <button class="btnSecondary" @click="loadProducts">Search</button>
          </div>

          <div class="brandFilters">
            <button class="brandChip" :class="{ active: activeBrand === '' }" @click="setBrand('')">All</button>
            <button
              v-for="brand in brands"
              :key="brand"
              class="brandChip"
              :class="{ active: activeBrand === brand }"
              @click="setBrand(brand)"
            >
              {{ brand }}
            </button>
          </div>
        </div>

        <div v-if="filteredProducts.length" class="productGrid productGridLuxury">
          <ProductCard v-for="product in filteredProducts" :key="product.id" :product="product" />
        </div>

        <div v-else class="emptyState">
          <h3>No fragrances found</h3>
          <p>Try another brand or search phrase.</p>
        </div>
      </div>
    </section>
  </PublicLayout>
</template>

<script setup>
import { computed, onMounted, ref } from 'vue'
import http from '../api/http'
import PublicLayout from '../layouts/PublicLayout.vue'
import ProductCard from '../components/ProductCard.vue'

const products = ref([])
const search = ref('')
const activeBrand = ref('')

const brands = computed(() => [...new Set(products.value.map((item) => item.brand))])

const filteredProducts = computed(() => {
  return products.value.filter((item) => !activeBrand.value || item.brand === activeBrand.value)
})

function setBrand(brand) {
  activeBrand.value = brand
}

async function loadProducts() {
  const { data } = await http.get('/products', {
    params: {
      search: search.value || undefined,
    },
  })

  products.value = data.data || []
}

onMounted(loadProducts)
</script>
