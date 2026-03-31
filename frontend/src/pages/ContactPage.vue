<template>
  <PublicLayout>
    <section class="section">
      <div class="container contactSplit">
        <div class="contactIntro luxuryContactIntro">
          <div class="eyebrow">Private assistance</div>
          <h1>Contact us</h1>
          <p>
            Ask about bottle availability, pricing, featured brands, or a specific fragrance you want sourced.
          </p>

          <div class="contactInfoCard">
            <span>Client support</span>
            <strong>Fast direct response</strong>
          </div>
        </div>

        <div class="contactPanel inquiryLuxuryPanel">
          <h3>Send your request</h3>
          <p class="panelLead">Leave your details and continue directly after sending.</p>
          <InquiryForm />
        </div>
      </div>
    </section>
  </PublicLayout>
</template>

<script setup>
import PublicLayout from '../layouts/PublicLayout.vue'
import InquiryForm from '../components/InquiryForm.vue'
</script>
