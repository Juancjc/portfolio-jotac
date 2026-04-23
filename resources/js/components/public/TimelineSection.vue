<script setup lang="ts">
defineProps<{
    experiences: Array<{ role: string; company?: string | null; period?: string | null; desc?: string | null }> | null | undefined;
}>();
</script>

<template>
    <section id="experiencias" class="relative py-24" v-if="experiences?.length">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
            <div class="mb-12 text-center">
                <p class="mb-2 text-xs font-bold uppercase tracking-[0.2em] text-[var(--juan-red-500)]">Jornada</p>
                <h2 class="text-3xl font-black sm:text-4xl">Experiências profissionais</h2>
            </div>

            <ol class="relative border-l-2 border-[var(--juan-red-500)]/30 pl-8 sm:pl-12 space-y-10">
                <li v-for="(exp, i) in experiences" :key="i" class="relative">
                    <span class="absolute -left-[42px] sm:-left-[54px] top-1 grid h-6 w-6 place-items-center rounded-full border-2 border-[var(--juan-red-500)] bg-background">
                        <span class="h-2 w-2 rounded-full bg-[var(--juan-red-500)] animate-pulse-red" />
                    </span>
                    <div class="rounded-2xl border border-border bg-card p-6 hover-lift">
                        <div class="flex flex-wrap items-center justify-between gap-2">
                            <h3 class="text-lg font-bold">{{ exp.role }}</h3>
                            <span v-if="exp.period" class="text-xs font-mono text-[var(--juan-red-500)] bg-[var(--juan-red-500)]/10 rounded-full px-2.5 py-1">{{ exp.period }}</span>
                        </div>
                        <p v-if="exp.company" class="mt-1 font-semibold text-sm text-foreground/80">{{ exp.company }}</p>
                        <p v-if="exp.desc" class="mt-2 text-sm leading-relaxed text-muted-foreground">{{ exp.desc }}</p>
                    </div>
                </li>
            </ol>
        </div>
    </section>
</template>
