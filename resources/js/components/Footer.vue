<template>
  <footer
    class="px-4 flex flex-col items-center py-12 text-base text-center bg-[#4c84df]/10"
  >
    <div
      class="flex flex-col max-w-full italic font-semibold text-blue-500 w-[180px]"
    >
      <img
        :src="logo"
        class="object-contain self-center w-full"
        alt="Chefstore logo"
      />
      <h2 class="text-[#4c84df] sm:text-xs xl:text-lg font-semibold">
        Álles voor de Chef
      </h2>
    </div>
    <div class="mt-4 text-[#204050] xl:text-lg text-xs">
      <p>
        Groothandel voor professionele horeca-artikelen. Wij zijn horeca-experts
        voor horeca-professionals en enthousiaste thuis-chefs.<br />
        Bij Chefstore.nl bestel je premium keukenapparatuur en non-food
        producten voor de horeca branche, waaronder keukens,<br />
        cafetaria's, snackbars, kwalitaria's, cateraars en hotels. Vraag een
        offerte aan voor nóg betere deals.
      </p>

      <p class="mt-4">
        © 2017 - 2025 Chefstore.nl | Amsterdam, Nederland | KvK: 69637717
      </p>
    </div>
  </footer>
</template>

<script setup lang="ts">
import logo from '@/../assets/logo.svg';
</script>
