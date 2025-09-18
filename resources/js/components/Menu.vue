<template>
  <header class="sr-only xl:not-sr-only">
    <div class="flex flex-wrap justify-between items-center xl:px-32 px-4 py-2">
      <router-link to="/">
        <img
          src="@/assets/logo.svg"
          class="object-contain self-center w-full"
          alt="Chefstore logo"
        />
      </router-link>
      <a
        href="https://www.chefstore.nl/"
        class="h-9 px-6 bg-[#e8761c] rounded-full flex justify-start items-center gap-2 min-w-60 font-bold text-white"
        target="_blank"
      >
        <img
          src="@/assets/Reply.svg"
          class="object-contain w-6 h-6"
          alt="reply"
        />
        <p>Terug naar Chefstore</p>
      </a>
    </div>
    <!-- kategoriler -->
    <div class="flex items-center px-32 w-full bg-[#4c84df] h-14">
      <nav class="flex gap-7 font-semibold text-white text-base">
        <a href="https://www.chefstore.nl/koelingen.html">Koelingen</a>
        <a href="https://www.chefstore.nl/apparatuur-1.html">Apparatuur</a>
        <a href="https://www.chefstore.nl/kooklijnen.html">Kooklijnen</a>
        <a href="https://www.chefstore.nl/rvs.html">RVS</a>
        <a href="https://www.chefstore.nl/bar-en-tafelgerei.html"
          >Bar- en Tafelgerei</a
        >
        <a href="https://www.chefstore.nl/keukengerei.html">Keukengerei</a>
        <a href="https://www.chefstore.nl/horeca-kleding.html">Werkkleding</a>
        <a href="https://www.chefstore.nl/disposables.html">Disposables</a>
        <a href="https://www.chefstore.nl/meubilair.html">Meubilair</a>
        <a href="https://www.chefstore.nl/hygiene.html">Hygiëne</a>
        <a href="https://www.chefstore.nl/onderdelen.html">Onderdelen</a>
        <a href="https://www.chefstore.nl/voor.html">Branches</a>
        <a href="https://www.chefstore.nl/promoties.html">SALE</a>
      </nav>
    </div>
  </header>
</template>
<script></script>
