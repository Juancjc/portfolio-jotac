<script setup lang="ts">
defineProps<{
    links: Array<{
        id: number;
        title: string;
        description?: string | null;
        icon?: string | null;
        type: 'internal' | 'external';
        url: string;
        featured?: boolean;
    }>;
}>();
</script>

<template>
    <section class="relative py-20 sm:py-24" id="links">
        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
            <div class="mb-10 text-center">
                <p class="mb-2 text-xs font-bold uppercase tracking-[0.2em] text-[var(--juan-red-500)]">Links principais</p>
                <h2 class="text-3xl font-black tracking-tight sm:text-4xl">Tudo sobre mim em um lugar</h2>
                <p class="mt-3 text-muted-foreground">Meus canais, projetos e contatos — direto ao ponto.</p>
            </div>

            <ul class="space-y-3">
                <li v-for="l in links" :key="l.id">
                    <a
                        :href="l.type === 'external' ? `/l/${l.id}` : l.url"
                        :target="l.type === 'external' ? '_blank' : undefined"
                        :rel="l.type === 'external' ? 'noopener noreferrer' : undefined"
                        class="group flex items-center gap-4 rounded-2xl border p-4 sm:p-5 hover-lift relative overflow-hidden"
                        :class="l.featured
                            ? 'border-[var(--juan-red-500)]/40 bg-gradient-to-r from-[var(--juan-red-500)]/10 via-[var(--juan-red-500)]/5 to-transparent'
                            : 'border-border bg-card hover:border-[var(--juan-red-500)]/40'"
                    >
                        <!-- Shine -->
                        <span
                            class="pointer-events-none absolute inset-0 -translate-x-full bg-gradient-to-r from-transparent via-white/5 to-transparent transition-transform duration-700 group-hover:translate-x-full"
                        />

                        <div class="grid h-12 w-12 shrink-0 place-items-center rounded-xl bg-gradient-to-br from-[var(--juan-red-500)]/20 to-[var(--juan-red-800)]/10 text-[var(--juan-red-500)] transition group-hover:scale-110">
                            <i :class="l.icon || 'pi pi-link'" class="text-xl pi" />
                        </div>

                        <div class="min-w-0 flex-1">
                            <p class="font-semibold truncate">{{ l.title }}</p>
                            <p v-if="l.description" class="text-sm text-muted-foreground truncate">{{ l.description }}</p>
                        </div>

                        <span
                            v-if="l.featured"
                            class="hidden sm:inline-flex rounded-full border border-[var(--juan-red-500)]/30 bg-[var(--juan-red-500)]/10 px-2 py-0.5 text-[10px] font-bold uppercase tracking-wider text-[var(--juan-red-500)]"
                        >Destaque</span>

                        <i class="pi pi-arrow-up-right shrink-0 text-muted-foreground transition group-hover:text-[var(--juan-red-500)] group-hover:translate-x-0.5 group-hover:-translate-y-0.5" />
                    </a>
                </li>
            </ul>
        </div>
    </section>
</template>
