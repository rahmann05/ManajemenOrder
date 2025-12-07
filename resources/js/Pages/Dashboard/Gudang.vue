<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';

defineProps({
    // Nanti kita isi data ini dari controller
    stats: Object 
});
</script>

<template>
    <AppLayout>
        <Head title="Dashboard Gudang" />

        <div class="mb-8">
            <h1 class="text-3xl font-display font-bold text-brand-black">Area Gudang</h1>
            <p class="text-gray-500 mt-1 font-medium">Verifikasi kelengkapan barang dan dokumen.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="bg-brand-black text-white p-8 rounded-2xl shadow-xl relative overflow-hidden group">
                <div class="relative z-10">
                    <h3 class="text-lg font-bold font-display tracking-wide">Menunggu Verifikasi</h3>
                    <div class="flex items-end gap-2 mt-4">
                        <span class="text-5xl font-black">5</span>
                        <span class="text-sm text-gray-400 mb-1">Order</span>
                    </div>
                    <button class="mt-6 bg-white text-brand-black px-4 py-2 rounded-lg text-xs font-bold uppercase tracking-wider hover:bg-brand-red hover:text-white transition-colors">
                        Proses Sekarang →
                    </button>
                </div>
            </div>

            <div class="glass-panel p-8 rounded-2xl relative overflow-hidden">
                <div class="relative z-10">
                    <h3 class="text-lg font-bold font-display text-gray-500 tracking-wide">Sudah Diverifikasi</h3>
                    <div class="flex items-end gap-2 mt-4">
                        <span class="text-5xl font-black text-brand-black">25</span>
                        <span class="text-sm text-gray-400 mb-1">Order Hari Ini</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="glass-panel rounded-2xl overflow-hidden border border-gray-100">
            <div class="px-8 py-6 border-b border-gray-100 bg-white/50">
                <h3 class="font-bold text-lg font-display tracking-tight text-brand-red">Antrean Verifikasi</h3>
            </div>
            <div class="p-8 text-center text-gray-400 italic">
                (Data akan dimuat dari database nanti)
            </div>
        </div>
    </AppLayout>
</template>