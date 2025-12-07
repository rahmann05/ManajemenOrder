<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <AppLayout>
        <Head title="Dashboard Manajer" />

        <div class="mb-8 flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-display font-bold text-brand-black">Executive Summary</h1>
                <p class="text-gray-500 mt-1 font-medium">Laporan kinerja operasional.</p>
            </div>
            <button class="btn-red px-6 py-3 rounded-lg text-xs shadow-none">
                Download Report ↓
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="glass-panel p-6 rounded-2xl border-l-4 border-brand-black">
                <p class="text-xs font-bold uppercase text-gray-400 tracking-widest mb-2">Total Selesai</p>
                <p class="text-4xl font-black text-brand-black">50</p>
            </div>
            <div class="glass-panel p-6 rounded-2xl border-l-4 border-brand-red">
                <p class="text-xs font-bold uppercase text-gray-400 tracking-widest mb-2">Rata-rata Waktu</p>
                <p class="text-4xl font-black text-brand-black">2 <span class="text-lg text-gray-400 font-medium">Hari</span></p>
            </div>
            <div class="glass-panel p-6 rounded-2xl border-l-4 border-yellow-400">
                <p class="text-xs font-bold uppercase text-gray-400 tracking-widest mb-2">Kendala / Retur</p>
                <p class="text-4xl font-black text-brand-black">5</p>
            </div>
        </div>
    </AppLayout>
</template>