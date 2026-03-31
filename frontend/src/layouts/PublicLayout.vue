<template>
  <div class="siteShell">
    <header class="siteHeader">
      <div class="container siteHeaderInner">
        <nav class="siteNav">
          <router-link to="/">Home</router-link>
          <router-link to="/shop">Shop</router-link>
          <router-link to="/contact">Contact</router-link>
          <router-link class="navButton" to="/shop">Explore collection</router-link>
        </nav>
      </div>
    </header>

    <slot />

    <footer class="siteFooter">
      <div class="container footerGrid">
        <div>
          <div class="brandMini">fragrances.guru</div>
          <p class="footerLead">
            Smooth luxury presentation for premium bottles, gift-worthy selections, and refined client service.
          </p>
        </div>

        <div>
          <div class="footerTitle">Browse</div>
          <div class="footerLinks">
            <router-link to="/">Home</router-link>
            <router-link to="/shop">Shop</router-link>
            <router-link to="/contact">Contact us</router-link>
          </div>
        </div>

        <div>
          <div class="footerTitle">Client service</div>
          <p class="footerCopy">Use the contact form for availability, bottle details, pricing, and private assistance.</p>
        </div>
      </div>
    </footer>
  </div>
</template>
