<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const form = useForm({ email: '', password: '', remember: false });

const scrollToLogin = () => {
    document.getElementById('login-section')?.scrollIntoView({ behavior: 'smooth' });
};

const submit = () => {
    form.post('/login', {
        preserveScroll: true,
        onSuccess: () => form.reset('password'),
        onError: () => scrollToLogin()
    });
};

// --- 3D Parallax Logic ---
const heroRef = ref(null);
const handleMouseMove = (e) => {
    const { clientX, clientY } = e;
    const x = (clientX / window.innerWidth - 0.5);
    const y = (clientY / window.innerHeight - 0.5);

    if (heroRef.value) {
        heroRef.value.style.setProperty('--move-x', `${x * 20}px`);
        heroRef.value.style.setProperty('--move-y', `${y * 20}px`);
        heroRef.value.style.setProperty('--rotate-x', `${y * -5}deg`);
        heroRef.value.style.setProperty('--rotate-y', `${x * 5}deg`);
    }
};
</script>

<template>
    <Head title="SISMODO - Redefining Logistics" />

    <div class="scroll-container bg-brand-grey text-brand-black selection:bg-brand-red selection:text-white" @mousemove="handleMouseMove" ref="heroRef">

        <!-- === SECTION 1: HERO (BOLD RED & CLEAN) === -->
        <section class="scroll-section relative flex flex-col justify-center items-center overflow-hidden bg-grid-red">
            
            <!-- Navbar Simple -->
            <nav class="absolute top-0 w-full p-8 flex justify-between items-center z-50">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 bg-brand-red flex items-center justify-center text-white font-display font-bold">S</div>
                    <span class="font-display font-bold text-xl tracking-tight">SISMODO.</span>
                </div>
                <button @click="scrollToLogin" class="text-sm font-bold uppercase tracking-widest hover:text-brand-red transition-colors">
                    Login Staff →
                </button>
            </nav>

            <!-- Floating 3D Elements (Red Accent) -->
            <div class="absolute inset-0 z-10 pointer-events-none" style="transform: translate(var(--move-x), var(--move-y))">
                <!-- Red Sphere / Abstract Shape -->
                <div class="absolute top-[15%] right-[10%] w-40 h-40 bg-brand-red rounded-full blur-[60px] opacity-20 animate-float"></div>
                <div class="absolute bottom-[20%] left-[10%] w-64 h-64 border border-brand-red/20 rounded-full animate-float" style="animation-delay: 1s;"></div>
                
                <!-- Gen Z Stickers -->
                <div class="absolute top-[20%] left-[15%] bg-white border-2 border-brand-black px-4 py-2 font-display font-bold text-lg -rotate-6 shadow-[4px_4px_0px_#000] z-20">
                    CEPAT & TEPAT
                </div>
                <div class="absolute bottom-[30%] right-[15%] bg-brand-red text-white px-5 py-3 font-display font-bold text-xl rotate-3 shadow-[6px_6px_0px_rgba(0,0,0,0.1)] z-20">
                    24/7 Dukungan
                </div>
            </div>

            <!-- Main Content -->
            <div class="relative z-20 text-center px-4 max-w-5xl" style="transform: perspective(1000px) rotateX(var(--rotate-x)) rotateY(var(--rotate-y))">
                <div class="mb-6 inline-flex items-center gap-3 bg-white px-4 py-1.5 rounded-full border border-gray-200 shadow-sm">
                    <span class="w-2 h-2 bg-brand-red rounded-full animate-pulse"></span>
                    <span class="text-xs font-bold text-gray-500 uppercase tracking-widest">Sistem Logistik Terintegrasi</span>
                </div>

                <h1 class="font-display text-[5rem] md:text-[11rem] font-black leading-[0.85] tracking-tighter text-brand-red mb-8">
                    SATRIA <br>
                    <span class="text-brand-black"> LOGISTIK.</span>
                </h1>

                <p class="text-lg md:text-xl text-gray-500 max-w-2xl mx-auto font-medium leading-relaxed mb-10">
                    Platform manajemen order modern. Kecepatan tanpa kompromi, presisi data, dan kontrol penuh dalam satu genggaman.
                </p>

                <div class="flex flex-col md:flex-row gap-4 justify-center">
                    <button @click="scrollToLogin" class="btn-red px-10 py-4 rounded-full text-lg flex items-center gap-2 group">
                        Lanjut 
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                    </button>
                </div>
            </div>

        </section>

        <!-- === SECTION 2: LOGIN (CLEAN & BOLD) === -->
        <section id="login-section" class="scroll-section flex items-center justify-center bg-white relative overflow-hidden">
            
            <!-- Background Accent -->
            <div class="absolute inset-0 pointer-events-none">
                <div class="absolute top-0 right-0 w-1/3 h-full bg-brand-gray border-l border-gray-100"></div>
                <!-- Red Circle Abstract -->
                <div class="absolute bottom-[-10%] left-[-5%] w-[40vw] h-[40vw] border-[20px] border-brand-red/5 rounded-full"></div>
            </div>

            <!-- Login Container -->
            <div class="w-full max-w-6xl mx-4 grid grid-cols-1 md:grid-cols-2 bg-white shadow-2xl rounded-3xl overflow-hidden border border-gray-100 relative z-10 h-auto md:h-[70vh]">
                
                <!-- Kiri: Brand Visual (Solid Red Block) -->
                <div class="hidden md:flex flex-col justify-between p-12 bg-brand-red text-white relative overflow-hidden">
                    <!-- Pattern -->
                    <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(white 1px, transparent 1px); background-size: 20px 20px;"></div>
                    
                    <div class="relative z-10">
                        <div class="w-16 h-16 bg-white rounded-none flex items-center justify-center mb-8 shadow-lg">
                            <span class="text-brand-red font-display font-black text-4xl">S</span>
                        </div>
                        <h2 class="text-5xl font-display font-bold leading-tight">
                            Portal <br> Staf.
                        </h2>
                    </div>

                    <div class="relative z-10">
                        <p class="text-sm opacity-80">© 2025 SISMODO Logistics. All rights reserved.</p>
                    </div>
                </div>

                <!-- Kanan: Form (Clean Minimalist) -->
                <div class="p-12 md:p-16 flex flex-col justify-center">
                    <div class="mb-10">
                        <h3 class="text-3xl font-display font-bold text-brand-black mb-2">Selamat Datang.</h3>
                        <p class="text-gray-500">Silakan masuk dengan akun staf Anda.</p>
                    </div>

                    <form @submit.prevent="submit" class="space-y-6">
                        <div class="group">
                            <label class="block text-xs font-bold uppercase tracking-widest text-gray-400 mb-2 group-focus-within:text-brand-red transition-colors">Email Perusahaan</label>
                            <input 
                                v-model="form.email" 
                                type="email" 
                                class="w-full bg-gray-50 border border-gray-200 rounded-lg px-5 py-4 text-brand-black focus:outline-none focus:border-brand-red focus:bg-white transition-all font-medium placeholder-gray-300"
                                placeholder="nama@sismodo.id"
                            >
                            <div v-if="form.errors.email" class="text-brand-red text-xs mt-2 font-bold flex items-center gap-1">
                                <span class="text-lg">•</span> {{ form.errors.email }}
                            </div>
                        </div>

                        <div class="group">
                            <label class="block text-xs font-bold uppercase tracking-widest text-gray-400 mb-2 group-focus-within:text-brand-red transition-colors">Password</label>
                            <input 
                                v-model="form.password" 
                                type="password" 
                                class="w-full bg-gray-50 border border-gray-200 rounded-lg px-5 py-4 text-brand-black focus:outline-none focus:border-brand-red focus:bg-white transition-all font-medium placeholder-gray-300"
                                placeholder="••••••••"
                            >
                        </div>

                        <div class="flex items-center justify-between text-sm pt-2">
                            <label class="flex items-center cursor-pointer group">
                                <input type="checkbox" v-model="form.remember" class="w-4 h-4 rounded border-gray-300 text-brand-red focus:ring-brand-red">
                                <span class="ml-2 text-gray-600 group-hover:text-brand-black transition-colors font-medium">Ingat saya</span>
                            </label>
                            <a href="#" class="text-gray-400 hover:text-brand-red transition-colors font-medium underline decoration-1 underline-offset-4">Lupa password?</a>
                        </div>

                        <button 
                            type="submit" 
                            :disabled="form.processing"
                            class="w-full btn-red py-4 rounded-lg mt-6 text-lg tracking-wide disabled:opacity-50 disabled:cursor-not-allowed"
                        >
                            {{ form.processing ? 'Memproses...' : 'Login' }}
                        </button>
                    </form>
                </div>
            </div>
        </section>

    </div>
</template>

<style scoped>
.scroll-container::-webkit-scrollbar { display: none; }
.scroll-container { -ms-overflow-style: none; scrollbar-width: none; }
</style>