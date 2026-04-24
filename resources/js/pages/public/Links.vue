<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { computed } from 'vue';
import LinksSection from '@/components/public/LinksSection.vue';

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
        bio?: string | null;
        avatar_url?: string | null;
        location?: string | null;
        github_url?: string | null;
        linkedin_url?: string | null;
        instagram_url?: string | null;
        twitter_url?: string | null;
        email_contact?: string | null;
    } | null;
    links: Array<{
        id: number;
        title: string;
        description?: string | null;
        icon?: string | null;
        type: 'internal' | 'external';
        url: string;
        featured?: boolean;
    }>;
    meta: { title?: string | null; description?: string | null };
}>();

const initials = computed(() => {
    const parts = (props.profile?.display_name || 'J C').trim().split(/\s+/);
    return (
        (parts[0]?.[0] ?? '') + (parts[parts.length - 1]?.[0] ?? '')
    ).toUpperCase();
});

const socials = computed(() => {
    const p = props.profile;
    if (!p) return [];
    return [
        p.github_url && {
            icon: 'pi pi-github',
            href: p.github_url,
            label: 'GitHub',
        },
        p.linkedin_url && {
            icon: 'pi pi-linkedin',
            href: p.linkedin_url,
            label: 'LinkedIn',
        },
        p.instagram_url && {
            icon: 'pi pi-instagram',
            href: p.instagram_url,
            label: 'Instagram',
        },
        p.twitter_url && {
            icon: 'pi pi-twitter',
            href: p.twitter_url,
            label: 'Twitter/X',
        },
        p.email_contact && {
            icon: 'pi pi-envelope',
            href: `mailto:${p.email_contact}`,
            label: 'Email',
        },
    ].filter(Boolean) as Array<{ icon: string; href: string; label: string }>;
});

const year = new Date().getFullYear();
</script>

<template>
    <Head>
        <title>{{ meta.title || 'Links' }}</title>
        <meta name="description" :content="meta.description || ''" />
        <meta property="og:title" :content="meta.title || 'Links'" />
        <meta property="og:description" :content="meta.description || ''" />
        <meta name="theme-color" content="#ed1515" />
    </Head>

    <!-- Página cheia com fundo mesh vermelho — zero navbar/footer do PublicLayout -->
    <div
        class="bg-hero-mesh relative isolate min-h-screen overflow-hidden text-white"
    >
        <!-- Background decor -->
        <div class="grid-lines absolute inset-0 opacity-40" />
        <div
            class="animate-blob-slow pointer-events-none absolute -top-40 -right-40 h-[520px] w-[520px] rounded-full bg-[var(--juan-red-600)]/30 blur-3xl"
        />
        <div
            class="animate-blob-slow pointer-events-none absolute -bottom-40 -left-40 h-[560px] w-[560px] rounded-full bg-[var(--juan-red-800)]/25 blur-3xl"
            style="animation-delay: 3s"
        />

        <!-- Voltar -->
        <Link
            href="/"
            class="absolute top-4 left-4 z-10 inline-flex items-center gap-1.5 rounded-full border border-white/15 bg-white/5 px-3 py-1.5 text-xs font-semibold text-white/80 backdrop-blur transition hover:border-[var(--juan-red-500)]/50 hover:text-white sm:top-6 sm:left-6"
        >
            <i class="pi pi-arrow-left text-[10px]" />
            Voltar ao portfólio
        </Link>

        <main
            class="relative mx-auto flex min-h-screen max-w-xl flex-col items-center justify-start px-4 py-16 sm:py-20"
        >
            <!-- Header do perfil -->
            <header class="flex flex-col items-center text-center">
                <div class="relative">
                    <div
                        class="animate-pulse-red absolute inset-0 scale-125 rounded-full bg-gradient-to-br from-[var(--juan-red-500)]/50 to-[var(--juan-red-800)]/50 blur-2xl"
                    />
                    <div
                        class="shadow-glow-red relative grid h-28 w-28 place-items-center overflow-hidden rounded-full border-2 border-[var(--juan-red-500)] bg-gradient-to-br from-[var(--juan-red-700)] to-[var(--juan-red-950)] sm:h-32 sm:w-32"
                    >
                        <img
                            v-if="stats?.avatar"
                            :src="stats.avatar"
                            :alt="stats.username"
                            class="h-full w-full object-cover"
                        />
                        <span v-else class="text-4xl font-black text-white">{{
                            initials
                        }}</span>
                    </div>
                    <span
                        class="absolute -right-1 -bottom-1 grid h-7 w-7 place-items-center rounded-full bg-emerald-500 ring-2 ring-[#0a0a0d]"
                    >
                        <i class="pi pi-check text-[11px] text-black" />
                    </span>
                </div>

                <h1 class="mt-5 text-2xl font-black tracking-tight sm:text-3xl">
                    {{
                        profile?.display_name || 'Juan Carlos Justiniano Coelho'
                    }}
                </h1>
                <p
                    v-if="profile?.headline"
                    class="mt-1 text-sm font-semibold tracking-widest text-[var(--juan-red-400)] uppercase"
                >
                    {{ profile.headline }}
                </p>
                <p
                    v-if="profile?.subtitle || profile?.bio"
                    class="mt-3 max-w-sm text-sm leading-relaxed text-white/70"
                >
                    {{ profile?.subtitle || profile?.bio }}
                </p>

                <p
                    v-if="profile?.location"
                    class="mt-3 inline-flex items-center gap-1.5 text-xs text-white/50"
                >
                    <i class="pi pi-map-marker" /> {{ profile.location }}
                </p>
            </header>

            <!-- Social icons row -->
            <div
                v-if="socials.length"
                class="mt-6 flex flex-wrap justify-center gap-2"
            >
                <a
                    v-for="s in socials"
                    :key="s.label"
                    :href="s.href"
                    target="_blank"
                    rel="noopener noreferrer"
                    :aria-label="s.label"
                    v-tooltip.top="s.label"
                    class="grid h-10 w-10 place-items-center rounded-full border border-white/15 bg-white/5 backdrop-blur transition hover:scale-110 hover:border-[var(--juan-red-500)] hover:bg-[var(--juan-red-500)]/15 hover:text-[var(--juan-red-400)]"
                >
                    <i :class="s.icon" class="text-sm" />
                </a>
            </div>

            <!-- Links — reaproveito LinksSection mas sem o título -->
            <section class="mt-10 w-full" v-if="links.length">
                <ul class="space-y-3">
                    <li v-for="l in links" :key="l.id">
                        <a
                            :href="l.type === 'external' ? `/l/${l.id}` : l.url"
                            :target="
                                l.type === 'external' ? '_blank' : undefined
                            "
                            :rel="
                                l.type === 'external'
                                    ? 'noopener noreferrer'
                                    : undefined
                            "
                            class="group relative flex items-center gap-4 overflow-hidden rounded-2xl border p-4 backdrop-blur transition sm:p-5"
                            :class="
                                l.featured
                                    ? 'shadow-glow-red border-[var(--juan-red-500)]/50 bg-gradient-to-r from-[var(--juan-red-500)]/15 via-[var(--juan-red-500)]/5 to-transparent'
                                    : 'border-white/10 bg-white/5 hover:border-[var(--juan-red-500)]/40 hover:bg-white/10'
                            "
                        >
                            <!-- Shine -->
                            <span
                                class="pointer-events-none absolute inset-0 -translate-x-full bg-gradient-to-r from-transparent via-white/10 to-transparent transition-transform duration-700 group-hover:translate-x-full"
                            />

                            <div
                                class="grid h-12 w-12 shrink-0 place-items-center rounded-xl bg-gradient-to-br from-[var(--juan-red-500)]/25 to-[var(--juan-red-800)]/15 text-[var(--juan-red-400)] transition group-hover:scale-110"
                            >
                                <i
                                    :class="l.icon || 'pi pi-link'"
                                    class="pi text-xl"
                                />
                            </div>

                            <div class="min-w-0 flex-1">
                                <p class="truncate font-semibold">
                                    {{ l.title }}
                                </p>
                                <p
                                    v-if="l.description"
                                    class="truncate text-sm text-white/60"
                                >
                                    {{ l.description }}
                                </p>
                            </div>

                            <span
                                v-if="l.featured"
                                class="hidden rounded-full border border-[var(--juan-red-500)]/40 bg-[var(--juan-red-500)]/15 px-2 py-0.5 text-[10px] font-bold tracking-wider text-[var(--juan-red-300)] uppercase sm:inline-flex"
                                >Destaque</span
                            >

                            <i
                                class="pi pi-arrow-up-right shrink-0 text-white/50 transition group-hover:translate-x-0.5 group-hover:-translate-y-0.5 group-hover:text-[var(--juan-red-400)]"
                            />
                        </a>
                    </li>
                </ul>
            </section>

            <!-- Vazio -->
            <div
                v-else
                class="mt-10 w-full rounded-2xl border border-dashed border-white/15 p-10 text-center text-white/60"
            >
                <i class="pi pi-link text-3xl" />
                <p class="mt-3 font-semibold">Nenhum link cadastrado ainda.</p>
            </div>

            <!-- Mini footer -->
            <footer
                class="mt-12 flex flex-col items-center gap-1 text-xs text-white/40"
            >
                <Link
                    href="/"
                    class="inline-flex items-center gap-1.5 rounded-full border border-white/10 px-3 py-1 transition hover:border-[var(--juan-red-500)]/50 hover:text-white/80"
                >
                    <i class="pi pi-globe" /> Ver portfólio completo
                </Link>
                <p class="mt-3">
                    © {{ year }} {{ profile?.display_name || 'Juan Carlos' }}
                </p>
            </footer>
        </main>
    </div>
</template>
