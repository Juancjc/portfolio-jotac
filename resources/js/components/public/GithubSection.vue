<script setup lang="ts">
import Button from 'primevue/button';

defineProps<{
    stats?: {
        username: string;
        name?: string | null;
        avatar?: string | null;
        bio?: string | null;
        repos: number;
        followers: number;
        following: number;
        gists: number;
        url: string;
        company?: string | null;
        location?: string | null;
    } | null;
}>();
</script>

<template>
    <section id="github" class="relative py-24 sm:py-32 overflow-hidden">
        <!-- Background tech -->
        <div class="absolute inset-0 bg-gradient-to-br from-[#0a0a0d] via-[#15060a] to-[#0a0a0d]" />
        <div class="absolute inset-0 grid-lines opacity-60" />
        <div class="pointer-events-none absolute -top-40 left-1/2 h-[640px] w-[640px] -translate-x-1/2 rounded-full bg-[var(--juan-red-600)]/20 blur-3xl animate-blob-slow" />

        <div class="relative mx-auto max-w-6xl px-4 sm:px-6 lg:px-8 text-white">
            <div class="grid gap-12 lg:grid-cols-[1fr_auto] lg:items-center">
                <div>
                    <div class="inline-flex items-center gap-2 rounded-full border border-white/15 bg-white/5 px-3 py-1 text-xs backdrop-blur">
                        <i class="pi pi-github" /> github.com/{{ stats?.username || 'juancarlos' }}
                    </div>

                    <h2 class="mt-5 text-4xl font-black leading-[1.05] sm:text-6xl md:text-7xl">
                        Explore meu<br />
                        <span class="text-gradient-red">código aberto</span>
                    </h2>

                    <p class="mt-5 max-w-xl text-white/70 text-lg">
                        Projetos, experimentos e contribuições construídos com obsessão por qualidade. Segue lá — e vamos construir juntos.
                    </p>

                    <!-- Stats -->
                    <div class="mt-10 grid grid-cols-2 gap-4 sm:grid-cols-4">
                        <div class="group relative overflow-hidden rounded-2xl border border-white/10 bg-white/5 p-5 backdrop-blur hover:border-[var(--juan-red-500)]/50 transition">
                            <span class="absolute -right-4 -top-4 h-16 w-16 rounded-full bg-[var(--juan-red-500)]/20 blur-2xl transition group-hover:bg-[var(--juan-red-500)]/40" />
                            <p class="text-4xl font-black text-gradient-red">{{ stats?.repos ?? 0 }}</p>
                            <p class="mt-1 text-xs uppercase tracking-widest text-white/60">Repositórios</p>
                        </div>
                        <div class="group relative overflow-hidden rounded-2xl border border-white/10 bg-white/5 p-5 backdrop-blur hover:border-[var(--juan-red-500)]/50 transition">
                            <p class="text-4xl font-black">{{ stats?.followers ?? 0 }}</p>
                            <p class="mt-1 text-xs uppercase tracking-widest text-white/60">Seguidores</p>
                        </div>
                        <div class="group relative overflow-hidden rounded-2xl border border-white/10 bg-white/5 p-5 backdrop-blur hover:border-[var(--juan-red-500)]/50 transition">
                            <p class="text-4xl font-black">{{ stats?.following ?? 0 }}</p>
                            <p class="mt-1 text-xs uppercase tracking-widest text-white/60">Seguindo</p>
                        </div>
                        <div class="group relative overflow-hidden rounded-2xl border border-white/10 bg-white/5 p-5 backdrop-blur hover:border-[var(--juan-red-500)]/50 transition">
                            <p class="text-4xl font-black">{{ stats?.gists ?? 0 }}</p>
                            <p class="mt-1 text-xs uppercase tracking-widest text-white/60">Gists</p>
                        </div>
                    </div>

                    <!-- CTA -->
                    <div class="mt-10 flex flex-col gap-3 sm:flex-row">
                        <a
                            :href="stats?.url || '#'" target="_blank" rel="noopener noreferrer"
                            class="group inline-flex items-center justify-center gap-2 rounded-2xl bg-white px-6 py-4 text-lg font-bold text-black shadow-[0_20px_50px_-10px_rgba(237,21,21,0.6)] transition hover:scale-[1.02]"
                        >
                            <i class="pi pi-github text-xl" />
                            Acessar meu GitHub
                            <i class="pi pi-arrow-right transition group-hover:translate-x-1" />
                        </a>
                        <a
                            v-if="stats?.username"
                            :href="`https://github.com/${stats.username}?tab=repositories`" target="_blank"
                            class="inline-flex items-center justify-center gap-2 rounded-2xl border border-white/20 bg-white/5 px-6 py-4 text-lg font-semibold text-white backdrop-blur hover:bg-white/10 transition"
                        >
                            <i class="pi pi-book-open" />
                            Ver repositórios
                        </a>
                    </div>
                </div>

                <!-- Perfil card -->
                <div class="relative mx-auto w-full max-w-sm">
                    <div class="absolute inset-0 scale-110 rounded-[2.5rem] bg-gradient-to-br from-[var(--juan-red-500)]/40 to-[var(--juan-red-900)]/50 blur-3xl" />

                    <div class="relative rounded-[2rem] border border-white/10 bg-black/60 p-6 backdrop-blur-xl shadow-[0_40px_100px_-20px_rgba(237,21,21,0.5)]">
                        <div class="flex items-center gap-4">
                            <div class="relative">
                                <img
                                    v-if="stats?.avatar"
                                    :src="stats.avatar" :alt="stats.username"
                                    class="h-16 w-16 rounded-2xl border-2 border-[var(--juan-red-500)]"
                                />
                                <div v-else class="grid h-16 w-16 place-items-center rounded-2xl border-2 border-[var(--juan-red-500)] bg-white/5">
                                    <i class="pi pi-github text-2xl text-white/70" />
                                </div>
                                <span class="absolute -bottom-1 -right-1 grid h-6 w-6 place-items-center rounded-full bg-emerald-500 ring-2 ring-black">
                                    <i class="pi pi-check text-[10px] text-black" />
                                </span>
                            </div>
                            <div class="min-w-0">
                                <p class="font-bold text-lg truncate">{{ stats?.name || stats?.username || 'Juan Carlos' }}</p>
                                <p class="text-sm text-white/60 truncate">@{{ stats?.username || 'juancarlos' }}</p>
                            </div>
                        </div>

                        <p v-if="stats?.bio" class="mt-4 text-sm text-white/70">{{ stats.bio }}</p>

                        <div class="mt-5 space-y-2 text-sm">
                            <p v-if="stats?.company" class="flex items-center gap-2 text-white/70"><i class="pi pi-building w-4" />{{ stats.company }}</p>
                            <p v-if="stats?.location" class="flex items-center gap-2 text-white/70"><i class="pi pi-map-marker w-4" />{{ stats.location }}</p>
                        </div>

                        <div class="mt-5 rounded-xl border border-white/10 bg-white/5 p-3 text-xs font-mono leading-relaxed">
                            <p class="text-white/50">$ git clone</p>
                            <p class="truncate text-[var(--juan-red-400)]">{{ stats?.url || 'https://github.com/juancarlos' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
