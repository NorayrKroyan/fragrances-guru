<template>
  <PublicLayout>
    <HeroSection />

    <section class="section sectionTightTop">
      <div class="container">
        <div class="statsRibbon">
          <div class="statsRibbonCard">
            <span>Store mood</span>
            <strong>Quiet luxury</strong>
          </div>
          <div class="statsRibbonCard">
            <span>Experience</span>
            <strong>Smoother transitions</strong>
          </div>
          <div class="statsRibbonCard">
            <span>Selection</span>
            <strong>{{ products.length }} premium fragrances</strong>
          </div>
        </div>
      </div>
    </section>

    <section class="section">
      <div class="container">
        <div class="sectionHeader">
          <div>
            <div class="eyebrow">Featured selection</div>
            <h2>Luxury cards with a calmer, more expensive feel.</h2>
            <p>Designed for premium designer names, elegant product imagery, and high-conversion browsing.</p>
          </div>
          <router-link class="btnSecondary" to="/shop">See all fragrances</router-link>
        </div>

        <div class="productGrid">
          <ProductCard v-for="product in featuredProducts" :key="product.id" :product="product" />
        </div>
      </div>
    </section>

    <section class="section">
      <div class="container storyGrid">
        <div class="storyPanel glowPanel">
          <div class="eyebrow">Editorial mood</div>
          <h3>Warm woods, smooth florals, deeper signatures</h3>
          <p>
            Make the storefront feel refined with layered gradients, heavier imagery, soft shadows,
            and calmer spacing across the entire browsing journey.
          </p>
        </div>

        <div class="storyPanel darkPanel">
          <div class="eyebrow">For boutique selling</div>
          <h3>Built for Tom Ford, Ferragamo, Dior and more</h3>
          <p>
            The public side stays luxurious and visual, while the admin remains simple enough for fast product updates.
          </p>
        </div>
      </div>
    </section>

    <section class="section">
      <div class="container spotlightShell">
        <div class="spotlightCopy">
          <div class="eyebrow">Private service</div>
          <h2>Need a specific bottle, stock check, or pricing confirmation?</h2>
          <p>
            Use the contact flow and continue the conversation directly after sending your request.
          </p>
          <router-link class="btnPrimary" to="/contact">Contact us</router-link>
        </div>
        <div class="spotlightVisual">
          <div class="spotlightOrb"></div>
        </div>
      </div>
    </section>
  </PublicLayout>
</template>

<script setup>
import { computed, onMounted, ref } from 'vue'
import http from '../api/http'
import PublicLayout from '../layouts/PublicLayout.vue'
import HeroSection from '../components/HeroSection.vue'
import ProductCard from '../components/ProductCard.vue'

const products = ref([])

const featuredProducts = computed(() => products.value.filter((item) => item.is_featured).slice(0, 4))

async function loadProducts() {
  const { data } = await http.get('/products')
  products.value = data.data || []
}

onMounted(loadProducts)
</script>
