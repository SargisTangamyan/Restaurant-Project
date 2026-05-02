<script setup>
import TheBox from "@/components/ui/TheBox.vue";
import TheBanner from "@/components/home/TheBanner.vue";
import ImageText from "@/components/ui/image/ImageText.vue";
import { ref, onMounted } from "vue";
import { useCategoryStore } from "@/stores/index.js";

import homeImage1 from '@/assets/images/restaurant/banner/1.jpg'
import homeImage2 from '@/assets/images/restaurant/banner/2.jpg'
import homeImage3 from '@/assets/images/restaurant/banner/3.jpg'

const categoryStore = useCategoryStore();
const categories = ref([]);

onMounted(async () => {
  const result = await categoryStore.fetchCategories(1, 12);
  if (result.success) categories.value = result.categories;
});

const stats = [
  { value: '500+', label: 'Restaurants' },
  { value: '10k+', label: 'Happy Customers' },
  { value: '50+', label: 'Cuisines' },
  { value: '30 min', label: 'Avg. Delivery' },
];

const features = [
  {
    title: 'Fresh Quality',
    desc: 'Dishes prepared with premium, carefully sourced ingredients every time.',
  },
  {
    title: 'Lightning Fast',
    desc: 'Average delivery time under 30 minutes, guaranteed.',
  },
  {
    title: 'Live Tracking',
    desc: 'Follow your order in real time from kitchen straight to your door.',
  },
  {
    title: 'Best Prices',
    desc: 'Exclusive daily deals and discounts on all your favorites.',
  },
];
</script>

<template>

  <!-- ── HERO GRID ──────────────────────────────────── -->
  <the-box>
    <div class="hero-grid">

      <!-- Large left banner -->
      <div class="hero-main">
        <image-text image-alt="Discover fresh food" :image-src="homeImage1">
          <div class="hero-content">
            <span class="hero-badge">Exclusive offers up to
              <span class="discount-box">50% Off</span>
            </span>
            <h1 class="hero-title">
              Order Fresh Food From Your<br>
              <span class="hero-accent">Favorite Restaurants</span>
            </h1>
            <p class="hero-subtitle">
              Hundreds of local restaurants, thousands of dishes — delivered fast.
            </p>
            <div class="hero-actions">
              <router-link :to="{ name: 'restaurants' }" class="btn-primary">
                Browse Restaurants
              </router-link>
              <router-link :to="{ name: 'dishes' }" class="btn-outline-hero">
                Explore Menu
              </router-link>
            </div>
          </div>
        </image-text>
      </div>

      <!-- Right stacked banners -->
      <div class="hero-side">
        <div class="hero-side-card">
          <image-text image-alt="Best price dishes" :image-src="homeImage2">
            <div class="side-content">
              <h2 class="discount-box">50% Off</h2>
              <h3 class="side-title">Best Dishes For Best Price</h3>
              <p class="side-desc">We deliver organic and healthy dishes</p>
            </div>
          </image-text>
        </div>

        <div class="hero-side-card">
          <image-text image-alt="Healthy food" :image-src="homeImage3">
            <div class="side-content">
              <h3 class="side-title">Healthy Food</h3>
              <p class="side-desc">Start your day with healthy nutrition</p>
              <router-link :to="{ name: 'dishes' }" class="side-link">
                Order Now &rsaquo;
              </router-link>
            </div>
          </image-text>
        </div>
      </div>

    </div>
  </the-box>

  <!-- ── STATS STRIP ────────────────────────────────── -->
  <section class="stats-strip">
    <the-box :mb="false">
      <div class="stats-grid">
        <div v-for="(stat, i) in stats" :key="i" class="stat-item">
          <span class="stat-divider" v-if="i > 0"></span>
          <div class="stat-body">
            <strong class="stat-value">{{ stat.value }}</strong>
            <span class="stat-label">{{ stat.label }}</span>
          </div>
        </div>
      </div>
    </the-box>
  </section>

  <!-- ── CATEGORIES (when available) ──────────────── -->
  <the-box v-if="categories.length > 0">
    <div class="categories-section">
      <div class="inline-header">
        <div>
          <span class="section-badge">BROWSE BY TYPE</span>
          <h2 class="section-title">Popular Categories</h2>
        </div>
        <router-link :to="{ name: 'dishes' }" class="text-link">See all &rsaquo;</router-link>
      </div>
      <div class="categories-scroll">
        <router-link
          v-for="cat in categories"
          :key="cat.id"
          :to="{ name: 'dishes', query: { category: cat.id } }"
          class="category-pill"
        >
          {{ cat.name }}
        </router-link>
      </div>
    </div>
  </the-box>

  <!-- ── FEATURED DISHES CAROUSEL ──────────────────── -->
  <the-banner />

  <!-- ── WHY CHOOSE EATO ────────────────────────────── -->
  <section class="features-section">
    <the-box :mb="false">
      <div class="section-center">
        <span class="section-badge">WHY EATO</span>
        <h2 class="section-title">Why Choose Us</h2>
        <p class="section-desc">We bring the best food experience right to your doorstep.</p>
      </div>

      <div class="features-grid">

        <!-- Fresh Quality -->
        <div class="feature-card">
          <div class="feature-icon-wrap">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
              <path d="M9.813 15.904 9 18.75l-.813-2.846a4.5 4.5 0 0 0-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 0 0 3.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 0 0 3.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 0 0-3.09 3.09ZM18.259 8.715 18 9.75l-.259-1.035a3.375 3.375 0 0 0-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 0 0 2.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 0 0 2.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 0 0-2.456 2.456ZM16.894 20.567 16.5 21.75l-.394-1.183a2.25 2.25 0 0 0-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 0 0 1.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 0 0 1.423 1.423l1.183.394-1.183.394a2.25 2.25 0 0 0-1.423 1.423Z"/>
            </svg>
          </div>
          <h3 class="feature-title">{{ features[0].title }}</h3>
          <p class="feature-desc">{{ features[0].desc }}</p>
        </div>

        <!-- Lightning Fast -->
        <div class="feature-card">
          <div class="feature-icon-wrap">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
              <path fill-rule="evenodd" d="M14.615 1.595a.75.75 0 0 1 .359.852L12.982 9.75h7.268a.75.75 0 0 1 .548 1.262l-10.5 11.25a.75.75 0 0 1-1.272-.71l1.992-7.302H3.75a.75.75 0 0 1-.548-1.262l10.5-11.25a.75.75 0 0 1 .913-.143Z" clip-rule="evenodd"/>
            </svg>
          </div>
          <h3 class="feature-title">{{ features[1].title }}</h3>
          <p class="feature-desc">{{ features[1].desc }}</p>
        </div>

        <!-- Live Tracking -->
        <div class="feature-card">
          <div class="feature-icon-wrap">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
              <path fill-rule="evenodd" d="m11.54 22.351.07.04.028.016a.76.76 0 0 0 .723 0l.028-.015.071-.041a16.975 16.975 0 0 0 1.144-.742 19.58 19.58 0 0 0 2.683-2.282c1.944-2.003 3.5-4.697 3.5-8.327a8 8 0 0 0-16 0c0 3.63 1.556 6.326 3.5 8.327a19.583 19.583 0 0 0 2.682 2.282 16.975 16.975 0 0 0 1.145.742ZM12 13.5a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" clip-rule="evenodd"/>
            </svg>
          </div>
          <h3 class="feature-title">{{ features[2].title }}</h3>
          <p class="feature-desc">{{ features[2].desc }}</p>
        </div>

        <!-- Best Prices -->
        <div class="feature-card">
          <div class="feature-icon-wrap">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
              <path fill-rule="evenodd" d="M5.25 2.25a3 3 0 0 0-3 3v4.318a3 3 0 0 0 .879 2.121l9.58 9.581c.92.92 2.39 1.186 3.548.428a18.849 18.849 0 0 0 5.441-5.44c.758-1.16.492-2.629-.428-3.548l-9.58-9.581a3 3 0 0 0-2.122-.879H5.25ZM6.375 7.5a1.125 1.125 0 1 0 0-2.25 1.125 1.125 0 0 0 0 2.25Z" clip-rule="evenodd"/>
            </svg>
          </div>
          <h3 class="feature-title">{{ features[3].title }}</h3>
          <p class="feature-desc">{{ features[3].desc }}</p>
        </div>

      </div>
    </the-box>
  </section>

</template>

<style scoped>

/* ── HERO GRID ───────────────────────────────────────── */
.hero-grid {
  display: grid;
  grid-template-columns: 1fr;
  gap: 1rem;
}

.hero-main {
  min-height: 320px;
  border-radius: 16px;
  overflow: hidden;
}

.hero-content {
  position: absolute;
  left: 2rem;
  top: 50%;
  transform: translateY(-50%);
  width: 70%;
  display: flex;
  flex-direction: column;
  gap: 0.75rem;
}

.hero-badge {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  color: #fff;
  font-size: 0.9rem;
  font-weight: 500;
}

.hero-title {
  color: #fff;
  font-size: clamp(1.4rem, 3vw, 2.6rem);
  font-weight: 900;
  line-height: 1.25;
  margin: 0;
  text-transform: uppercase;
  letter-spacing: 0.01em;
}

.hero-accent {
  color: #0da487;
}

.hero-subtitle {
  color: rgba(255, 255, 255, 0.85);
  font-size: 0.95rem;
  margin: 0;
  max-width: 400px;
}

.hero-actions {
  display: flex;
  flex-wrap: wrap;
  gap: 0.75rem;
  margin-top: 0.25rem;
}

.btn-primary {
  display: inline-block;
  background-color: #0da487;
  color: #fff;
  padding: 0.65rem 1.5rem;
  border-radius: 8px;
  font-weight: 700;
  font-size: 0.9rem;
  text-decoration: none;
  transition: background-color 0.2s, transform 0.2s;
}

.btn-primary:hover {
  background-color: #0b8c74;
  transform: translateY(-2px);
}

.btn-outline-hero {
  display: inline-block;
  background-color: rgba(255, 255, 255, 0.15);
  backdrop-filter: blur(4px);
  color: #fff;
  padding: 0.65rem 1.5rem;
  border-radius: 8px;
  font-weight: 700;
  font-size: 0.9rem;
  text-decoration: none;
  border: 1px solid rgba(255, 255, 255, 0.4);
  transition: background-color 0.2s;
}

.btn-outline-hero:hover {
  background-color: rgba(255, 255, 255, 0.25);
}

/* Right banners */
.hero-side {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 1rem;
}

.hero-side-card {
  min-height: 155px;
  border-radius: 14px;
  overflow: hidden;
}

.side-content {
  position: absolute;
  left: 1.25rem;
  top: 50%;
  transform: translateY(-50%);
  width: 80%;
  display: flex;
  flex-direction: column;
  gap: 0.3rem;
}

.side-title {
  color: #fff;
  font-size: 1rem;
  font-weight: 700;
  margin: 0;
}

.side-desc {
  color: rgba(255, 255, 255, 0.85);
  font-size: 0.78rem;
  margin: 0;
}

.side-link {
  color: #fff;
  font-weight: 700;
  font-size: 0.82rem;
  text-decoration: none;
  opacity: 0.9;
  transition: opacity 0.2s;
}

.side-link:hover {
  opacity: 1;
}

/* Desktop: side-by-side layout */
@media (min-width: 1280px) {
  .hero-grid {
    grid-template-columns: 2fr 1fr;
  }

  .hero-main {
    min-height: 420px;
  }

  .hero-side {
    grid-template-columns: 1fr;
    grid-template-rows: 1fr 1fr;
  }

  .hero-side-card {
    min-height: 0;
    height: 100%;
  }
}

/* ── STATS STRIP ─────────────────────────────────────── */
.stats-strip {
  background: linear-gradient(135deg, #0da487, #0b8c74);
  padding: 2rem 0;
  margin-top: 0.5rem;
}

.stats-grid {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  align-items: center;
  gap: 0;
}

.stat-item {
  display: flex;
  align-items: center;
  flex: 1 1 140px;
  min-width: 130px;
  justify-content: center;
}

.stat-divider {
  display: none;
  width: 1px;
  height: 40px;
  background-color: rgba(255, 255, 255, 0.3);
  flex-shrink: 0;
}

.stat-body {
  display: flex;
  flex-direction: column;
  align-items: center;
  text-align: center;
  padding: 0.75rem 1.5rem;
}

.stat-value {
  color: #fff;
  font-size: 2rem;
  font-weight: 900;
  line-height: 1;
  letter-spacing: -0.02em;
}

.stat-label {
  color: rgba(255, 255, 255, 0.8);
  font-size: 0.82rem;
  font-weight: 500;
  margin-top: 0.25rem;
  text-transform: uppercase;
  letter-spacing: 0.06em;
}

@media (min-width: 640px) {
  .stat-divider {
    display: block;
  }
}

/* ── SHARED SECTION TYPOGRAPHY ───────────────────────── */
.section-badge {
  display: block;
  color: #0da487;
  font-size: 0.72rem;
  font-weight: 700;
  letter-spacing: 0.14em;
  margin-bottom: 0.4rem;
}

.section-title {
  font-size: clamp(1.5rem, 3vw, 2rem);
  font-weight: 800;
  color: #1a1a2e;
  margin: 0 0 0.5rem;
  line-height: 1.2;
}

.section-desc {
  color: #6b7280;
  font-size: 0.95rem;
  margin: 0;
}

.section-center {
  text-align: center;
  margin-bottom: 3rem;
}

.section-center .section-desc {
  max-width: 460px;
  margin: 0 auto;
}

.inline-header {
  display: flex;
  justify-content: space-between;
  align-items: flex-end;
  margin-bottom: 1.5rem;
}

.text-link {
  color: #0da487;
  font-weight: 600;
  font-size: 0.88rem;
  text-decoration: none;
  border-bottom: 1px solid transparent;
  transition: border-color 0.2s;
}

.text-link:hover {
  border-bottom-color: #0da487;
}

/* ── CATEGORIES ──────────────────────────────────────── */
.categories-section {
  padding: 0.5rem 0 1rem;
}

.categories-scroll {
  display: flex;
  flex-wrap: wrap;
  gap: 0.625rem;
}

.category-pill {
  display: inline-block;
  padding: 0.45rem 1.1rem;
  background-color: #f1f5f9;
  color: #374151;
  border-radius: 999px;
  font-size: 0.85rem;
  font-weight: 500;
  text-decoration: none;
  border: 1px solid #e2e8f0;
  transition: background-color 0.2s, color 0.2s, border-color 0.2s;
  white-space: nowrap;
}

.category-pill:hover {
  background-color: #0da487;
  color: #fff;
  border-color: #0da487;
}

/* ── HOW IT WORKS ────────────────────────────────────── */
.how-section {
  background: #fff;
  padding: 5rem 0;
}

.steps-grid {
  display: grid;
  grid-template-columns: 1fr;
  gap: 2.5rem;
}

.step-card {
  position: relative;
  text-align: center;
  padding: 2rem 1.5rem;
  border-radius: 16px;
  background: #f8fafc;
  border: 1px solid #e9edf2;
  transition: box-shadow 0.25s, transform 0.25s;
}

.step-card:hover {
  box-shadow: 0 8px 30px rgba(13, 164, 135, 0.12);
  transform: translateY(-4px);
}

.step-connector {
  display: none;
}

.step-number {
  font-size: 3.5rem;
  font-weight: 900;
  color: rgba(13, 164, 135, 0.12);
  line-height: 1;
  margin-bottom: 0.75rem;
  letter-spacing: -0.03em;
}

.step-card:hover .step-number {
  color: rgba(13, 164, 135, 0.25);
}

.step-title {
  font-size: 1.1rem;
  font-weight: 700;
  color: #1a1a2e;
  margin: 0 0 0.6rem;
}

.step-desc {
  color: #6b7280;
  font-size: 0.88rem;
  line-height: 1.65;
  margin: 0;
}

@media (min-width: 768px) {
  .steps-grid {
    grid-template-columns: repeat(3, 1fr);
    gap: 2rem;
  }

  .step-connector {
    display: block;
    position: absolute;
    top: 50%;
    right: -1.1rem;
    width: 2.2rem;
    height: 2px;
    background: repeating-linear-gradient(
      90deg,
      #0da487 0,
      #0da487 6px,
      transparent 6px,
      transparent 12px
    );
    transform: translateY(-50%);
    z-index: 1;
  }
}

/* ── WHY CHOOSE EATO ─────────────────────────────────── */
.features-section {
  background: #f1faf7;
  padding: 5rem 0;
}

.features-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 1.5rem;
}

.feature-card {
  background: #fff;
  border-radius: 16px;
  padding: 2rem 1.5rem;
  border: 1px solid #e9edf2;
  transition: box-shadow 0.25s, transform 0.25s;
}

.feature-card:hover {
  box-shadow: 0 8px 28px rgba(13, 164, 135, 0.13);
  transform: translateY(-4px);
}

.feature-icon-wrap {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 52px;
  height: 52px;
  background: rgba(13, 164, 135, 0.1);
  border-radius: 14px;
  color: #0da487;
  margin-bottom: 1.1rem;
}

.feature-icon-wrap svg {
  width: 24px;
  height: 24px;
}

.feature-title {
  font-size: 1.05rem;
  font-weight: 700;
  color: #1a1a2e;
  margin: 0 0 0.5rem;
}

.feature-desc {
  color: #6b7280;
  font-size: 0.875rem;
  line-height: 1.65;
  margin: 0;
}

@media (min-width: 1024px) {
  .features-grid {
    grid-template-columns: repeat(4, 1fr);
  }
}

</style>
