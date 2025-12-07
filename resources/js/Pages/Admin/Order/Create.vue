<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import MapPicker from '@/Components/MapPicker.vue'; // Import komponen peta
import { ref } from 'vue';

// State untuk menyimpan daftar dokumen sementara
const dokumenList = ref([{ jenis: '', file: null }]);

const form = useForm({
    jalur_pengiriman: 'Laut',
    jenis_muatan: '',
    
    // Data Pengirim (Origin)
    pengirim: '',
    alamat_pengirim: '',
    origin_lat: null,
    origin_lng: null,

    // Data Penerima (Destination)
    penerima: '',
    alamat_penerima: '',
    destination_lat: null,
    destination_lng: null,

    total_berat: '',
    total_volume: '',
    tanggal_order: new Date().toISOString().substr(0, 10),
    
    // Array Dokumen yang akan dikirim ke server
    dokumen: [], 
});

// Helper untuk tambah baris dokumen
const addDokumenRow = () => {
    dokumenList.value.push({ jenis: '', file: null });
};

// Helper untuk hapus baris dokumen
const removeDokumenRow = (index) => {
    dokumenList.value.splice(index, 1);
};

// Handle file input
const handleFileUpload = (event, index) => {
    dokumenList.value[index].file = event.target.files[0];
};

const submit = () => {
    // 1. Mapping Eksplisit: Pastikan 'file' benar-benar diambil
    form.dokumen = dokumenList.value.map((item, index) => {
        // Debugging: Cek di console apakah file ada
        if (!item.file) console.warn(`Dokumen baris ke-${index+1} tidak memiliki file!`);
        
        return {
            jenis: item.jenis,
            file: item.file // Harus berupa File object (bukan null)
        };
    });

    // 2. Kirim dengan forceFormData
    form.post('/admin/order', {
        forceFormData: true, // Wajib untuk upload file
        onSuccess: () => console.log("Berhasil disimpan!"),
        onError: (errors) => console.error("Gagal Validasi:", errors),
    });
};
</script>

<template>
    <AppLayout>
        <Head title="Input Kargo Baru" />

        <div class="mb-8">
            <h1 class="text-3xl font-display font-bold text-brand-black">Input Kargo</h1>
            <p class="text-gray-500 mt-1 font-medium">Lengkapi data muatan, peta lokasi, dan dokumen legalitas.</p>
        </div>

        <div class="glass-panel p-8 rounded-2xl max-w-6xl">
            <form @submit.prevent="submit" class="space-y-8">
              <div v-if="Object.keys(form.errors).length > 0" class="bg-red-50 border-l-4 border-red-500 p-4 mb-6">
    <div class="flex">
        <div class="flex-shrink-0">
            <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
            </svg>
        </div>
        <div class="ml-3">
            <h3 class="text-sm leading-5 font-medium text-red-800">
                Terdapat {{ Object.keys(form.errors).length }} error pada form:
            </h3>
            <div class="mt-2 text-sm leading-5 text-red-700">
                <ul class="list-disc pl-5 space-y-1">
                    <li v-for="(error, key) in form.errors" :key="key">
                        <span class="font-bold">{{ key }}:</span> {{ error }}
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
                <div>
                    <h3 class="text-lg font-bold text-brand-red mb-4 flex items-center gap-2">
                        <span class="w-6 h-6 rounded-full bg-brand-red text-white flex items-center justify-center text-xs">1</span>
                        Rute & Lokasi
                    </h3>
                    
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <div class="space-y-4 border p-4 rounded-xl bg-gray-50/50">
                            <h4 class="font-bold text-gray-800 border-b pb-2">📍 Lokasi Asal (Origin)</h4>
                            <div class="space-y-2">
                                <label class="text-xs font-bold uppercase text-gray-500">Pengirim</label>
                                <input v-model="form.pengirim" type="text" class="w-full bg-white border border-gray-200 rounded-lg px-3 py-2 outline-none">
                            </div>
                            
                            <MapPicker 
                                label="Titik Muat (Pin Point)" 
                                @update:lat="(val) => form.origin_lat = val"
                                @update:lng="(val) => form.origin_lng = val"
                                @update:address="(val) => form.alamat_pengirim = val"
                            />

                            <div class="space-y-2">
                                <label class="text-xs font-bold uppercase text-gray-500">Alamat Lengkap (Auto-fill)</label>
                                <textarea v-model="form.alamat_pengirim" rows="3" class="w-full bg-white border border-gray-200 rounded-lg px-3 py-2 outline-none text-sm"></textarea>
                            </div>
                        </div>

                        <div class="space-y-4 border p-4 rounded-xl bg-gray-50/50">
                            <h4 class="font-bold text-gray-800 border-b pb-2">🏁 Lokasi Tujuan (Destination)</h4>
                            <div class="space-y-2">
                                <label class="text-xs font-bold uppercase text-gray-500">Penerima</label>
                                <input v-model="form.penerima" type="text" class="w-full bg-white border border-gray-200 rounded-lg px-3 py-2 outline-none">
                            </div>

                            <MapPicker 
                                label="Titik Bongkar (Pin Point)" 
                                @update:lat="(val) => form.destination_lat = val"
                                @update:lng="(val) => form.destination_lng = val"
                                @update:address="(val) => form.alamat_penerima = val"
                            />

                            <div class="space-y-2">
                                <label class="text-xs font-bold uppercase text-gray-500">Alamat Lengkap (Auto-fill)</label>
                                <textarea v-model="form.alamat_penerima" rows="3" class="w-full bg-white border border-gray-200 rounded-lg px-3 py-2 outline-none text-sm"></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="border-gray-100">

                <div>
                    <h3 class="text-lg font-bold text-brand-red mb-4 flex items-center gap-2">
                        <span class="w-6 h-6 rounded-full bg-brand-red text-white flex items-center justify-center text-xs">2</span>
                        Spesifikasi Kargo
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div class="space-y-2">
                            <label class="text-xs font-bold uppercase text-gray-500">Jalur</label>
                            <select v-model="form.jalur_pengiriman" class="w-full bg-white border border-gray-200 rounded-lg px-3 py-2 outline-none">
                                <option value="Laut">Laut</option>
                                <option value="Udara">Udara</option>
                            </select>
                        </div>
                        <div class="space-y-2">
                            <label class="text-xs font-bold uppercase text-gray-500">Jenis Muatan</label>
                            <select v-model="form.jenis_muatan" class="w-full bg-white border border-gray-200 rounded-lg px-3 py-2 outline-none">
                                <option value="FCL 20ft">FCL 20ft</option>
                                <option value="FCL 40ft">FCL 40ft</option>
                                <option value="LCL">LCL</option>
                                <option value="Breakbulk">Breakbulk</option>
                                <option value="Heavy Equipment">Alat Berat</option>
                            </select>
                        </div>
                        <div class="space-y-2">
                            <label class="text-xs font-bold uppercase text-gray-500">Berat (Ton)</label>
                            <input v-model="form.total_berat" type="number" step="0.01" class="w-full bg-white border border-gray-200 rounded-lg px-3 py-2 outline-none">
                        </div>
                        <div class="space-y-2">
                            <label class="text-xs font-bold uppercase text-gray-500">Volume</label>
                            <input v-model="form.total_volume" type="number" step="0.01" class="w-full bg-white border border-gray-200 rounded-lg px-3 py-2 outline-none">
                        </div>
                    </div>
                </div>

                <hr class="border-gray-100">

                <div>
                    <h3 class="text-lg font-bold text-brand-red mb-4 flex items-center gap-2">
                        <span class="w-6 h-6 rounded-full bg-brand-red text-white flex items-center justify-center text-xs">3</span>
                        Kelengkapan Dokumen (Multi-File)
                    </h3>
                    
                    <div class="space-y-3">
                        <div v-for="(doc, index) in dokumenList" :key="index" class="flex gap-4 items-start bg-gray-50 p-3 rounded-lg border border-gray-200">
                            <div class="flex-1 space-y-1">
                                <label class="text-[10px] font-bold uppercase text-gray-400">Jenis Dokumen</label>
                                <select v-model="doc.jenis" class="w-full bg-white border border-gray-200 rounded text-sm px-2 py-1" required>
                                    <option value="" disabled>-- Pilih --</option>
                                    <option value="Bill of Lading (B/L)">Bill of Lading (B/L)</option>
                                    <option value="Manifest">Manifest</option>
                                    <option value="Commercial Invoice">Commercial Invoice</option>
                                    <option value="Packing List">Packing List</option>
                                    <option value="PIB">Pemberitahuan Impor Barang</option>
                                    <option value="Surat Jalan">Surat Jalan</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                            </div>
                            <div class="flex-1 space-y-1">
                                <label class="text-[10px] font-bold uppercase text-gray-400">Upload File</label>
                                <input type="file" @change="handleFileUpload($event, index)" required class="block w-full text-xs text-gray-500 file:mr-2 file:py-1 file:px-2 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-black file:text-white hover:file:bg-gray-700">
                            </div>
                            <div class="pt-5">
                                <button type="button" @click="removeDokumenRow(index)" class="text-red-500 hover:text-red-700 font-bold px-2">✕</button>
                            </div>
                        </div>
                    </div>

                    <button type="button" @click="addDokumenRow" class="mt-4 text-xs font-bold text-brand-red hover:text-brand-black flex items-center gap-1 transition">
                        <span class="text-lg">+</span> Tambah Dokumen Lain
                    </button>
                </div>

                <div class="flex justify-end gap-4 pt-6 border-t border-gray-200">
                    <button type="button" @click="$inertia.visit('/dashboard/admin')" class="px-6 py-3 text-sm font-bold text-gray-500 hover:text-gray-800 transition">Batal</button>
                    <button type="submit" :disabled="form.processing" class="btn-red px-8 py-3 rounded-xl text-sm shadow-xl flex items-center gap-2">
                        <span v-if="form.processing" class="animate-spin h-4 w-4 border-2 border-white border-t-transparent rounded-full"></span>
                        {{ form.processing ? 'Menyimpan...' : 'Simpan Kargo & Dokumen' }}
                    </button>
                </div>

            </form>
        </div>
    </AppLayout>
</template>