<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    antrean: Array,
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
            <div class="bg-brand-black text-white p-8 rounded-2xl shadow-xl relative overflow-hidden">
                <div class="relative z-10">
                    <h3 class="text-lg font-bold font-display tracking-wide">Menunggu Verifikasi</h3>
                    <div class="flex items-end gap-2 mt-4">
                        <span class="text-5xl font-black">{{ stats.menunggu }}</span>
                        <span class="text-sm text-gray-400 mb-1">Order</span>
                    </div>
                </div>
            </div>
            
            <div class="glass-panel p-8 rounded-2xl">
                <h3 class="text-lg font-bold font-display text-gray-500 tracking-wide">Selesai Hari Ini</h3>
                <div class="flex items-end gap-2 mt-4">
                    <span class="text-5xl font-black text-brand-black">{{ stats.selesai_hari_ini }}</span>
                    <span class="text-sm text-gray-400 mb-1">Order</span>
                </div>
            </div>
        </div>

        <div class="glass-panel rounded-2xl overflow-hidden border border-gray-100">
            <div class="px-8 py-6 border-b border-gray-100 bg-white/50">
                <h3 class="font-bold text-lg font-display tracking-tight text-brand-red">Antrean Verifikasi Masuk</h3>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-600">
                    <thead class="bg-gray-50/50 text-[10px] uppercase font-bold text-gray-400 tracking-wider">
                        <tr>
                            <th class="px-8 py-4">No. Order</th>
                            <th class="px-8 py-4">Kargo</th>
                            <th class="px-8 py-4">Pengirim</th>
                            <th class="px-8 py-4">Tanggal</th>
                            <th class="px-8 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        <tr v-for="order in antrean" :key="order.id_order" class="hover:bg-red-50/50 transition">
                            <td class="px-8 py-4 font-bold text-brand-black">{{ order.nomor_order }}</td>
                            <td class="px-8 py-4">
                                <div class="font-bold">{{ order.jenis_muatan }}</div>
                                <div class="text-xs text-gray-400">{{ order.total_berat }} Ton</div>
                            </td>
                            <td class="px-8 py-4">{{ order.pengirim }}</td>
                            <td class="px-8 py-4">{{ order.tanggal_order }}</td>
                            <td class="px-8 py-4 text-right">
                                <Link :href="`/gudang/verifikasi/${order.id_order}`" class="btn-red px-4 py-2 rounded-lg text-xs shadow-md inline-block">
                                    Periksa →
                                </Link>
                            </td>
                        </tr>
                        <tr v-if="antrean.length === 0">
                            <td colspan="5" class="px-8 py-12 text-center text-gray-400 italic">
                                Tidak ada antrean order saat ini.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AppLayout>
</template>