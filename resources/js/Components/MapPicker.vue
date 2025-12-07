<script setup>
import { onMounted, ref, watch } from 'vue';
import L from 'leaflet';
import 'leaflet/dist/leaflet.css';

// Props: Menerima nilai awal (jika ada) dan label
const props = defineProps({
    label: String,
    lat: [Number, String],
    lng: [Number, String],
    address: String,
});

// Emits: Mengirim data balik ke Parent (Create.vue)
const emit = defineEmits(['update:lat', 'update:lng', 'update:address']);

const mapContainer = ref(null);
const map = ref(null);
const marker = ref(null);

// Inisialisasi Peta
onMounted(() => {
    // Default: Indonesia (tengah)
    const defaultLat = props.lat || -2.5489;
    const defaultLng = props.lng || 118.0149;
    const zoomLevel = props.lat ? 13 : 5;

    map.value = L.map(mapContainer.value).setView([defaultLat, defaultLng], zoomLevel);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map.value);

    // Custom Icon (Fix bug icon leaflet di webpack/vite)
    const icon = L.icon({
        iconUrl: 'https://unpkg.com/leaflet@1.7.1/dist/images/marker-icon.png',
        iconRetinaUrl: 'https://unpkg.com/leaflet@1.7.1/dist/images/marker-icon-2x.png',
        shadowUrl: 'https://unpkg.com/leaflet@1.7.1/dist/images/marker-shadow.png',
        iconSize: [25, 41],
        iconAnchor: [12, 41],
    });

    // Jika sudah ada koordinat awal, pasang marker
    if (props.lat && props.lng) {
        marker.value = L.marker([props.lat, props.lng], { icon, draggable: true }).addTo(map.value);
        setupMarkerEvents();
    }

    // Event Klik Peta -> Pasang Pin
    map.value.on('click', async (e) => {
        const { lat, lng } = e.latlng;
        updatePosition(lat, lng);
    });
});

const updatePosition = async (lat, lng) => {
    // 1. Update Marker
    if (marker.value) {
        marker.value.setLatLng([lat, lng]);
    } else {
        const icon = L.icon({
            iconUrl: 'https://unpkg.com/leaflet@1.7.1/dist/images/marker-icon.png',
            iconSize: [25, 41],
            iconAnchor: [12, 41],
        });
        marker.value = L.marker([lat, lng], { icon, draggable: true }).addTo(map.value);
        setupMarkerEvents();
    }

    // 2. Kirim Koordinat ke Parent
    emit('update:lat', lat);
    emit('update:lng', lng);

    // 3. Reverse Geocoding (API Nominatim - Gratis)
    // Mengubah Koordinat menjadi Alamat Teks Otomatis
    try {
        const response = await fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`);
        const data = await response.json();
        if (data && data.display_name) {
            emit('update:address', data.display_name); // Auto-fill alamat text
        }
    } catch (error) {
        console.error("Gagal mengambil alamat:", error);
    }
};

const setupMarkerEvents = () => {
    marker.value.on('dragend', (e) => {
        const { lat, lng } = e.target.getLatLng();
        updatePosition(lat, lng);
    });
};
</script>

<template>
    <div class="space-y-2">
        <label class="text-xs font-bold uppercase tracking-widest text-gray-500">{{ label }}</label>
        <div ref="mapContainer" class="h-64 w-full rounded-lg border-2 border-gray-200 z-0"></div>
        <p class="text-[10px] text-gray-400 italic">*Klik pada peta atau geser pin untuk menentukan lokasi presisi.</p>
    </div>
</template>