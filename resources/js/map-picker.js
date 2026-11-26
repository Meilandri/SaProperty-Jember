import L from 'leaflet';
import 'leaflet/dist/leaflet.css';
import icon from 'leaflet/dist/images/marker-icon.png';
import icon2x from 'leaflet/dist/images/marker-icon-2x.png';
import shadow from 'leaflet/dist/images/marker-shadow.png';

L.Icon.Default.mergeOptions({ iconUrl: icon, iconRetinaUrl: icon2x, shadowUrl: shadow });

const DEFAULT_CENTER = [-6.2, 106.8];

document.querySelectorAll('[data-map-picker]').forEach(init);

function init(root) {
    const canvas = root.querySelector('[data-map-canvas]');
    const input = root.querySelector('[data-map-value]');
    const info = root.querySelector('[data-map-info]');
    const search = root.querySelector('[data-map-search]');
    const find = root.querySelector('[data-map-find]');
    const clear = root.querySelector('[data-map-clear]');

    const m = (input.value || '').match(/^\s*(-?\d+(?:\.\d+)?)\s*,\s*(-?\d+(?:\.\d+)?)\s*$/);
    const start = m ? [parseFloat(m[1]), parseFloat(m[2])] : DEFAULT_CENTER;

    const map = L.map(canvas).setView(start, m ? 17 : 10);
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; OpenStreetMap',
    }).addTo(map);

    let marker = null;

    function setPoint(lat, lng) {
        lat = Number(lat.toFixed(6));
        lng = Number(lng.toFixed(6));
        input.value = lat + ',' + lng;
        info.textContent = 'Titik terpilih: ' + lat + ', ' + lng;

        if (!marker) {
            marker = L.marker([lat, lng], { draggable: true }).addTo(map);
            marker.on('dragend', () => {
                const p = marker.getLatLng();
                setPoint(p.lat, p.lng);
            });
        } else {
            marker.setLatLng([lat, lng]);
        }
    }

    function clearPoint() {
        input.value = '';
        info.textContent = 'Belum ada titik. Peta tidak akan ditampilkan di website.';
        if (marker) { map.removeLayer(marker); marker = null; }
    }

    if (m) setPoint(start[0], start[1]); else clearPoint();

    map.on('click', (e) => setPoint(e.latlng.lat, e.latlng.lng));

    async function doSearch() {
        const q = search.value.trim();
        if (!q) return;
        info.textContent = 'Mencari...';
        try {
            const res = await fetch(
                'https://nominatim.openstreetmap.org/search?format=json&limit=1&countrycodes=id&q=' + encodeURIComponent(q),
                { headers: { 'Accept-Language': 'id' } }
            );
            const data = await res.json();
            if (!data.length) {
                info.textContent = 'Alamat tidak ditemukan. Klik langsung di peta untuk menentukan titik.';
                return;
            }
            const lat = parseFloat(data[0].lat), lng = parseFloat(data[0].lon);
            map.setView([lat, lng], 17);
            setPoint(lat, lng);
        } catch (e) {
            info.textContent = 'Pencarian gagal. Klik langsung di peta untuk menentukan titik.';
        }
    }

    find.addEventListener('click', doSearch);
    search.addEventListener('keydown', (e) => {
        if (e.key === 'Enter') { e.preventDefault(); doSearch(); }
    });
    clear.addEventListener('click', clearPoint);

    setTimeout(() => map.invalidateSize(), 200);
}