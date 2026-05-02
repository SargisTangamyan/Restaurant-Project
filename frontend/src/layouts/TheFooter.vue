<script setup>
import TheBox from "@/components/ui/TheBox.vue";
</script>

<template>
  <footer>
    <div class="footer-top">
      <the-box :mb="false">
        <div class="footer-grid">

          <!-- Brand Column -->
          <div class="footer-col">
            <router-link :to="{ name: 'home' }" class="footer-logo-link">
              <img src="../assets/images/logo/eato.png" alt="EATO" class="footer-logo" />
            </router-link>
            <p class="footer-desc">
              Discover the best food &amp; drinks from your favorite local restaurants, delivered fast straight to your door.
            </p>
            <div class="social-row">
              <a href="#" class="social-link" aria-label="Facebook">
                <img src="../assets/images/inner-page/facebook.png" alt="Facebook" class="social-img" />
              </a>
              <a href="#" class="social-link" aria-label="Google">
                <img src="../assets/images/inner-page/google.png" alt="Google" class="social-img" />
              </a>
              <a href="#" class="social-link" aria-label="Instagram">
                <svg class="social-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/>
                </svg>
              </a>
              <a href="#" class="social-link" aria-label="Twitter / X">
                <svg class="social-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                  <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                </svg>
              </a>
            </div>
          </div>

          <!-- Quick Links -->
          <div class="footer-col">
            <h4 class="footer-heading">
              <span class="heading-accent"></span>
              Quick Links
            </h4>
            <ul class="footer-links">
              <li><router-link :to="{ name: 'home' }">Home</router-link></li>
              <li><router-link :to="{ name: 'restaurants' }">Restaurants</router-link></li>
              <li><router-link :to="{ name: 'dishes' }">Menu</router-link></li>
              <li><router-link :to="{ name: 'my_orders' }">My Orders</router-link></li>
              <li><router-link :to="{ name: 'wishlist' }">Wishlist</router-link></li>
              <li><router-link :to="{ name: 'user' }">My Account</router-link></li>
            </ul>
          </div>

          <!-- Contact -->
          <div class="footer-col">
            <h4 class="footer-heading">
              <span class="heading-accent"></span>
              Contact Us
            </h4>
            <ul class="contact-list">
              <li class="contact-item">
                <span class="contact-icon">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path fill-rule="evenodd" d="M11.54 22.351l.07.04.028.016a.76.76 0 0 0 .723 0l.028-.015.071-.041a16.975 16.975 0 0 0 1.144-.742 19.58 19.58 0 0 0 2.683-2.282c1.944-2.003 3.5-4.697 3.5-8.327a8 8 0 0 0-16 0c0 3.63 1.556 6.326 3.5 8.327a19.583 19.583 0 0 0 2.682 2.282 16.975 16.975 0 0 0 1.145.742zM12 13.5a3 3 0 1 0 0-6 3 3 0 0 0 0 6z" clip-rule="evenodd"/>
                  </svg>
                </span>
                <span>1418 Riverwood Drive,<br>CA 96052, US</span>
              </li>
              <li class="contact-item">
                <span class="contact-icon">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path fill-rule="evenodd" d="M1.5 4.5a3 3 0 0 1 3-3h1.372c.86 0 1.61.586 1.819 1.42l1.105 4.423a1.875 1.875 0 0 1-.694 1.955l-1.293.97c-.135.101-.164.249-.126.352a11.285 11.285 0 0 0 6.697 6.697c.103.038.25.009.352-.126l.97-1.293a1.875 1.875 0 0 1 1.955-.694l4.423 1.105c.834.209 1.42.959 1.42 1.82V19.5a3 3 0 0 1-3 3h-2.25C8.552 22.5 1.5 15.448 1.5 6.75V4.5z" clip-rule="evenodd"/>
                  </svg>
                </span>
                <span>+1 (555) 123-4567</span>
              </li>
              <li class="contact-item">
                <span class="contact-icon">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M1.5 8.67v8.58a3 3 0 0 0 3 3h15a3 3 0 0 0 3-3V8.67l-8.928 5.493a3 3 0 0 1-3.144 0L1.5 8.67z"/>
                    <path d="M22.5 6.908V6.75a3 3 0 0 0-3-3h-15a3 3 0 0 0-3 3v.158l9.714 5.978a1.5 1.5 0 0 0 1.572 0L22.5 6.908z"/>
                  </svg>
                </span>
                <span>support@eato.com</span>
              </li>
            </ul>
          </div>

          <!-- Opening Hours -->
          <div class="footer-col">
            <h4 class="footer-heading">
              <span class="heading-accent"></span>
              Opening Hours
            </h4>
            <ul class="hours-list">
              <li class="hours-item">
                <span class="hours-day">Monday – Friday</span>
                <span class="hours-time">08:00 – 22:00</span>
              </li>
              <li class="hours-item">
                <span class="hours-day">Saturday</span>
                <span class="hours-time">09:00 – 23:00</span>
              </li>
              <li class="hours-item">
                <span class="hours-day">Sunday</span>
                <span class="hours-time">10:00 – 21:00</span>
              </li>
            </ul>
            <div class="order-badge">
              <svg class="order-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path d="M12 1.5a.75.75 0 0 1 .75.75V7.5h-1.5V2.25A.75.75 0 0 1 12 1.5zM11.25 7.5v5.69l-1.72-1.72a.75.75 0 0 0-1.06 1.06l3 3a.75.75 0 0 0 1.06 0l3-3a.75.75 0 1 0-1.06-1.06l-1.72 1.72V7.5h-1.5z"/>
                <path d="M3.75 6.75a3 3 0 0 0-3 3v6.75a3 3 0 0 0 3 3h16.5a3 3 0 0 0 3-3V9.75a3 3 0 0 0-3-3H3.75z"/>
              </svg>
              <span>Order online 24/7</span>
            </div>
          </div>

        </div>
      </the-box>
    </div>

    <div class="footer-bottom">
      <the-box :mb="false">
        <div class="footer-bottom-inner">
          <p class="copyright">
            &copy; {{ new Date().getFullYear() }}
            <span class="brand-highlight">EATO</span>.
            All rights reserved.
          </p>
          <nav class="bottom-links">
            <a href="#">Privacy Policy</a>
            <a href="#">Terms of Service</a>
            <a href="#">Cookie Policy</a>
          </nav>
        </div>
      </the-box>
    </div>
  </footer>
</template>

<style scoped>

/* ── TOP SECTION ─────────────────────────────────────── */
.footer-top {
  background-color: #1c1c2e;
  padding: 60px 0 48px;
  color: #b0b8c4;
}

.footer-grid {
  display: grid;
  grid-template-columns: 1fr;
  gap: 2.5rem;
}

/* ── COLUMN SHARED ───────────────────────────────────── */
.footer-col {
  display: flex;
  flex-direction: column;
  gap: 1rem;
}

/* ── BRAND COLUMN ────────────────────────────────────── */
.footer-logo-link {
  display: block;
  width: 200px;
  padding: 10px 18px;
  background-color: #ffffff;
  border-radius: 12px;
  box-shadow: 0 2px 12px rgba(0, 0, 0, 0.25);
  transition: box-shadow 0.2s, transform 0.2s;
}

.footer-logo-link:hover {
  box-shadow: 0 4px 20px rgba(13, 164, 135, 0.35);
  transform: translateY(-2px);
}

.footer-logo {
  display: block;
  width: 100%;
  height: auto;
  object-fit: contain;
}

.footer-desc {
  font-size: 0.875rem;
  line-height: 1.7;
  color: #8a95a3;
  margin: 0;
  max-width: 280px;
}

/* Social row */
.social-row {
  display: flex;
  align-items: center;
  gap: 0.75rem;
  margin-top: 0.25rem;
}

.social-link {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 36px;
  height: 36px;
  border-radius: 50%;
  background-color: rgba(255, 255, 255, 0.07);
  border: 1px solid rgba(255, 255, 255, 0.1);
  color: #b0b8c4;
  transition: background-color 0.2s, color 0.2s, border-color 0.2s;
}

.social-link:hover {
  background-color: #0da487;
  border-color: #0da487;
  color: #fff;
}

.social-img {
  width: 18px;
  height: 18px;
  object-fit: contain;
  filter: brightness(0) invert(1);
  opacity: 0.8;
}

.social-link:hover .social-img {
  opacity: 1;
}

.social-svg {
  width: 16px;
  height: 16px;
}

/* ── HEADINGS ────────────────────────────────────────── */
.footer-heading {
  font-size: 1rem;
  font-weight: 700;
  color: #ffffff;
  text-transform: uppercase;
  letter-spacing: 0.08em;
  margin: 0 0 0.5rem;
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

.heading-accent {
  display: inline-block;
  width: 4px;
  height: 18px;
  background-color: #0da487;
  border-radius: 2px;
  flex-shrink: 0;
}

/* ── QUICK LINKS ─────────────────────────────────────── */
.footer-links {
  list-style: none;
  padding: 0;
  margin: 0;
  display: flex;
  flex-direction: column;
  gap: 0.6rem;
}

.footer-links li a {
  text-decoration: none;
  color: #8a95a3;
  font-size: 0.9rem;
  transition: color 0.2s, padding-left 0.2s;
  display: flex;
  align-items: center;
  gap: 0.4rem;
}

.footer-links li a::before {
  content: "›";
  color: #0da487;
  font-weight: bold;
  font-size: 1rem;
  line-height: 1;
}

.footer-links li a:hover {
  color: #0da487;
  padding-left: 4px;
}

/* ── CONTACT ─────────────────────────────────────────── */
.contact-list {
  list-style: none;
  padding: 0;
  margin: 0;
  display: flex;
  flex-direction: column;
  gap: 0.9rem;
}

.contact-item {
  display: flex;
  align-items: flex-start;
  gap: 0.75rem;
  font-size: 0.875rem;
  color: #8a95a3;
  line-height: 1.5;
}

.contact-icon {
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
  width: 32px;
  height: 32px;
  border-radius: 50%;
  background-color: rgba(13, 164, 135, 0.15);
  color: #0da487;
  margin-top: 1px;
}

.contact-icon svg {
  width: 15px;
  height: 15px;
}

/* ── HOURS ───────────────────────────────────────────── */
.hours-list {
  list-style: none;
  padding: 0;
  margin: 0;
  display: flex;
  flex-direction: column;
  gap: 0.6rem;
}

.hours-item {
  display: flex;
  justify-content: space-between;
  align-items: center;
  font-size: 0.875rem;
  padding-bottom: 0.6rem;
  border-bottom: 1px solid rgba(255, 255, 255, 0.06);
}

.hours-item:last-child {
  border-bottom: none;
  padding-bottom: 0;
}

.hours-day {
  color: #8a95a3;
}

.hours-time {
  color: #0da487;
  font-weight: 600;
  font-size: 0.8rem;
}

.order-badge {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  background-color: rgba(13, 164, 135, 0.12);
  border: 1px solid rgba(13, 164, 135, 0.3);
  border-radius: 0.5rem;
  padding: 0.6rem 0.9rem;
  color: #0da487;
  font-size: 0.85rem;
  font-weight: 600;
  width: fit-content;
  margin-top: 0.25rem;
}

.order-icon {
  width: 16px;
  height: 16px;
  flex-shrink: 0;
}

/* ── BOTTOM BAR ──────────────────────────────────────── */
.footer-bottom {
  background-color: #161622;
  padding: 16px 0;
  color: #5a6373;
}

.footer-bottom-inner {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 0.75rem;
  text-align: center;
}

.copyright {
  font-size: 0.85rem;
  margin: 0;
}

.brand-highlight {
  color: #0da487;
  font-weight: 600;
}

.bottom-links {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  gap: 1rem;
}

.bottom-links a {
  text-decoration: none;
  color: #5a6373;
  font-size: 0.8rem;
  transition: color 0.2s;
}

.bottom-links a:hover {
  color: #0da487;
}

/* ── RESPONSIVE ──────────────────────────────────────── */
@media (min-width: 640px) {
  .footer-grid {
    grid-template-columns: repeat(2, 1fr);
  }
}

@media (min-width: 1024px) {
  .footer-grid {
    grid-template-columns: 1.4fr 1fr 1.2fr 1.2fr;
    gap: 3rem;
  }

  .footer-bottom-inner {
    flex-direction: row;
    justify-content: space-between;
    text-align: left;
  }
}

</style>
