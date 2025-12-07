<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import MapPicker from '@/Components/MapPicker.vue';
import { ref, watch } from 'vue';

// State untuk daftar dokumen di UI
const dokumenList = ref([{ jenis: '', file: null }]);

const form = useForm({
    // jalur_pengiriman dihapus dari object form karena sudah default di backend
    jenis_muatan: '',
    
    // Origin
    pengirim: '',
    alamat_pengirim: '', 
    origin_lat: null,
    origin_lng: null,

    // Destination
    penerima: '',
    alamat_penerima: '', 
    destination_lat: null,
    destination_lng: null,

    // Fisik
    total_berat: '',  // User input (TON)
    total_volume: '', // Auto calculate (CBM)
    
    tanggal_order: new Date().toISOString().substr(0, 10),
    dokumen: [], 
});

// --- LOGIKA KALKULASI VOLUME OTOMATIS ---
watch(
    [() => form.jenis_muatan, () => form.total_berat], 
    ([jenis, berat]) => {
        if (!jenis) return;
        const beratTon = parseFloat(berat) || 0;
        let estimasi = 0;

        // Rumus Kasar Logistik Laut (Freight Ton Approximation)
        switch (jenis) {
            case 'FCL 20ft':
                estimasi = 33.2; // Volume Container 20ft Standard
                break;
            case 'FCL 40ft':
                estimasi = 67.7; // Volume Container 40ft Standard
                break;
            case 'LCL':
                estimasi = beratTon * 1.0; // 1 Ton ~ 1 CBM
                break;
            case 'Breakbulk':
                estimasi = beratTon * 1.2; // Faktor muat curah (lebih boros tempat)
                break;
            case 'Heavy Equipment':
                estimasi = beratTon * 1.5; // Alat berat dimensinya biasanya lebih besar dari beratnya
                break;
            default:
                estimasi = beratTon;
        }

        // Masukkan hasil ke form (2 desimal), tapi biarkan user mengedit jika perlu
        if(estimasi > 0) {
            form.total_volume = parseFloat(estimasi.toFixed(2));
        }
    }
);

// --- HELPER DOKUMEN ---
const addDokumenRow = () => {
    dokumenList.value.push({ jenis: '', file: null });
};

const removeDokumenRow = (index) => {
    dokumenList.value.splice(index, 1);
};

const handleFileUpload = (event, index) => {
    dokumenList.value[index].file = event.target.files[0];
};

// --- SUBMIT ---
const submit = () => {
    // Pindahkan data dari state UI ke form Inertia
    form.dokumen = dokumenList.value.map(doc => ({
        jenis: doc.jenis,
        file: doc.file
    }));

    form.post('/admin/order', {
        forceFormData: true, // Wajib untuk upload file
    });
};
</script>

<template>
    <AppLayout>
        <Head title="Input Kargo Laut" />

        <div class="mb-8">
            <h1 class="text-3xl font-display font-bold text-brand-black">Input Kargo Laut</h1>
            <p class="text-gray-500 mt-1 font-medium">Pengiriman via Laut (Default). Isi data muatan dan dokumen.</p>
        </div>

        <div class="glass-panel p-8 rounded-2xl max-w-6xl">
            <form @submit.prevent="submit" class="space-y-8">
                
                <div v-if="Object.keys(form.errors).length > 0" class="bg-red-50 border-l-4 border-red-500 p-4 mb-6">
                    <div class="flex">
                        <div class="ml-3">
                            <h3 class="text-sm leading-5 font-medium text-red-800">
                                Terdapat error pada form:
                            </h3>
                            <ul class="list-disc pl-5 mt-2 text-sm text-red-700">
                                <li v-for="(error, key) in form.errors" :key="key">
                                    {{ error }}
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-bold text-brand-red mb-4 flex items-center gap-2">
                        <span class="w-6 h-6 rounded-full bg-brand-red text-white flex items-center justify-center text-xs">1</span>
                        Rute & Lokasi (Geo-Tagging)
                    </h3>
                    
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <div class="space-y-4 border p-4 rounded-xl bg-gray-50/50">
                            <h4 class="font-bold text-gray-800 border-b pb-2">📍 Pelabuhan Muat (POL) / Asal</h4>
                            <div class="space-y-2">
                                <label class="text-xs font-bold uppercase text-gray-500">Shipper / Pengirim</label>
                                <input v-model="form.pengirim" type="text" class="w-full bg-white border border-gray-200 rounded-lg px-3 py-2 outline-none">
                            </div>
                            
                            <MapPicker 
                                label="Titik Muat (Pin Point)" 
                                @update:lat="(val) => form.origin_lat = val"
                                @update:lng="(val) => form.origin_lng = val"
                                @update:address="(val) => form.alamat_pengirim = val"
                            />

                            <div class="space-y-2">
                                <label class="text-xs font-bold uppercase text-gray-500">Alamat Lengkap</label>
                                <textarea v-model="form.alamat_pengirim" rows="2" class="w-full bg-white border border-gray-200 rounded-lg px-3 py-2 outline-none text-sm"></textarea>
                            </div>
                        </div>

                        <div class="space-y-4 border p-4 rounded-xl bg-gray-50/50">
                            <h4 class="font-bold text-gray-800 border-b pb-2">🏁 Pelabuhan Bongkar (POD) / Tujuan</h4>
                            <div class="space-y-2">
                                <label class="text-xs font-bold uppercase text-gray-500">Consignee / Penerima</label>
                                <input v-model="form.penerima" type="text" class="w-full bg-white border border-gray-200 rounded-lg px-3 py-2 outline-none">
                            </div>

                            <MapPicker 
                                label="Titik Bongkar (Pin Point)" 
                                @update:lat="(val) => form.destination_lat = val"
                                @update:lng="(val) => form.destination_lng = val"
                                @update:address="(val) => form.alamat_penerima = val"
                            />

                            <div class="space-y-2">
                                <label class="text-xs font-bold uppercase text-gray-500">Alamat Lengkap</label>
                                <textarea v-model="form.alamat_penerima" rows="2" class="w-full bg-white border border-gray-200 rounded-lg px-3 py-2 outline-none text-sm"></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="border-gray-100">

                <div class="bg-blue-50 p-6 rounded-xl border border-blue-100">
                    <h3 class="text-lg font-bold text-brand-black mb-4 flex items-center gap-2">
                        <span class="w-6 h-6 rounded-full bg-brand-black text-white flex items-center justify-center text-xs">2</span>
                        Spesifikasi Muatan
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        
                        <div class="space-y-2">
                            <label class="text-xs font-bold uppercase text-gray-500">Jenis Muatan <span class="text-red-500">*</span></label>
                            <select v-model="form.jenis_muatan" class="w-full bg-white border border-gray-200 rounded-lg px-3 py-3 outline-none focus:ring-2 focus:ring-blue-200 transition">
                                <option value="" disabled>-- Pilih Tipe Kontainer/Kargo --</option>
                                <option value="FCL 20ft">FCL 20ft (Full Container)</option>
                                <option value="FCL 40ft">FCL 40ft (Full Container)</option>
                                <option value="LCL">LCL (Less Container Load)</option>
                                <option value="Breakbulk">Breakbulk (Curah)</option>
                                <option value="Heavy Equipment">Heavy Equipment (Alat Berat)</option>
                            </select>
                        </div>

                        <div class="space-y-2">
                            <label class="text-xs font-bold uppercase text-gray-500">Berat Total (TON) <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <input v-model="form.total_berat" type="number" step="0.01" placeholder="0.00" class="w-full bg-white border border-gray-200 rounded-lg px-3 py-3 pl-4 outline-none font-mono font-bold text-brand-black">
                                <span class="absolute right-4 top-3 text-sm text-gray-400 font-bold">TON</span>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="text-xs font-bold uppercase text-gray-500">Volume (CBM) <span class="text-blue-500 text-[10px]">(Estimasi Otomatis*)</span></label>
                            <div class="relative group">
                                <input v-model="form.total_volume" type="number" step="0.01" placeholder="0.00" class="w-full bg-white border border-blue-300 rounded-lg px-3 py-3 pl-4 outline-none font-mono font-bold text-blue-800 transition">
                                <span class="absolute right-4 top-3 text-sm text-blue-400 font-bold">M³</span>
                                <div class="absolute bottom-full mb-2 hidden group-hover:block w-48 bg-black text-white text-[10px] p-2 rounded shadow-lg">
                                    *Dihitung otomatis berdasarkan jenis & berat. Bisa diedit manual jika realita berbeda.
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <hr class="border-gray-100">

                <div>
                    <h3 class="text-lg font-bold text-brand-red mb-4 flex items-center gap-2">
                        <span class="w-6 h-6 rounded-full bg-brand-red text-white flex items-center justify-center text-xs">3</span>
                        Dokumen Legalitas
                    </h3>
                    
                    <div class="space-y-3">
                        <div v-for="(doc, index) in dokumenList" :key="index" class="flex gap-4 items-start bg-gray-50 p-3 rounded-lg border border-gray-200">
                            <div class="flex-1 space-y-1">
                                <select v-model="doc.jenis" class="w-full bg-white border border-gray-200 rounded text-sm px-2 py-1" required>
                                    <option value="" disabled>Jenis Dokumen</option>
                                    <option value="Bill of Lading (B/L)">Bill of Lading (B/L)</option>
                                    <option value="Manifest">Manifest</option>
                                    <option value="Commercial Invoice">Commercial Invoice</option>
                                    <option value="Packing List">Packing List</option>
                                    <option value="PIB">PIB (Pemberitahuan Impor)</option>
                                    <option value="Surat Jalan">Surat Jalan</option>
                                </select>
                            </div>
                            <div class="flex-1 space-y-1">
                                <input type="file" @change="handleFileUpload($event, index)" required class="block w-full text-xs text-gray-500 file:mr-2 file:py-1 file:px-2 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-black file:text-white hover:file:bg-gray-700">
                            </div>
                            <button type="button" @click="removeDokumenRow(index)" class="text-red-500 hover:text-red-700 font-bold px-2">✕</button>
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
                        {{ form.processing ? 'Menyimpan...' : 'Simpan Kargo' }}
                    </button>
                </div>

            </form>
        </div>
    </AppLayout>
</template>