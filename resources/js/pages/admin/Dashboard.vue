<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import Card from 'primevue/card';
import { route } from '@/lib/route';

defineProps<{
    stats: {
        links_total: number;
        links_active: number;
        projects_total: number;
        projects_featured: number;
        clicks_total: number;
        clicks_7d: number;
    };
    topLinks: any[];
    recentProjects: any[];
}>();

const metrics = (s: any) => [
    { label: 'Links cadastrados',   value: s.links_total,      icon: 'pi-link',      accent: 'from-rose-500 to-rose-700' },
    { label: 'Links ativos',        value: s.links_active,     icon: 'pi-check-circle', accent: 'from-emerald-500 to-emerald-700' },
    { label: 'Projetos',            value: s.projects_total,   icon: 'pi-briefcase', accent: 'from-[var(--juan-red-500)] to-[var(--juan-red-800)]' },
    { label: 'Em destaque',         value: s.projects_featured,icon: 'pi-star',      accent: 'from-amber-500 to-amber-700' },
    { label: 'Cliques totais',      value: s.clicks_total,     icon: 'pi-chart-line',accent: 'from-indigo-500 to-indigo-700' },
    { label: 'Cliques (7 dias)',    value: s.clicks_7d,        icon: 'pi-bolt',      accent: 'from-fuchsia-500 to-fuchsia-700' },
];
</script>

<template>
    <Head title="Dashboard" />

    <div class="space-y-8">
        <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
            <div>
                <p class="text-xs font-bold uppercase tracking-[0.2em] text-[var(--juan-red-500)]">Overview</p>
                <h1 class="text-3xl font-black">Dashboard</h1>
                <p class="mt-1 text-muted-foreground">Visão geral do seu portfólio em tempo real.</p>
            </div>

            <div class="flex gap-2">
                <Link :href="route('admin.links.index')"   class="inline-flex items-center gap-2 rounded-xl border border-border px-4 py-2 text-sm font-semibold hover:border-[var(--juan-red-500)] hover:text-[var(--juan-red-500)]"><i class="pi pi-link"/> Gerenciar links</Link>
                <Link :href="route('admin.projects.index')" class="inline-flex items-center gap-2 rounded-xl bg-[var(--juan-red-600)] px-4 py-2 text-sm font-semibold text-white shadow-glow-red hover:brightness-110"><i class="pi pi-plus"/> Novo projeto</Link>
            </div>
        </div>

        <!-- Stats grid -->
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6">
            <div v-for="m in metrics(stats)" :key="m.label" class="group relative overflow-hidden rounded-2xl border border-border bg-card p-5 hover-lift">
                <span :class="['absolute -right-4 -top-4 h-20 w-20 rounded-full blur-2xl opacity-50 bg-gradient-to-br', m.accent]" />
                <div class="relative flex items-start justify-between">
                    <div>
                        <p class="text-xs uppercase tracking-widest text-muted-foreground">{{ m.label }}</p>
                        <p class="mt-2 text-3xl font-black">{{ m.value }}</p>
                    </div>
                    <span :class="['grid h-10 w-10 place-items-center rounded-xl text-white bg-gradient-to-br', m.accent]">
                        <i :class="['pi', m.icon]" />
                    </span>
                </div>
            </div>
        </div>

        <!-- Widgets -->
        <div class="grid gap-6 lg:grid-cols-2">
            <div class="rounded-2xl border border-border bg-card p-6">
                <div class="mb-4 flex items-center justify-between">
                    <h2 class="text-lg font-bold">Top links por cliques</h2>
                    <Link :href="route('admin.links.index')" class="text-sm text-[var(--juan-red-500)] hover:underline">Ver todos</Link>
                </div>
                <div v-if="topLinks.length" class="divide-y divide-border">
                    <div v-for="l in topLinks" :key="l.id" class="flex items-center gap-3 py-3">
                        <span class="grid h-9 w-9 place-items-center rounded-lg bg-[var(--juan-red-500)]/10 text-[var(--juan-red-500)]"><i class="pi pi-link" /></span>
                        <div class="min-w-0 flex-1">
                            <p class="truncate font-semibold text-sm">{{ l.title }}</p>
                            <p class="truncate text-xs text-muted-foreground">{{ l.url }}</p>
                        </div>
                        <span class="rounded-full bg-muted px-2.5 py-0.5 text-xs font-bold">{{ l.clicks }} <span class="text-muted-foreground font-normal">clicks</span></span>
                    </div>
                </div>
                <p v-else class="py-8 text-center text-sm text-muted-foreground">Nenhum link cadastrado ainda.</p>
            </div>

            <div class="rounded-2xl border border-border bg-card p-6">
                <div class="mb-4 flex items-center justify-between">
                    <h2 class="text-lg font-bold">Projetos recentes</h2>
                    <Link :href="route('admin.projects.index')" class="text-sm text-[var(--juan-red-500)] hover:underline">Ver todos</Link>
                </div>
                <div v-if="recentProjects.length" class="grid grid-cols-2 gap-3">
                    <div v-for="p in recentProjects" :key="p.id" class="rounded-xl border border-border p-3">
                        <div class="aspect-video rounded-lg bg-gradient-to-br from-[var(--juan-red-500)]/20 to-[var(--juan-red-800)]/30" />
                        <p class="mt-2 truncate text-sm font-semibold">{{ p.title }}</p>
                        <p class="text-xs text-muted-foreground">
                            <i v-if="p.featured" class="pi pi-star-fill text-amber-500" /> {{ p.featured ? 'Destaque' : 'Normal' }}
                        </p>
                    </div>
                </div>
                <p v-else class="py-8 text-center text-sm text-muted-foreground">Nenhum projeto cadastrado.</p>
            </div>
        </div>
    </div>
</template>
