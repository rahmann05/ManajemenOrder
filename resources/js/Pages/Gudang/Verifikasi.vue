<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';

const props = defineProps({ order: Object });

const form = useForm({ status: '', catatan: '' });

const submit = (statusKeputusan) => {
    if(!confirm('Apakah Anda yakin dengan keputusan ini?')) return;
    form.status = statusKeputusan;
    form.post(`/gudang/verifikasi/${props.order.id_order}`);
};
</script>

<template>
    <AppLayout>
        <Head title="Verifikasi Order" />

        <div class="mb-8">
            <h1 class="text-3xl font-display font-bold text-brand-black">Verifikasi Kargo</h1>
            <p class="text-gray-500 mt-1">Cek kelengkapan dokumen dan fisik sebelum validasi.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="glass-panel p-6 rounded-2xl h-fit">
                <h3 class="font-bold text-lg mb-4">Informasi Kargo</h3>
                <div class="space-y-4 text-sm">
                    <div><p class="text-xs text-gray-400 font-bold uppercase">No. Order</p><p class="font-mono text-lg font-bold">{{ order.nomor_order }}</p></div>
                    <div><p class="text-xs text-gray-400 font-bold uppercase">Pengirim</p><p>{{ order.pengirim }}</p></div>
                    <div><p class="text-xs text-gray-400 font-bold uppercase">Penerima</p><p>{{ order.penerima }}</p></div>
                    <div><p class="text-xs text-gray-400 font-bold uppercase">Spesifikasi</p><p>{{ order.jenis_muatan }} - {{ order.total_berat }} Ton</p></div>
                </div>
            </div>

            <div class="lg:col-span-2 space-y-6">
                <div class="glass-panel p-6 rounded-2xl">
                    <h3 class="font-bold text-lg mb-4">📑 Pemeriksaan Dokumen</h3>
                    <div class="space-y-3">
                        <div v-for="doc in order.dokumen" :key="doc.id_dokumen" class="flex items-center justify-between p-4 bg-gray-50 rounded-xl border border-gray-200">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center text-xl shadow-sm">📄</div>
                                <div>
                                    <p class="font-bold text-sm text-brand-black">{{ doc.jenis_dokumen }}</p>
                                    <a :href="`/storage/${doc.path_file}`" target="_blank" class="text-xs text-brand-red hover:underline">Lihat File</a>
                                </div>
                            </div>
                            <div class="flex gap-2">
                                <span class="text-xs bg-yellow-100 text-yellow-800 px-2 py-1 rounded">Perlu Cek</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="glass-panel p-6 rounded-2xl border-t-4 border-brand-red">
                    <h3 class="font-bold text-lg mb-4">Keputusan Verifikasi</h3>
                    <div class="mb-4">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Catatan Gudang (Opsional)</label>
                        <textarea v-model="form.catatan" class="w-full bg-gray-50 border border-gray-200 rounded-lg p-3 text-sm focus:ring-1 focus:ring-brand-red outline-none" rows="3" placeholder="Contoh: Dokumen lengkap, fisik aman."></textarea>
                    </div>
                    <div class="flex gap-4">
                        <button @click="submit('ditolak')" :disabled="form.processing" class="flex-1 py-3 bg-white border border-red-200 text-red-600 font-bold rounded-xl hover:bg-red-50 transition">⚠ Tolak Order</button>
                        <button @click="submit('terverifikasi')" :disabled="form.processing" class="flex-1 py-3 btn-red rounded-xl shadow-lg">✅ Validasi & Terima</button>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>