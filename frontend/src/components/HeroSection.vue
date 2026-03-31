<template>
  <section class="heroSection">
    <div class="container heroGrid">
      <div class="heroContent">
        <div class="eyebrow">Luxury fragrance boutique</div>
        <h1>Silky visuals for bottles that deserve a richer stage.</h1>
        <p>
          Discover high-end designer and niche fragrances in a shop experience built to feel smooth,
          elegant, and premium on every screen.
        </p>

        <div class="heroActions">
          <router-link class="btnPrimary" to="/shop">Shop the collection</router-link>
          <router-link class="btnSecondary" to="/contact">Contact us</router-link>
        </div>

        <div class="heroStats">
          <div>
            <span>Curated style</span>
            <strong>Editorial layout</strong>
          </div>
          <div>
            <span>Presentation</span>
            <strong>Smooth luxury feel</strong>
          </div>
          <div>
            <span>Client flow</span>
            <strong>Fast direct contact</strong>
          </div>
        </div>
      </div>

      <div class="heroVisualCard">
        <div class="heroBottleStage">
          <div class="floatingBottle bottleOne"></div>
          <div class="floatingBottle bottleTwo"></div>
          <div class="floatingBottle bottleThree"></div>
          <div class="heroVisualGlow"></div>
        </div>

        <div class="heroEditorialPanel">
          <div class="eyebrow">Featured mood</div>
          <h3>Amber, woods, velvet florals</h3>
          <p>Designed to feel more couture, less template.</p>
        </div>
      </div>
    </div>
  </section>
</template>
