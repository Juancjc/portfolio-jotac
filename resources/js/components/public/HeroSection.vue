<script setup lang="ts">
import Button from 'primevue/button';
import { computed } from 'vue';

const props = defineProps<{
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
    profile: {
        display_name: string;
        headline?: string | null;
        subtitle?: string | null;
        avatar_url?: string | null;
        github_url?: string | null;
        tech_stack?: string[] | null;
    };
    banner?: {
        image_url?: string | null;
        title?: string | null;
        subtitle?: string | null;
        overlay_color?: string | null;
        overlay_opacity?: number | null;
    } | null;
}>();

const initials = computed(() => {
    const parts = (props.profile?.display_name || 'J C').trim().split(/\s+/);
    return (
        (parts[0]?.[0] ?? '') + (parts[parts.length - 1]?.[0] ?? '')
    ).toUpperCase();
});

const scrollTo = (sel: string) => {
    document.querySelector(sel)?.scrollIntoView({ behavior: 'smooth' });
};
</script>

<template>
    <section class="bg-hero-mesh relative isolate overflow-hidden text-white">
        <!-- Custom banner overlay -->
        <template v-if="banner?.image_url">
            <img
                :src="banner.image_url"
                alt=""
                class="absolute inset-0 h-full w-full object-cover opacity-50"
            />
            <div
                class="absolute inset-0"
                :style="{
                    background: banner.overlay_color || '#000',
                    opacity: (banner.overlay_opacity ?? 40) / 100,
                }"
            />
        </template>

        <!-- Decorative mesh -->
        <div class="grid-lines absolute inset-0 opacity-40" />
        <div
            class="animate-blob-slow pointer-events-none absolute -top-40 -right-40 h-[520px] w-[520px] rounded-full bg-[var(--juan-red-600)]/30 blur-3xl"
        />
        <div
            class="animate-blob-slow pointer-events-none absolute -bottom-40 -left-40 h-[560px] w-[560px] rounded-full bg-[var(--juan-red-800)]/25 blur-3xl"
        />

        <div
            class="relative mx-auto flex min-h-[92vh] max-w-7xl items-center px-4 py-24 sm:px-6 lg:px-8"
        >
            <div
                class="grid w-full items-center gap-12 lg:grid-cols-[1.2fr_1fr]"
            >
                <!-- Texto -->
                <div class="space-y-8">
                    <div
                        class="inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/5 px-3 py-1.5 text-xs backdrop-blur"
                    >
                        <span class="relative flex h-2 w-2">
                            <span
                                class="absolute inline-flex h-full w-full animate-ping rounded-full bg-[var(--juan-red-500)] opacity-75"
                            />
                            <span
                                class="relative inline-flex h-2 w-2 rounded-full bg-[var(--juan-red-500)]"
                            />
                        </span>
                        <span class="font-medium tracking-wide">{{
                            banner?.title || 'Disponível para novos projetos'
                        }}</span>
                    </div>

                    <h1
                        class="text-4xl leading-[0.95] font-black tracking-tight sm:text-5xl md:text-6xl lg:text-7xl"
                    >
                        {{
                            profile.display_name
                                .split(' ')
                                .slice(0, 2)
                                .join(' ')
                        }}
                        <br />
                        <span class="text-gradient-red">{{
                            profile.display_name
                                .split(' ')
                                .slice(2)
                                .join(' ') || 'Developer'
                        }}</span>
                    </h1>

                    <p class="max-w-xl text-lg text-white/80 sm:text-xl">
                        {{
                            banner?.subtitle ||
                            profile.subtitle ||
                            profile.headline
                        }}
                    </p>

                    <!-- Tech chips -->
                    <div
                        v-if="profile.tech_stack?.length"
                        class="flex flex-wrap gap-2"
                    >
                        <span
                            v-for="t in profile.tech_stack.slice(0, 6)"
                            :key="t"
                            class="rounded-full border border-white/10 bg-white/5 px-3 py-1 text-xs text-white/80 backdrop-blur-sm"
                            >{{ t }}</span
                        >
                    </div>

                    <!-- CTAs -->
                    <div class="flex flex-col gap-3 sm:flex-row">
                        <Button
                            label="Ver projetos"
                            icon="pi pi-arrow-right"
                            icon-pos="right"
                            size="large"
                            class="shadow-glow-red !border-0 !bg-gradient-to-r !from-[var(--juan-red-500)] !to-[var(--juan-red-700)] !font-semibold !text-white"
                            @click="scrollTo('#projetos')"
                        />
                        <Button
                            label="Acessar GitHub"
                            icon="pi pi-github"
                            size="large"
                            severity="secondary"
                            outlined
                            class="!border-white/20 !text-white hover:!bg-white/5"
                            @click="
                                profile.github_url &&
                                window.open(profile.github_url, '_blank')
                            "
                            v-if="profile.github_url"
                        />
                    </div>

                    <div
                        class="flex items-center gap-6 pt-4 text-sm text-white/60"
                    >
                        <a
                            href="#contato"
                            class="group inline-flex items-center gap-1.5 transition hover:text-white"
                        >
                            <i class="pi pi-envelope" /> Entrar em contato
                            <i
                                class="pi pi-arrow-right opacity-0 transition group-hover:opacity-100"
                            />
                        </a>
                    </div>
                </div>

                <!-- Avatar / spotlight card -->
                <div class="relative mx-auto w-full max-w-sm">
                    <div
                        class="absolute inset-0 scale-110 rounded-[2.5rem] bg-gradient-to-br from-[var(--juan-red-500)]/30 via-transparent to-[var(--juan-red-800)]/40 blur-2xl"
                    />

                    <div
                        class="hover-tilt relative rounded-[2rem] border border-white/10 bg-white/5 p-6 backdrop-blur-xl"
                    >
                        <div
                            class="relative aspect-square overflow-hidden rounded-2xl bg-gradient-to-br from-[var(--juan-red-700)] to-[var(--juan-red-950)]"
                        >
                            <img
                                v-if="stats?.avatar"
                                :src="stats.avatar"
                                :alt="
                                    profile?.display_name ||
                                    stats?.username ||
                                    'Avatar'
                                "
                                class="h-full w-full object-cover"
                            />
                            <div
                                v-else
                                class="flex h-full w-full items-center justify-center text-8xl font-black text-white/90"
                            >
                                {{ initials }}
                            </div>
                            <div
                                class="pointer-events-none absolute inset-0 bg-gradient-to-t from-black/60 via-transparent"
                            />

                            <!-- Floating pill -->
                            <div
                                class="absolute top-3 left-3 flex items-center gap-1.5 rounded-full bg-black/50 px-2.5 py-1 text-xs text-white backdrop-blur"
                            >
                                <span
                                    class="h-1.5 w-1.5 animate-pulse rounded-full bg-emerald-400"
                                />
                                Online
                            </div>
                        </div>

                        <div class="mt-5 space-y-1">
                            <p
                                class="text-xs tracking-widest text-white/50 uppercase"
                            >
                                {{ profile.headline || 'Developer' }}
                            </p>
                            <p class="text-lg font-semibold">
                                {{ profile.display_name }}
                            </p>
                        </div>

                        <!-- Mini stats -->
                        <div class="mt-4 grid grid-cols-3 gap-3 text-center">
                            <div class="rounded-xl bg-white/5 p-2">
                                <p class="text-xs text-white/50">Stack</p>
                                <p class="font-bold">
                                    {{ profile.tech_stack?.length ?? 0 }}+
                                </p>
                            </div>
                            <div class="rounded-xl bg-white/5 p-2">
                                <p class="text-xs text-white/50">Projetos</p>
                                <p class="font-bold text-[var(--juan-red-400)]">
                                    ∞
                                </p>
                            </div>
                            <div class="rounded-xl bg-white/5 p-2">
                                <p class="text-xs text-white/50">Status</p>
                                <p class="font-bold">Ativo</p>
                            </div>
                        </div>
                    </div>

                    <!-- Floating badges -->
                    <div
                        class="animate-float pointer-events-none absolute top-12 -left-6 hidden rounded-2xl border border-white/10 bg-black/60 px-3 py-2 text-xs backdrop-blur sm:block"
                    >
                        <i class="pi pi-code text-[var(--juan-red-400)]" />
                        Laravel × Vue 3
                    </div>
                    <div
                        class="animate-float pointer-events-none absolute -right-6 bottom-16 hidden rounded-2xl border border-white/10 bg-black/60 px-3 py-2 text-xs backdrop-blur sm:block"
                        style="animation-delay: 1s"
                    >
                        <i class="pi pi-bolt text-[var(--juan-red-400)]" />
                        Premium UI/UX
                    </div>
                </div>
            </div>
        </div>

        <!-- Scroll indicator -->
        <div class="absolute inset-x-0 bottom-6 flex justify-center">
            <div class="flex flex-col items-center gap-2 text-white/50">
                <span class="text-xs tracking-widest uppercase">Scroll</span>
                <div class="h-10 w-6 rounded-full border border-white/20">
                    <div
                        class="animate-float mx-auto mt-2 h-2 w-1 rounded-full bg-[var(--juan-red-500)]"
                    />
                </div>
            </div>
        </div>
    </section>
</template>
