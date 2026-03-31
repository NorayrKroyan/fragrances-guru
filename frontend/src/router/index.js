import { createRouter, createWebHistory } from 'vue-router'
import HomePage from '../pages/HomePage.vue'
import ShopPage from '../pages/ShopPage.vue'
import ProductPage from '../pages/ProductPage.vue'
import ContactPage from '../pages/ContactPage.vue'
import AdminLoginPage from '../pages/admin/AdminLoginPage.vue'
import AdminProductsPage from '../pages/admin/AdminProductsPage.vue'
import AdminInquiriesPage from '../pages/admin/AdminInquiriesPage.vue'
import { getToken } from '../services/auth'

const routes = [
  { path: '/', name: 'home', component: HomePage },
  { path: '/shop', name: 'shop', component: ShopPage },
  { path: '/product/:slug', name: 'product', component: ProductPage, props: true },
  { path: '/contact', name: 'contact', component: ContactPage },
  { path: '/admin/login', name: 'admin-login', component: AdminLoginPage },
  {
    path: '/admin/products',
    name: 'admin-products',
    component: AdminProductsPage,
    meta: { requiresAuth: true },
  },
  {
    path: '/admin/inquiries',
    name: 'admin-inquiries',
    component: AdminInquiriesPage,
    meta: { requiresAuth: true },
  },
  { path: '/:pathMatch(.*)*', redirect: '/' },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

router.beforeEach((to) => {
  if (to.meta.requiresAuth && !getToken()) {
    return { name: 'admin-login' }
  }

  if (to.name === 'admin-login' && getToken()) {
    return { name: 'admin-products' }
  }

  return true
})

export default router
