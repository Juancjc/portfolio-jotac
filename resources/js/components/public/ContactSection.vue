<script setup lang="ts">
defineProps<{
    profile: {
        display_name: string;
        email_contact?: string | null;
        github_url?: string | null;
        linkedin_url?: string | null;
        instagram_url?: string | null;
        twitter_url?: string | null;
    };
}>();
</script>

<template>
    <section id="contato" class="relative py-24">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
            <div class="relative overflow-hidden rounded-3xl border border-[var(--juan-red-500)]/20 bg-gradient-to-br from-[var(--juan-red-500)]/5 via-transparent to-[var(--juan-red-800)]/5 p-10 sm:p-14 text-center">
                <!-- Decor -->
                <div class="pointer-events-none absolute -right-20 -top-20 h-60 w-60 rounded-full bg-[var(--juan-red-500)]/20 blur-3xl" />
                <div class="pointer-events-none absolute -left-20 -bottom-20 h-72 w-72 rounded-full bg-[var(--juan-red-800)]/20 blur-3xl" />

                <p class="relative mb-2 text-xs font-bold uppercase tracking-[0.2em] text-[var(--juan-red-500)]">Vamos conversar?</p>
                <h2 class="relative text-3xl font-black sm:text-5xl">
                    Tem um projeto em mente?<br />
                    <span class="text-gradient-red">Vamos construir juntos.</span>
                </h2>
                <p class="relative mx-auto mt-4 max-w-lg text-muted-foreground">
                    Aberto para freelas, full-time, consultoria ou apenas um bom papo sobre tecnologia.
                </p>

                <div class="relative mt-8 flex flex-col items-center justify-center gap-3 sm:flex-row">
                    <a
                        v-if="profile.email_contact"
                        :href="`mailto:${profile.email_contact}`"
                        class="inline-flex items-center gap-2 rounded-2xl bg-gradient-to-r from-[var(--juan-red-600)] to-[var(--juan-red-800)] px-6 py-3 text-base font-bold text-white shadow-glow-red hover:brightness-110 transition"
                    >
                        <i class="pi pi-envelope" /> {{ profile.email_contact }}
                    </a>

                    <div class="flex gap-2">
                        <a v-if="profile.github_url"    :href="profile.github_url"    target="_blank" class="grid h-12 w-12 place-items-center rounded-2xl border border-border hover:border-[var(--juan-red-500)] hover:text-[var(--juan-red-500)] transition" aria-label="GitHub"><i class="pi pi-github" /></a>
                        <a v-if="profile.linkedin_url"  :href="profile.linkedin_url"  target="_blank" class="grid h-12 w-12 place-items-center rounded-2xl border border-border hover:border-[var(--juan-red-500)] hover:text-[var(--juan-red-500)] transition" aria-label="LinkedIn"><i class="pi pi-linkedin" /></a>
                        <a v-if="profile.instagram_url" :href="profile.instagram_url" target="_blank" class="grid h-12 w-12 place-items-center rounded-2xl border border-border hover:border-[var(--juan-red-500)] hover:text-[var(--juan-red-500)] transition" aria-label="Instagram"><i class="pi pi-instagram" /></a>
                        <a v-if="profile.twitter_url"   :href="profile.twitter_url"   target="_blank" class="grid h-12 w-12 place-items-center rounded-2xl border border-border hover:border-[var(--juan-red-500)] hover:text-[var(--juan-red-500)] transition" aria-label="Twitter/X"><i class="pi pi-twitter" /></a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
