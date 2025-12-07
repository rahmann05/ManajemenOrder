<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import MapViewer from '@/Components/MapViewer.vue';
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps({
    order: Object
});

const formatCurrency = (value) => {
    return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(value);
};

const formatDate = (dateString) => {
    return new Date(dateString).toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
};
</script>

<template>
    <AppLayout>
        <Head :title="`Detail Order #${order.nomor_order}`" />

        <div class="mb-8 flex justify-between items-center">
            <div>
                <div class="flex items-center gap-2 text-sm text-gray-500 mb-1">
                    <Link href="/dashboard/admin" class="hover:text-brand-red">Dashboard</Link>
                    <span>/</span>
                    <span>Tracking</span>
                </div>
                <h1 class="text-3xl font-display font-bold text-brand-black">Order #{{ order.nomor_order }}</h1>
            </div>
            
            <div class="flex gap-2">
                <span class="px-4 py-2 rounded-lg font-bold text-sm bg-yellow-100 text-yellow-700 border border-yellow-200 uppercase tracking-wide">
                    {{ order.status_order.replace(/_/g, ' ') }}
                </span>
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
            
            <div class="xl:col-span-2 space-y-8">
                
                <div class="glass-panel p-6 rounded-2xl">
                    <h3 class="font-bold text-lg mb-4 flex items-center gap-2">
                        🗺️ Peta Rute & Posisi Kargo
                    </h3>
                    <MapViewer 
                        :origin="{ lat: order.origin_lat, lng: order.origin_lng }"
                        :destination="{ lat: order.destination_lat, lng: order.destination_lng }"
                        :current="{ lat: order.current_lat, lng: order.current_lng }"
                    />
                    <div class="mt-4 flex gap-6 text-sm">
                        <div>
                            <p class="text-xs text-gray-400 uppercase font-bold">Posisi Sekarang</p>
                            <p class="font-medium text-brand-black">{{ order.posisi_sekarang }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 uppercase font-bold">Estimasi Sampai</p>
                            <p class="font-medium text-brand-black">-</p>
                        </div>
                    </div>
                </div>

                <div class="glass-panel p-6 rounded-2xl">
                    <h3 class="font-bold text-lg mb-6 border-b pb-2">📦 Informasi Kargo</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                        <div>
                            <p class="text-xs text-gray-400 uppercase font-bold mb-1">Jalur</p>
                            <p class="font-bold text-brand-black">{{ order.jalur_pengiriman }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 uppercase font-bold mb-1">Jenis Muatan</p>
                            <p class="font-bold text-brand-black">{{ order.jenis_muatan }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 uppercase font-bold mb-1">Berat Total</p>
                            <p class="font-bold text-brand-black">{{ order.total_berat }} Kg</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 uppercase font-bold mb-1">Volume</p>
                            <p class="font-bold text-brand-black">{{ order.total_volume || '-' }} m³</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-8">
                        <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                            <p class="text-xs font-bold text-brand-red uppercase mb-2">📍 Pengirim (Shipper)</p>
                            <p class="font-bold text-gray-900">{{ order.pengirim }}</p>
                            <p class="text-sm text-gray-500 mt-1">{{ order.alamat_pengirim }}</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                            <p class="text-xs font-bold text-brand-red uppercase mb-2">🏁 Penerima (Consignee)</p>
                            <p class="font-bold text-gray-900">{{ order.penerima }}</p>
                            <p class="text-sm text-gray-500 mt-1">{{ order.alamat_penerima }}</p>
                        </div>
                    </div>
                </div>

            </div>

            <div class="space-y-8">
                <div class="glass-panel p-6 rounded-2xl border-t-4 border-brand-red">
                    <h3 class="font-bold text-lg mb-4 flex items-center justify-between">
                        <span>📑 Dokumen Legalitas</span>
                        <span class="bg-gray-100 text-xs px-2 py-1 rounded-full text-gray-600">{{ order.dokumen.length }} File</span>
                    </h3>
                    
                    <div class="space-y-3">
                        <div v-for="doc in order.dokumen" :key="doc.id" class="flex items-center gap-3 p-3 bg-white border border-gray-100 rounded-xl hover:shadow-md transition group">
                            <div class="w-10 h-10 bg-red-50 rounded-lg flex items-center justify-center text-brand-red font-bold text-xs shrink-0">
                                DOC
                            </div>
                            
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-bold text-gray-800 truncate" :title="doc.jenis_dokumen">{{ doc.jenis_dokumen }}</p>
                                <p class="text-[10px] text-gray-400 uppercase tracking-wider">{{ doc.status }}</p>
                            </div>

                            <a :href="`/storage/${doc.path_file}`" target="_blank" class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 hover:bg-brand-black hover:text-white transition">
                                ⬇
                            </a>
                        </div>
                    </div>

                    <div class="mt-6 pt-4 border-t border-dashed border-gray-200">
                        <p class="text-xs text-gray-400 mb-2">Catatan Verifikasi Gudang:</p>
                        <p class="text-sm text-gray-600 italic">"{{ order.dokumen[0]?.catatan_verifikasi || 'Belum ada verifikasi.' }}"</p>
                    </div>
                </div>
                
                <div class="glass-panel p-6 rounded-2xl">
                    <h3 class="font-bold text-lg mb-4">⏱️ Timeline Logistik</h3>
                    <div class="relative border-l-2 border-gray-200 ml-3 space-y-6 pl-6 pb-2">
                        <div class="relative">
                            <span class="absolute -left-[31px] top-0 w-4 h-4 bg-brand-red rounded-full ring-4 ring-white"></span>
                            <p class="text-xs text-gray-400">{{ formatDate(order.created_at) }}</p>
                            <p class="font-bold text-sm">Order Dibuat</p>
                        </div>
                        </div>
                </div>
            </div>

        </div>
    </AppLayout>
</template>