<template>
    <header class="sr-only xl:not-sr-only">
        <div class="flex flex-wrap items-center justify-between px-4 py-2 xl:px-32">
            <a href="https://www.chefstore.nl/">
                <img :src="logo" class="w-full self-center object-contain" alt="Chefstore logo" />
            </a>
            <a
                href="https://www.chefstore.nl/"
                class="flex h-9 min-w-60 items-center justify-start gap-2 rounded-full bg-[#e8761c] px-6 font-bold text-white"
                target="_blank"
            >
                <img :src="Reply" class="h-6 w-6 object-contain" alt="reply" />
                <p>Terug naar Chefstore</p>
            </a>
        </div>
        <!-- kategoriler -->
        <div class="flex h-14 w-full items-center bg-[#4c84df] px-32">
            <nav class="flex gap-7 text-base font-semibold text-white">
                <a href="https://www.chefstore.nl/koelingen.html">Koelingen</a>
                <a href="https://www.chefstore.nl/apparatuur-1.html">Apparatuur</a>
                <a href="https://www.chefstore.nl/kooklijnen.html">Kooklijnen</a>
                <a href="https://www.chefstore.nl/rvs.html">RVS</a>
                <a href="https://www.chefstore.nl/bar-en-tafelgerei.html">Bar- en Tafelgerei</a>
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
<script setup lang="ts">
import Reply from '@/../assets/Reply.svg';
import logo from '@/../assets/logo.svg';
import { Link } from '@inertiajs/vue3';

</script>
