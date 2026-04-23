<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import Toast from 'primevue/toast';
import ConfirmDialog from 'primevue/confirmdialog';
import { computed, onMounted, ref } from 'vue';
import { useAppearance } from '@/composables/useAppearance';
import { route } from '@/lib/route';

const { appearance, updateAppearance } = useAppearance();

// SSR-safe: só consulta matchMedia se estiver no browser.
const isDark = computed(() => {
    if (appearance.value === 'dark') return true;
    if (appearance.value === 'system' && typeof window !== 'undefined') {
        return window.matchMedia?.('(prefers-color-scheme: dark)').matches ?? false;
    }
    return false;
});

const scrolled = ref(false);
const mobileOpen = ref(false);

onMounted(() => {
    window.addEventListener('scroll', () => (scrolled.value = window.scrollY > 20), { passive: true });
});

const toggleDark = () => updateAppearance(isDark.value ? 'light' : 'dark');

const nav = [
    { label: 'Sobre',    href: '#sobre' },
    { label: 'Projetos', href: '#projetos' },
    { label: 'GitHub',   href: '#github' },
    { label: 'Stack',    href: '#stack' },
    { label: 'Contato',  href: '#contato' },
];
</script>

<template>
    <Head />

    <div class="min-h-screen bg-background text-foreground antialiased selection:bg-[var(--juan-red-600)]/80 selection:text-white">
        <!-- Navbar -->
        <header
            class="fixed inset-x-0 top-0 z-40 transition-all duration-300"
            :class="scrolled ? 'backdrop-blur-xl bg-background/70 border-b border-[var(--juan-red-500)]/10 shadow-[0_1px_0_rgba(237,21,21,0.12)]' : 'bg-transparent'"
        >
            <nav class="mx-auto flex h-16 max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">
                <Link href="/" class="group flex items-center gap-2">
                    <span class="grid h-9 w-9 place-items-center rounded-xl bg-gradient-to-br from-[var(--juan-red-500)] to-[var(--juan-red-800)] text-white font-black shadow-glow-red">J</span>
                    <span class="hidden sm:block font-bold tracking-tight">Juan<span class="text-gradient-red">.</span>dev</span>
                </Link>

                <ul class="hidden md:flex items-center gap-8 text-sm font-medium">
                    <li v-for="item in nav" :key="item.href">
                        <a :href="item.href" class="relative text-foreground/80 hover:text-foreground transition-colors">
                            {{ item.label }}
                            <span class="absolute -bottom-1 left-0 h-[2px] w-0 bg-[var(--juan-red-500)] transition-all group-hover:w-full" />
                        </a>
                    </li>
                </ul>

                <div class="flex items-center gap-2">
                    <button
                        @click="toggleDark"
                        class="inline-flex h-9 w-9 items-center justify-center rounded-xl border border-border hover:border-[var(--juan-red-500)] hover:text-[var(--juan-red-500)] transition"
                        :aria-label="isDark ? 'Ativar tema claro' : 'Ativar tema escuro'"
                    >
                        <i :class="isDark ? 'pi pi-sun' : 'pi pi-moon'" />
                    </button>

                    <Link :href="route('admin.dashboard')" class="hidden md:inline-flex items-center gap-1.5 rounded-xl bg-gradient-to-r from-[var(--juan-red-600)] to-[var(--juan-red-800)] px-4 py-2 text-sm font-semibold text-white shadow-glow-red hover:brightness-110 transition">
                        <i class="pi pi-lock-open" />
                        Área admin
                    </Link>

                    <button @click="mobileOpen = !mobileOpen" class="md:hidden inline-flex h-9 w-9 items-center justify-center rounded-xl border border-border">
                        <i :class="mobileOpen ? 'pi pi-times' : 'pi pi-bars'" />
                    </button>
                </div>
            </nav>

            <!-- Mobile menu -->
            <transition enter-active-class="transition duration-200" enter-from-class="opacity-0 -translate-y-2" leave-active-class="transition duration-150" leave-to-class="opacity-0 -translate-y-2">
                <div v-if="mobileOpen" class="md:hidden border-t border-border bg-background/95 backdrop-blur-xl">
                    <ul class="flex flex-col px-4 py-3">
                        <li v-for="item in nav" :key="item.href">
                            <a :href="item.href" @click="mobileOpen = false" class="block py-3 text-sm font-medium border-b border-border/50">{{ item.label }}</a>
                        </li>
                        <li>
                            <Link :href="route('admin.dashboard')" class="mt-3 flex items-center justify-center gap-1.5 rounded-xl bg-[var(--juan-red-600)] py-3 text-sm font-semibold text-white">
                                <i class="pi pi-lock-open" /> Área admin
                            </Link>
                        </li>
                    </ul>
                </div>
            </transition>
        </header>

        <Toast position="top-right" />
        <ConfirmDialog />

        <main class="pt-16">
            <slot />
        </main>
    </div>
</template>
