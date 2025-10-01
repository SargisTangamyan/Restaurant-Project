<template>
  <div class="loader">
    <span></span>
    <span></span>
    <span></span>
  </div>
</template>

<script setup></script>

<style scoped>
.loader {
  width: 100vw;
  height: 100vh;
  display: flex;
  justify-content: center;
  align-items: center;
  background: #fff;
  position: fixed;
  top: 0;
  left: 0;
  z-index: 9999;
  gap: 10px;
}

.loader span {
  width: 15px;
  height: 15px;
  background-color: #0da487; /* your theme color */
  border-radius: 50%;
  display: inline-block;
  animation: bounce 1s infinite ease-in-out;
}

/* Stagger animation for each dot */
.loader span:nth-child(1) { animation-delay: 0s; }
.loader span:nth-child(2) { animation-delay: 0.2s; }
.loader span:nth-child(3) { animation-delay: 0.4s; }

/* Scale up and fade animation */
@keyframes bounce {
  0%, 80%, 100% {
    transform: scale(0);
    opacity: 0.3;
  }
  40% {
    transform: scale(1);
    opacity: 1;
  }
}
</style>
