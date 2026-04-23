<script setup lang="ts">
defineProps<{
    profile: {
        display_name: string;
        bio?: string | null;
        location?: string | null;
        email_contact?: string | null;
        headline?: string | null;
    };
}>();
</script>

<template>
    <section id="sobre" class="relative py-24 sm:py-32">
        <div class="pointer-events-none absolute inset-0 grid-dots opacity-30 [mask-image:radial-gradient(ellipse_at_center,black_20%,transparent_70%)]" />

        <div class="relative mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            <div class="grid gap-14 lg:grid-cols-2 lg:items-center">
                <div>
                    <p class="mb-3 text-xs font-bold uppercase tracking-[0.2em] text-[var(--juan-red-500)]">Sobre mim</p>
                    <h2 class="text-3xl font-black leading-tight sm:text-5xl">
                        Transformo <span class="text-gradient-red">ideias complexas</span> em produtos elegantes.
                    </h2>
                    <p class="mt-6 text-lg leading-relaxed text-muted-foreground">
                        {{ profile.bio || 'Desenvolvedor apaixonado por arquitetura de sistemas, UX e performance. Foco em Laravel + Vue, design premium e soluções escaláveis que geram resultados reais.' }}
                    </p>

                    <dl class="mt-8 grid grid-cols-2 gap-4 sm:grid-cols-3">
                        <div class="rounded-2xl border border-border p-4">
                            <dt class="text-xs text-muted-foreground">Função</dt>
                            <dd class="mt-1 font-bold">{{ profile.headline || 'Full-Stack' }}</dd>
                        </div>
                        <div class="rounded-2xl border border-border p-4">
                            <dt class="text-xs text-muted-foreground">Local</dt>
                            <dd class="mt-1 font-bold">{{ profile.location || 'Remoto' }}</dd>
                        </div>
                        <div class="rounded-2xl border border-border p-4 col-span-2 sm:col-span-1">
                            <dt class="text-xs text-muted-foreground">Email</dt>
                            <dd class="mt-1 font-bold truncate text-sm">{{ profile.email_contact || '—' }}</dd>
                        </div>
                    </dl>
                </div>

                <div class="relative">
                    <div class="absolute -inset-4 rounded-3xl bg-[var(--juan-red-500)]/10 blur-2xl" />
                    <div class="relative rounded-3xl border border-border bg-card p-8">
                        <div class="flex items-center gap-3 border-b border-border pb-4">
                            <span class="h-3 w-3 rounded-full bg-[var(--juan-red-500)]" />
                            <span class="h-3 w-3 rounded-full bg-yellow-400/80" />
                            <span class="h-3 w-3 rounded-full bg-emerald-400/80" />
                            <span class="ml-auto font-mono text-xs text-muted-foreground">~/juan.dev</span>
                        </div>
                        <pre class="mt-4 overflow-x-auto text-sm leading-relaxed scrollbar-thin"><code><span class="text-[var(--juan-red-400)]">const</span> <span class="text-white">juan</span> = {
  <span class="text-emerald-400">name</span>: <span class="text-amber-300">'Juan Carlos Justiniano Coelho'</span>,
  <span class="text-emerald-400">role</span>: <span class="text-amber-300">'Full-Stack Developer'</span>,
  <span class="text-emerald-400">loves</span>: [<span class="text-amber-300">'Laravel'</span>, <span class="text-amber-300">'Vue'</span>, <span class="text-amber-300">'UX'</span>],
  <span class="text-emerald-400">mission</span>: <span class="text-amber-300">'ship premium, fast.'</span>,
  <span class="text-emerald-400">available</span>: <span class="text-[var(--juan-red-400)]">true</span>,
};</code></pre>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<style scoped>
pre { background: transparent; }
</style>
