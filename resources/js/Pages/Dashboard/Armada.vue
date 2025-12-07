<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <AppLayout>
        <Head title="Dashboard Armada" />

        <div class="mb-8">
            <h1 class="text-3xl font-display font-bold text-brand-black">Operasional Armada</h1>
            <p class="text-gray-500 mt-1 font-medium">Pantau pergerakan unit dan pengiriman.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="bg-brand-red text-white p-8 rounded-2xl shadow-xl shadow-red-500/30 relative overflow-hidden">
                <div class="relative z-10">
                    <h3 class="text-lg font-bold font-display tracking-wide opacity-90">Order Siap Jalan</h3>
                    <div class="flex items-end gap-2 mt-4">
                        <span class="text-5xl font-black">50</span>
                        <span class="text-sm text-white/80 mb-1">Paket</span>
                    </div>
                    <button class="mt-6 bg-black/20 hover:bg-black/30 backdrop-blur-sm px-6 py-3 rounded-xl text-xs font-bold uppercase tracking-wider transition-all w-full text-left flex justify-between items-center group">
                        Atur Pengiriman
                        <span class="group-hover:translate-x-1 transition-transform">→</span>
                    </button>
                </div>
            </div>

            <div class="glass-panel p-8 rounded-2xl">
                <h3 class="text-lg font-bold font-display text-gray-500 tracking-wide">Sedang Mengirim</h3>
                <div class="flex items-end gap-2 mt-4">
                    <span class="text-5xl font-black text-brand-black">35</span>
                    <span class="text-sm text-gray-400 mb-1">Armada Aktif</span>
                </div>
            </div>
        </div>
    </AppLayout>
</template>