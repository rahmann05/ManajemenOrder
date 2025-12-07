<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';

// Inisialisasi Form Inertia
const form = useForm({
    pengirim: '',
    alamat_pengirim: '',
    penerima: '',
    alamat_penerima: '',
    jenis_pengiriman: 'Reguler',
    total_berat: '',
    tanggal_order: new Date().toISOString().substr(0, 10),
});

const submit = () => {
    // Menggunakan URL manual sesuai perbaikan sebelumnya
    form.post('/admin/order');
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
                        <label class="text-xs font-bold uppercase tracking-widest text-gray-500">Nama Pengirim <span class="text-red-500">*</span></label>
                        <input 
                            v-model="form.pengirim" 
                            type="text" 
                            required 
                            class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-3 focus:border-brand-red focus:ring-1 focus:ring-brand-red outline-none transition" 
                            :class="{ 'border-red-500 bg-red-50': form.errors.pengirim }"
                            placeholder="PT. Sumber Makmur"
                        >
                        <div v-if="form.errors.pengirim" class="text-red-500 text-xs font-bold mt-1">{{ form.errors.pengirim }}</div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-bold uppercase tracking-widest text-gray-500">Tanggal Order <span class="text-red-500">*</span></label>
                        <input 
                            v-model="form.tanggal_order" 
                            type="date" 
                            required
                            class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-3 outline-none"
                            :class="{ 'border-red-500 bg-red-50': form.errors.tanggal_order }"
                        >
                        <div v-if="form.errors.tanggal_order" class="text-red-500 text-xs font-bold mt-1">{{ form.errors.tanggal_order }}</div>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-xs font-bold uppercase tracking-widest text-gray-500">Alamat Pengirim <span class="text-red-500">*</span></label>
                    <textarea 
                        v-model="form.alamat_pengirim" 
                        rows="2" 
                        required
                        class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-3 outline-none" 
                        :class="{ 'border-red-500 bg-red-50': form.errors.alamat_pengirim }"
                        placeholder="Jl. Raya Industri No. 12..."
                    ></textarea>
                    <div v-if="form.errors.alamat_pengirim" class="text-red-500 text-xs font-bold mt-1">{{ form.errors.alamat_pengirim }}</div>
                </div>

                <hr class="border-gray-100 my-6">

                <div class="space-y-2">
                    <label class="text-xs font-bold uppercase tracking-widest text-gray-500">Nama Penerima <span class="text-red-500">*</span></label>
                    <input 
                        v-model="form.penerima" 
                        type="text" 
                        required
                        class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-3 outline-none" 
                        :class="{ 'border-red-500 bg-red-50': form.errors.penerima }"
                        placeholder="Bpk. Santoso"
                    >
                    <div v-if="form.errors.penerima" class="text-red-500 text-xs font-bold mt-1">{{ form.errors.penerima }}</div>
                </div>

                <div class="space-y-2">
                    <label class="text-xs font-bold uppercase tracking-widest text-gray-500">Alamat Penerima <span class="text-red-500">*</span></label>
                    <textarea 
                        v-model="form.alamat_penerima" 
                        rows="3" 
                        required
                        class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-3 outline-none" 
                        :class="{ 'border-red-500 bg-red-50': form.errors.alamat_penerima }"
                        placeholder="Jl. Merdeka Selatan..."
                    ></textarea>
                    <div v-if="form.errors.alamat_penerima" class="text-red-500 text-xs font-bold mt-1">{{ form.errors.alamat_penerima }}</div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="text-xs font-bold uppercase tracking-widest text-gray-500">Jenis Layanan</label>
                        <select v-model="form.jenis_pengiriman" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-3 outline-none cursor-pointer">
                            <option value="Reguler">Reguler (3-4 Hari)</option>
                            <option value="Express">Express (1-2 Hari)</option>
                            <option value="Kargo">Kargo (Berat > 10kg)</option>
                        </select>
                    </div>
                    
                    <div class="space-y-2">
                        <label class="text-xs font-bold uppercase tracking-widest text-gray-500">Total Berat (kg) <span class="text-red-500">*</span></label>
                        <input 
                            v-model="form.total_berat" 
                            type="number" 
                            step="0.1" 
                            required
                            class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-3 outline-none" 
                            :class="{ 'border-red-500 bg-red-50': form.errors.total_berat }"
                            placeholder="0.0"
                        >
                        <div v-if="form.errors.total_berat" class="text-red-500 text-xs font-bold mt-1">{{ form.errors.total_berat }}</div>
                    </div>
                </div>

                <div class="flex justify-end gap-4 pt-4 border-t border-gray-100 mt-6">
                    <button 
                        type="button" 
                        @click="$inertia.visit('/dashboard/admin')" 
                        class="px-6 py-3 text-sm font-bold text-gray-500 hover:text-gray-800 transition"
                    >
                        Batal
                    </button>
                    
                    <button 
                        type="submit" 
                        :disabled="form.processing" 
                        class="btn-red px-8 py-3 rounded-xl text-sm shadow-xl flex items-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed"
                    >
                        <span v-if="form.processing" class="animate-spin h-4 w-4 border-2 border-white border-t-transparent rounded-full"></span>
                        {{ form.processing ? 'Menyimpan...' : 'Simpan Order' }}
                    </button>
                </div>

            </form>
        </div>
    </AppLayout>
</template>