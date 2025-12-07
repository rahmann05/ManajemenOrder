<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';

// Inisialisasi Form Inertia
const form = useForm({
    pengirim: '',
    alamat_pengirim: '',
    penerima: '',
    alamat_penerima: '',
    jenis_pengiriman: 'Reguler', // Default
    total_berat: '',
    tanggal_order: new Date().toISOString().substr(0, 10), // Default hari ini
});

const submit = () => {
    form.post(route('order.store'));
};
</script>

<template>
    <AppLayout>
        <Head title="Input Order Baru" />

        <div class="mb-8">
            <h1 class="text-3xl font-display font-bold text-brand-black">Input Order Baru</h1>
            <p class="text-gray-500 mt-1 font-medium">Isi detail pengiriman dengan lengkap.</p>
        </div>

        <div class="glass-panel p-8 rounded-2xl max-w-4xl">
            <form @submit.prevent="submit" class="space-y-6">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="text-xs font-bold uppercase tracking-widest text-gray-500">Nama Pengirim</label>
                        <input v-model="form.pengirim" type="text" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-3 focus:border-brand-red focus:ring-1 focus:ring-brand-red outline-none transition" placeholder="PT. Sumber Makmur">
                        <div v-if="form.errors.pengirim" class="text-red-500 text-xs">{{ form.errors.pengirim }}</div>
                    </div>
                    <div class="space-y-2">
                        <label class="text-xs font-bold uppercase tracking-widest text-gray-500">Tanggal Order</label>
                        <input v-model="form.tanggal_order" type="date" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-3 outline-none">
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-xs font-bold uppercase tracking-widest text-gray-500">Alamat Pengirim</label>
                    <textarea v-model="form.alamat_pengirim" rows="2" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-3 outline-none" placeholder="Jl. Raya Industri No. 12..."></textarea>
                </div>

                <hr class="border-gray-100 my-6">

                <div class="space-y-2">
                    <label class="text-xs font-bold uppercase tracking-widest text-gray-500">Nama Penerima</label>
                    <input v-model="form.penerima" type="text" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-3 outline-none" placeholder="Bpk. Santoso">
                </div>

                <div class="space-y-2">
                    <label class="text-xs font-bold uppercase tracking-widest text-gray-500">Alamat Penerima</label>
                    <textarea v-model="form.alamat_penerima" rows="3" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-3 outline-none" placeholder="Jl. Merdeka Selatan..."></textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="text-xs font-bold uppercase tracking-widest text-gray-500">Jenis Layanan</label>
                        <select v-model="form.jenis_pengiriman" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-3 outline-none">
                            <option value="Reguler">Reguler (3-4 Hari)</option>
                            <option value="Express">Express (1-2 Hari)</option>
                            <option value="Kargo">Kargo (Berat > 10kg)</option>
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label class="text-xs font-bold uppercase tracking-widest text-gray-500">Total Berat (kg)</label>
                        <input v-model="form.total_berat" type="number" step="0.1" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-3 outline-none" placeholder="0.0">
                    </div>
                </div>

                <div class="flex justify-end gap-4 pt-4">
                    <button type="button" @click="$inertia.visit(route('admin.dashboard'))" class="px-6 py-3 text-sm font-bold text-gray-500 hover:text-gray-800 transition">
                        Batal
                    </button>
                    <button type="submit" :disabled="form.processing" class="btn-red px-8 py-3 rounded-xl text-sm shadow-xl">
                        {{ form.processing ? 'Menyimpan...' : 'Simpan Order' }}
                    </button>
                </div>

            </form>
        </div>
    </AppLayout>
</template>