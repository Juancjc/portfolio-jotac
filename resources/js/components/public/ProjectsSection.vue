<script setup lang="ts">
import Button from 'primevue/button';
import { ref } from 'vue';

const props = defineProps<{
    projects: Array<{
        id: number;
        title: string;
        description?: string | null;
        image_url?: string | null;
        technologies?: string[] | null;
        project_url?: string | null;
        github_url?: string | null;
        featured?: boolean;
    }>;
}>();

const filter = ref<'all' | 'featured'>('all');
const filtered = () => filter.value === 'all' ? props.projects : props.projects.filter(p => p.featured);
</script>

<template>
    <section id="projetos" class="relative py-24">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mb-10 flex flex-col items-start justify-between gap-6 sm:mb-14 sm:flex-row sm:items-end">
                <div>
                    <p class="mb-2 text-xs font-bold uppercase tracking-[0.2em] text-[var(--juan-red-500)]">Projetos</p>
                    <h2 class="text-3xl font-black sm:text-5xl">
                        Trabalhos em <span class="text-gradient-red">destaque</span>
                    </h2>
                    <p class="mt-3 max-w-xl text-muted-foreground">
                        Alguns dos produtos, sistemas e experimentos que construí. Cada um com foco em código limpo, performance e UX.
                    </p>
                </div>

                <div class="inline-flex rounded-full border border-border p-1">
                    <button
                        @click="filter = 'all'"
                        :class="filter === 'all'
                            ? 'bg-[var(--juan-red-500)] text-white shadow-glow-red'
                            : 'text-muted-foreground hover:text-foreground'"
                        class="rounded-full px-4 py-1.5 text-sm font-semibold transition"
                    >Todos</button>
                    <button
                        @click="filter = 'featured'"
                        :class="filter === 'featured'
                            ? 'bg-[var(--juan-red-500)] text-white shadow-glow-red'
                            : 'text-muted-foreground hover:text-foreground'"
                        class="rounded-full px-4 py-1.5 text-sm font-semibold transition"
                    >Destaques</button>
                </div>
            </div>

            <div v-if="filtered().length" class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                <article
                    v-for="p in filtered()" :key="p.id"
                    class="group relative overflow-hidden rounded-3xl border border-border bg-card hover-lift"
                >
                    <!-- Media -->
                    <div class="relative aspect-[16/10] overflow-hidden bg-gradient-to-br from-[var(--juan-red-700)]/30 to-[var(--juan-red-950)]/40">
                        <img
                            v-if="p.image_url"
                            :src="p.image_url" :alt="p.title"
                            class="h-full w-full object-cover transition duration-700 group-hover:scale-110"
                        />
                        <div v-else class="absolute inset-0 grid place-items-center">
                            <i class="pi pi-code text-6xl text-[var(--juan-red-500)]/60" />
                        </div>

                        <!-- Tag destaque -->
                        <span v-if="p.featured" class="absolute left-3 top-3 rounded-full bg-[var(--juan-red-600)] px-2.5 py-1 text-[10px] font-bold uppercase tracking-widest text-white shadow-lg">
                            <i class="pi pi-star-fill" /> Destaque
                        </span>

                        <!-- Overlay bottom -->
                        <div class="absolute inset-x-0 bottom-0 flex items-center justify-between gap-2 bg-gradient-to-t from-black/80 to-transparent p-4 opacity-0 transition-opacity group-hover:opacity-100">
                            <a v-if="p.project_url" :href="p.project_url" target="_blank" class="inline-flex items-center gap-1.5 rounded-full bg-white px-3 py-1.5 text-xs font-semibold text-black">
                                <i class="pi pi-external-link" /> Ver projeto
                            </a>
                            <a v-if="p.github_url" :href="p.github_url" target="_blank" class="inline-flex items-center gap-1.5 rounded-full bg-black/70 px-3 py-1.5 text-xs font-semibold text-white backdrop-blur">
                                <i class="pi pi-github" /> GitHub
                            </a>
                        </div>
                    </div>

                    <!-- Body -->
                    <div class="p-5">
                        <h3 class="text-lg font-bold tracking-tight group-hover:text-[var(--juan-red-500)] transition-colors">{{ p.title }}</h3>
                        <p v-if="p.description" class="mt-2 line-clamp-3 text-sm text-muted-foreground">{{ p.description }}</p>

                        <div v-if="p.technologies?.length" class="mt-4 flex flex-wrap gap-1.5">
                            <span
                                v-for="t in p.technologies" :key="t"
                                class="rounded-full border border-border bg-background px-2.5 py-0.5 text-[11px] font-medium text-muted-foreground"
                            >{{ t }}</span>
                        </div>
                    </div>
                </article>
            </div>

            <div v-else class="rounded-3xl border border-dashed border-border p-12 text-center">
                <i class="pi pi-inbox text-4xl text-muted-foreground" />
                <p class="mt-3 font-semibold">Nenhum projeto por aqui ainda.</p>
                <p class="text-sm text-muted-foreground">Em breve, muita coisa boa.</p>
            </div>
        </div>
    </section>
</template>
