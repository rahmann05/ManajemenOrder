<script setup>
import { onMounted, ref } from 'vue';
import L from 'leaflet';
import 'leaflet/dist/leaflet.css';

const props = defineProps({
    origin: Object,      // { lat: ..., lng: ... }
    destination: Object, // { lat: ..., lng: ... }
    current: Object      // { lat: ..., lng: ... } (Posisi Terkini)
});

const mapContainer = ref(null);
const map = ref(null);

onMounted(() => {
    if (!props.origin?.lat || !props.destination?.lat) return;

    // 1. Inisialisasi Peta (Center di antara dua titik)
    map.value = L.map(mapContainer.value);
    
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map.value);

    // 2. Icon Marker Custom
    const createIcon = (color) => {
        return new L.Icon({
            iconUrl: `https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-${color}.png`,
            shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34],
            shadowSize: [41, 41]
        });
    };

    // 3. Tambahkan Marker
    const markers = [];

    // Marker Asal (Hijau)
    const originMarker = L.marker([props.origin.lat, props.origin.lng], { icon: createIcon('green') })
        .addTo(map.value)
        .bindPopup('<b>📍 ASAL (Origin)</b>');
    markers.push(originMarker);

    // Marker Tujuan (Merah)
    const destMarker = L.marker([props.destination.lat, props.destination.lng], { icon: createIcon('red') })
        .addTo(map.value)
        .bindPopup('<b>🏁 TUJUAN (Destination)</b>');
    markers.push(destMarker);

    // Marker Posisi Terkini (Biru - Jika ada)
    if (props.current?.lat) {
        L.marker([props.current.lat, props.current.lng], { icon: createIcon('blue') })
            .addTo(map.value)
            .bindPopup('<b>🚚 Posisi Terkini</b>')
            .openPopup();
    }

    // 4. Gambar Garis Rute (Polyline)
    const latlngs = [
        [props.origin.lat, props.origin.lng],
        [props.destination.lat, props.destination.lng]
    ];
    
    const polyline = L.polyline(latlngs, { color: 'blue', weight: 4, opacity: 0.5, dashArray: '10, 10' }).addTo(map.value);

    // 5. Auto Zoom agar semua marker terlihat
    const group = new L.featureGroup(markers);
    map.value.fitBounds(group.getBounds(), { padding: [50, 50] });
});
</script>

<template>
    <div ref="mapContainer" class="h-96 w-full rounded-xl border-2 border-gray-200 z-0 shadow-inner"></div>
</template>