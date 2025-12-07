<script setup>
import { ref, computed } from 'vue';
import { Link, usePage, router } from '@inertiajs/vue3'; // [PERBAIKAN] Tambahkan 'router' disini

const page = usePage();
const user = computed(() => page.props.auth?.user || { name: 'Guest', role: 'unknown', avatar_url: '' });
const isSidebarOpen = ref(true);

const menus = {
    admin: [
        { label: 'Overview', route: 'admin.dashboard', icon: 'PieChart' },
        { label: 'Users', route: '#', icon: 'Users' },
        { label: 'System', route: '#', icon: 'Activity' },
    ],
    staff_gudang: [
        { label: 'Warehouse', route: 'gudang.dashboard', icon: 'Box' },
        { label: 'Inbound', route: '#', icon: 'ArrowDown' },
        { label: 'Outbound', route: '#', icon: 'ArrowUp' },
    ],
    staff_armada: [
        { label: 'Fleet', route: 'armada.dashboard', icon: 'Truck' },
        { label: 'Drivers', route: '#', icon: 'User' },
        { label: 'Maps', route: '#', icon: 'Map' },
    ],
    manajer: [ // [PERBAIKAN] Pastikan role ini sesuai database ('manajer')
        { label: 'Summary', route: 'manajer.dashboard', icon: 'TrendingUp' },
        { label: 'Finance', route: '#', icon: 'DollarSign' },
        { label: 'Audit', route: '#', icon: 'FileText' },
    ]
};

const currentMenu = computed(() => menus[user.value.role] || []);

// [PERBAIKAN] Fungsi logout menggunakan router import
const logout = () => {
    router.post('/logout');
    onFinish: () => {
       window.location.replace('/');
        }
};
</script>

<template>
    <div class="min-h-screen bg-brand-grey text-brand-black font-sans flex overflow-hidden relative">
        
        <div class="fixed inset-0 z-0 bg-grid-red pointer-events-none opacity-40"></div>

        <aside 
            class="fixed z-40 top-0 left-0 h-full bg-white border-r border-gray-200 transition-all duration-500 cubic-bezier(0.34, 1.56, 0.64, 1) flex flex-col shadow-[4px_0_24px_rgba(0,0,0,0.02)]"
            :class="isSidebarOpen ? 'w-72' : 'w-20'"
        >
            <div class="h-24 flex items-center justify-center border-b border-gray-100 relative">
                <div class="flex items-center gap-3 transition-all duration-300" :class="{ 'scale-0 opacity-0 absolute': !isSidebarOpen }">
                    <div class="w-10 h-10 bg-brand-red flex items-center justify-center text-white shadow-lg">
                        <span class="font-display font-black text-xl italic">S</span>
                    </div>
                    <span class="font-display font-extrabold text-2xl tracking-tight text-brand-black">SISMODO</span>
                </div>
                
                <div v-if="!isSidebarOpen" class="absolute inset-0 flex items-center justify-center">
                    <div class="w-10 h-10 bg-brand-red flex items-center justify-center text-white font-bold text-xl shadow-lg">S</div>
                </div>

                <button @click="isSidebarOpen = !isSidebarOpen" 
                    class="absolute -right-3 top-9 bg-white border border-gray-200 text-gray-500 hover:text-brand-red w-6 h-6 rounded-full flex items-center justify-center shadow-md hover:scale-110 transition-all z-50">
                    <span class="text-xs font-bold">{{ isSidebarOpen ? '‹' : '›' }}</span>
                </button>
            </div>

            <nav class="flex-1 px-4 py-8 space-y-2 overflow-y-auto custom-scrollbar">
                <div v-if="isSidebarOpen" class="px-2 mb-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest font-display">
                    Main Menu
                </div>

                <Link 
                    v-for="(item, index) in currentMenu" 
                    :key="index"
                    :href="item.route !== '#' ? route(item.route) : '#'"
                    class="flex items-center gap-4 px-4 py-4 rounded-xl transition-all duration-300 group relative overflow-hidden"
                    :class="$page.url === '/' + item.route.replace('.', '/') 
                        ? 'bg-brand-red text-white shadow-lg shadow-red-500/25' 
                        : 'text-gray-500 hover:bg-red-50 hover:text-brand-red'"
                >
                    <div class="w-6 h-6 flex items-center justify-center shrink-0">
                        <div class="w-2 h-2 rounded-sm bg-current transition-all group-hover:scale-125"></div>
                    </div>
                    
                    <span class="font-bold text-sm tracking-wide whitespace-nowrap opacity-0 transition-opacity duration-200 delay-75"
                          :class="{ 'opacity-100': isSidebarOpen, 'w-0 overflow-hidden': !isSidebarOpen }">
                        {{ item.label }}
                    </span>
                </Link>
            </nav>

            <div class="p-4 border-t border-gray-100 bg-gray-50">
                <div class="flex items-center gap-3 p-2 rounded-xl hover:bg-white hover:shadow-sm transition-all cursor-pointer group" @click="logout">
                    <img :src="user.avatar_url || `https://ui-avatars.com/api/?name=${user.name}&background=FF2A2A&color=fff`" 
                         class="w-10 h-10 rounded-lg object-cover shadow-sm grayscale group-hover:grayscale-0 transition-all" 
                         alt="Profile">
                    
                    <div class="flex-1 min-w-0 transition-all duration-300" 
                         :class="{ 'opacity-0 w-0': !isSidebarOpen, 'opacity-100': isSidebarOpen }">
                        <p class="text-sm font-extrabold text-brand-black truncate">{{ user.name }}</p>
                        <p class="text-[10px] text-gray-500 font-bold uppercase tracking-wider truncate">{{ user.role.replace('_', ' ') }}</p>
                    </div>
                    
                    <div class="text-gray-300 group-hover:text-brand-red transition-colors" v-if="isSidebarOpen">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                    </div>
                </div>
            </div>
        </aside>

        <main 
            class="flex-1 transition-all duration-500 cubic-bezier(0.34, 1.56, 0.64, 1) p-6 h-screen overflow-y-auto relative z-10"
            :class="isSidebarOpen ? 'ml-72' : 'ml-20'"
        >
            <div class="max-w-[1600px] mx-auto pt-4 pb-12">
                <slot />
            </div>
        </main>
    </div>
</template>

<style scoped>
.custom-scrollbar::-webkit-scrollbar { width: 4px; }
.custom-scrollbar::-webkit-scrollbar-thumb { background: #E5E7EB; border-radius: 4px; }
.custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #FF2A2A; }
</style>