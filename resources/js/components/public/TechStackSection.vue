<script setup lang="ts">
defineProps<{ stack: string[] | null | undefined }>();

const icons: Record<string, string> = {
    laravel:    'pi pi-server',
    'vue 3':    'pi pi-prime',
    vue:        'pi pi-prime',
    primevue:   'pi pi-palette',
    typescript: 'pi pi-code',
    tailwind:   'pi pi-bolt',
    'tailwind css': 'pi pi-bolt',
    postgresql: 'pi pi-database',
    mysql:      'pi pi-database',
    redis:      'pi pi-bolt',
    docker:     'pi pi-box',
    aws:        'pi pi-cloud',
    'node.js':  'pi pi-desktop',
    inertia:    'pi pi-sync',
    'php 8.3':  'pi pi-server',
};

const iconFor = (name: string) => icons[name.toLowerCase()] || 'pi pi-code';
</script>

<template>
    <section id="stack" class="relative py-24 overflow-hidden">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            <div class="mb-12 text-center">
                <p class="mb-2 text-xs font-bold uppercase tracking-[0.2em] text-[var(--juan-red-500)]">Tech Stack</p>
                <h2 class="text-3xl font-black sm:text-4xl">Tecnologias que domino</h2>
                <p class="mt-3 text-muted-foreground max-w-xl mx-auto">Ferramentas que uso no dia a dia para entregar produtos rápidos, seguros e escaláveis.</p>
            </div>

            <div
                v-if="stack?.length"
                class="grid grid-cols-2 gap-3 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6"
            >
                <div
                    v-for="t in stack" :key="t"
                    class="group relative flex flex-col items-center gap-3 rounded-2xl border border-border bg-card p-6 hover-lift"
                >
                    <span class="grid h-14 w-14 place-items-center rounded-xl bg-gradient-to-br from-[var(--juan-red-500)]/15 to-[var(--juan-red-800)]/10 text-[var(--juan-red-500)] transition group-hover:scale-110">
                        <i :class="iconFor(t)" class="text-2xl" />
                    </span>
                    <p class="text-sm font-semibold text-center">{{ t }}</p>
                </div>
            </div>
        </div>
    </section>
</template>
