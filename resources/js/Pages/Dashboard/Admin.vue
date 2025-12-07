<script setup>
import { Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';

defineProps({
    stats: Object,
    recent_orders: Array,
});
</script>

<template>
    <AppLayout>
        
        <div class="mb-8 flex flex-col md:flex-row justify-between items-end gap-4">
            <div>
                <h1 class="text-3xl font-display font-bold text-brand-black">Dashboard Overview</h1>
                <p class="text-gray-500 mt-1 font-medium">Ringkasan aktivitas logistik hari ini.</p>
            </div>
            
            <div class="flex gap-3 items-center">
                <div class="hidden md:block text-xs font-bold text-gray-400 uppercase tracking-widest bg-gray-50 px-4 py-3 rounded-xl border border-gray-100">
                    {{ new Date().toLocaleDateString('id-ID', { weekday: 'long', day: 'numeric', month: 'long' }) }}
                </div>

                <Link href="/admin/order/create" class="btn-red px-6 py-3 rounded-xl flex items-center gap-2 text-sm shadow-lg shadow-red-500/30 group transition-all">
                    <span class="text-lg group-hover:rotate-90 transition-transform duration-300">+</span> 
                    Input Kargo
                </Link>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            
            <div class="glass-panel p-6 rounded-2xl relative overflow-hidden group hover:-translate-y-1 transition-transform duration-300">
                <div class="relative z-10">
                    <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400 font-display">Order Baru</p>
                    <p class="text-4xl font-black mt-2 text-brand-black">{{ stats.order_baru }}</p>
                </div>
                <div class="absolute right-0 bottom-0 opacity-5 group-hover:opacity-10 transition-opacity">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
                </div>
            </div>

            <div class="glass-panel p-6 rounded-2xl relative overflow-hidden group hover:-translate-y-1 transition-transform duration-300">
                <div class="relative z-10">
                    <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400 font-display">Selesai Hari Ini</p>
                    <p class="text-4xl font-black mt-2 text-brand-black">{{ stats.order_selesai_hari_ini }}</p>
                </div>
                <div class="absolute right-0 bottom-0 opacity-5 group-hover:opacity-10 transition-opacity">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                </div>
            </div>

            <div class="bg-brand-red text-white p-6 rounded-2xl shadow-xl shadow-red-500/30 relative overflow-hidden group hover:-translate-y-1 transition-transform duration-300">
                <div class="relative z-10">
                    <p class="text-[10px] font-bold uppercase tracking-widest text-white/60 font-display">Dalam Pengiriman</p>
                    <p class="text-4xl font-black mt-2">{{ stats.dalam_pengiriman }}</p>
                </div>
                <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-white/20 rounded-full blur-2xl animate-pulse"></div>
            </div>

            <div class="glass-panel p-6 rounded-2xl relative overflow-hidden group hover:-translate-y-1 transition-transform duration-300">
                <div class="relative z-10">
                    <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400 font-display">Total Order</p>
                    <p class="text-4xl font-black mt-2 text-brand-black">{{ stats.total_order }}</p>
                </div>
            </div>
        </div>

        <div class="glass-panel rounded-2xl overflow-hidden border border-gray-100">
            <div class="px-8 py-6 border-b border-gray-100 flex justify-between items-center bg-white/50">
                <h3 class="font-bold text-lg font-display tracking-tight">Order Terbaru</h3>
                <button class="text-xs font-bold uppercase tracking-wider text-brand-red hover:text-brand-black transition-colors">Lihat Semua →</button>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-600">
                    <thead class="bg-gray-50/50 text-[10px] uppercase font-bold text-gray-400 tracking-wider font-display">
                        <tr>
                            <th class="px-8 py-4">No. Order</th>
                            <th class="px-8 py-4">Pengirim</th>
                            <th class="px-8 py-4">Penerima</th>
                            <th class="px-8 py-4">Kargo</th>
                            <th class="px-8 py-4">Status</th>
                            <th class="px-8 py-4">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        <tr v-for="order in recent_orders" :key="order.id_order" class="hover:bg-red-50/50 transition duration-200">
                            
                            <td class="px-8 py-4 font-bold text-brand-black">
                                <Link :href="`/admin/order/${order.id_order}`" class="hover:text-brand-red hover:underline decoration-dashed underline-offset-4 transition-colors">
                                    {{ order.nomor_order || '#' + order.id_order }}
                                </Link>
                            </td>

                            <td class="px-8 py-4 font-medium">
                                <div class="truncate max-w-[150px]" :title="order.pengirim">{{ order.pengirim }}</div>
                                <div class="text-xs text-gray-400 truncate max-w-[150px]">{{ order.alamat_pengirim }}</div>
                            </td>
                            <td class="px-8 py-4 font-medium">
                                <div class="truncate max-w-[150px]" :title="order.penerima">{{ order.penerima }}</div>
                                <div class="text-xs text-gray-400 truncate max-w-[150px]">{{ order.alamat_penerima }}</div>
                            </td>
                            <td class="px-8 py-4">
                                <div class="flex flex-col gap-1">
                                    <span class="inline-block px-2 py-0.5 bg-white border border-gray-200 rounded text-[10px] font-bold uppercase tracking-wide w-fit">
                                        {{ order.jalur_pengiriman }}
                                    </span>
                                    <span class="text-xs text-gray-500">{{ order.jenis_muatan }}</span>
                                </div>
                            </td>
                            <td class="px-8 py-4">
                                <span 
                                    class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wide border"
                                    :class="{
                                        'bg-yellow-50 text-yellow-700 border-yellow-200': order.status_order === 'menunggu_verifikasi' || order.status_order === 'menunggu_validasi_dokumen',
                                        'bg-blue-50 text-blue-700 border-blue-200': order.status_order === 'proses',
                                        'bg-green-50 text-green-700 border-green-200': order.status_order === 'selesai',
                                    }"
                                >
                                    <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                                    {{ order.status_order ? order.status_order.replace(/_/g, ' ') : 'Pending' }}
                                </span>
                            </td>
                            <td class="px-8 py-4 text-gray-400 font-medium whitespace-nowrap">{{ order.tanggal_order }}</td>
                        </tr>
                        <tr v-if="recent_orders.length === 0">
                            <td colspan="6" class="px-8 py-12 text-center text-gray-400 italic bg-gray-50/30">
                                <div class="flex flex-col items-center justify-center gap-2">
                                    <span class="text-2xl">📦</span>
                                    <span>Belum ada data kargo yang masuk.</span>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </AppLayout>
</template>