<script setup lang="ts">
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import Toast from 'primevue/toast';
import ConfirmDialog from 'primevue/confirmdialog';
import Avatar from 'primevue/avatar';
import { route } from '@/lib/route';

const page = usePage();
const user = computed(() => (page.props as any).auth?.user ?? null);

const nav = [
    { label: 'Dashboard', icon: 'pi pi-home',      route: 'admin.dashboard' },
    { label: 'Perfil',    icon: 'pi pi-user',      route: 'admin.profile.edit' },
    { label: 'Banner',    icon: 'pi pi-image',     route: 'admin.banner.edit' },
    { label: 'Links',     icon: 'pi pi-link',      route: 'admin.links.index' },
    { label: 'Projetos',  icon: 'pi pi-briefcase', route: 'admin.projects.index' },
];

const isActive = (r: string) => (page.props as any).ziggy?.location?.includes(r.replace('admin.', 'admin/').replace('.', '/'))
    || page.url.startsWith('/' + r.split('.').slice(0, -1).join('/') );

const sidebarOpen = ref(false);
const logout = () => router.post(route('logout'));
</script>

<template>
    <Head />

    <div class="flex min-h-screen bg-muted/20">
        <!-- Sidebar desktop -->
        <aside class="sticky top-0 hidden h-screen w-72 shrink-0 flex-col border-r border-border bg-card lg:flex">
            <div class="flex h-16 items-center gap-2 border-b border-border px-5">
                <span class="grid h-9 w-9 place-items-center rounded-xl bg-gradient-to-br from-[var(--juan-red-500)] to-[var(--juan-red-800)] text-white font-black shadow-glow-red">J</span>
                <span class="font-bold">Juan<span class="text-gradient-red">.admin</span></span>
            </div>

            <nav class="flex-1 space-y-1 p-3">
                <Link
                    v-for="n in nav" :key="n.route"
                    :href="route(n.route)"
                    class="group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition"
                    :class="(n.route === 'admin.dashboard' ? page.url === '/admin' : page.url.startsWith(route(n.route)))
                        ? 'bg-gradient-to-r from-[var(--juan-red-500)]/15 to-transparent text-foreground ring-1 ring-[var(--juan-red-500)]/30'
                        : 'text-muted-foreground hover:bg-muted hover:text-foreground'"
                >
                    <i :class="n.icon" class="text-base" />
                    <span>{{ n.label }}</span>
                </Link>
            </nav>

            <div class="border-t border-border p-3">
                <Link :href="route('home')" class="flex items-center gap-2 rounded-xl px-3 py-2 text-sm text-muted-foreground hover:bg-muted hover:text-foreground transition">
                    <i class="pi pi-external-link" /> Ver portfólio
                </Link>
                <div v-if="user" class="mt-3 flex items-center gap-3 rounded-xl border border-border p-3">
                    <Avatar :label="user.name?.[0]?.toUpperCase()" shape="circle" class="!bg-[var(--juan-red-500)] !text-white" />
                    <div class="min-w-0 flex-1">
                        <p class="truncate text-sm font-semibold">{{ user.name }}</p>
                        <p class="truncate text-xs text-muted-foreground">{{ user.email }}</p>
                    </div>
                    <button @click="logout" v-tooltip.top="'Sair'" class="grid h-8 w-8 place-items-center rounded-lg hover:bg-muted">
                        <i class="pi pi-sign-out text-sm" />
                    </button>
                </div>
            </div>
        </aside>

        <!-- Mobile top bar -->
        <div class="flex min-w-0 flex-1 flex-col">
            <header class="sticky top-0 z-30 flex h-16 items-center gap-3 border-b border-border bg-card/95 px-4 backdrop-blur lg:hidden">
                <button @click="sidebarOpen = true" class="grid h-10 w-10 place-items-center rounded-xl border border-border">
                    <i class="pi pi-bars" />
                </button>
                <span class="font-bold">Juan<span class="text-gradient-red">.admin</span></span>
            </header>

            <!-- Mobile drawer -->
            <transition enter-active-class="transition duration-200" enter-from-class="opacity-0" leave-active-class="transition duration-150" leave-to-class="opacity-0">
                <div v-if="sidebarOpen" class="fixed inset-0 z-40 bg-black/50 lg:hidden" @click="sidebarOpen = false" />
            </transition>
            <transition enter-active-class="transition duration-300" enter-from-class="-translate-x-full" leave-active-class="transition duration-200" leave-to-class="-translate-x-full">
                <aside v-if="sidebarOpen" class="fixed inset-y-0 left-0 z-50 w-72 border-r border-border bg-card lg:hidden">
                    <div class="flex h-16 items-center justify-between border-b border-border px-5">
                        <div class="flex items-center gap-2">
                            <span class="grid h-9 w-9 place-items-center rounded-xl bg-gradient-to-br from-[var(--juan-red-500)] to-[var(--juan-red-800)] text-white font-black">J</span>
                            <span class="font-bold">Admin</span>
                        </div>
                        <button @click="sidebarOpen = false" class="grid h-9 w-9 place-items-center rounded-xl hover:bg-muted"><i class="pi pi-times" /></button>
                    </div>
                    <nav class="space-y-1 p-3">
                        <Link v-for="n in nav" :key="n.route" :href="route(n.route)" class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium hover:bg-muted" @click="sidebarOpen = false">
                            <i :class="n.icon" /> {{ n.label }}
                        </Link>
                    </nav>
                </aside>
            </transition>

            <main class="flex-1 p-4 sm:p-6 lg:p-10">
                <Toast position="top-right" />
                <ConfirmDialog />
                <slot />
            </main>
        </div>
    </div>
</template>
