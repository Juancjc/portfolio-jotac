<script setup lang="ts">
defineProps<{ displayName: string; githubUrl?: string | null }>();
const year = new Date().getFullYear();
</script>

<template>
    <footer class="border-t border-border bg-card/50">
        <div class="mx-auto flex max-w-7xl flex-col items-center justify-between gap-4 px-4 py-10 sm:flex-row sm:px-6 lg:px-8">
            <div class="flex items-center gap-3">
                <span class="grid h-10 w-10 place-items-center rounded-xl bg-gradient-to-br from-[var(--juan-red-500)] to-[var(--juan-red-800)] text-white font-black shadow-glow-red">J</span>
                <div>
                    <p class="font-bold">{{ displayName }}</p>
                    <p class="text-xs text-muted-foreground">© {{ year }} — Todos os direitos reservados.</p>
                </div>
            </div>
            <p class="text-xs text-muted-foreground">
                Construído com <i class="pi pi-heart-fill text-[var(--juan-red-500)]" /> usando Laravel + Vue + PrimeVue
            </p>
        </div>
    </footer>
</template>
