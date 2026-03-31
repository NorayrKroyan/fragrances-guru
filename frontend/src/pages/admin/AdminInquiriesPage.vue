<template>
  <AdminLayout>
    <div class="adminPage">
      <div class="adminPageHeader">
        <div>
          <div class="eyebrow">Admin</div>
          <h1>Inquiries</h1>
          <p class="adminHeaderLead">All contact requests saved from the storefront.</p>
        </div>
      </div>

      <div class="adminTableWrap adminPanelSolid">
        <table class="adminTable">
          <thead>
            <tr>
              <th>ID</th>
              <th>Date</th>
              <th>Name</th>
              <th>Phone</th>
              <th>Email</th>
              <th>Product</th>
              <th>Message</th>
            </tr>
          </thead>

          <tbody>
            <tr v-for="inquiry in inquiries" :key="inquiry.id">
              <td>{{ inquiry.id }}</td>
              <td>{{ new Date(inquiry.created_at).toLocaleString() }}</td>
              <td>{{ inquiry.name }}</td>
              <td>{{ inquiry.phone }}</td>
              <td>{{ inquiry.email || '-' }}</td>
              <td>{{ inquiry.product ? `${inquiry.product.brand} ${inquiry.product.name}` : '-' }}</td>
              <td class="messageCell">{{ inquiry.message }}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import { onMounted, ref } from 'vue'
import AdminLayout from '../../layouts/AdminLayout.vue'
import http from '../../api/http'

const inquiries = ref([])

async function loadInquiries() {
  const { data } = await http.get('/admin/inquiries')
  inquiries.value = data.data || []
}

onMounted(loadInquiries)
</script>
