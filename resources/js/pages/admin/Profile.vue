<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';
import Button from 'primevue/button';
import InputText from 'primevue/inputtext';
import Textarea from 'primevue/textarea';
import AutoComplete from 'primevue/autocomplete';
import { route } from '@/lib/route';
import { ref } from 'vue';

const props = defineProps<{ profile: any }>();

const form = useForm({
    display_name: props.profile?.display_name ?? '',
    headline: props.profile?.headline ?? '',
    subtitle: props.profile?.subtitle ?? '',
    bio: props.profile?.bio ?? '',
    github_username: props.profile?.github_username ?? '',
    github_url: props.profile?.github_url ?? '',
    linkedin_url: props.profile?.linkedin_url ?? '',
    instagram_url: props.profile?.instagram_url ?? '',
    twitter_url: props.profile?.twitter_url ?? '',
    email_contact: props.profile?.email_contact ?? '',
    location: props.profile?.location ?? '',
    tech_stack: (props.profile?.tech_stack ?? []) as string[],
    experiences: (props.profile?.experiences ?? []) as any[],
    seo_title: props.profile?.seo_title ?? '',
    seo_description: props.profile?.seo_description ?? '',
    avatar: null as File | null,
});

const techOpts = ref<string[]>([]);
const searchTech = (e: any) => {
    const all = ['Laravel', 'Vue 3', 'PrimeVue', 'Tailwind', 'TypeScript', 'Inertia', 'PostgreSQL', 'MySQL', 'Redis', 'Docker', 'AWS', 'Node.js', 'Python', 'Go', 'Rust', 'React', 'Nuxt'];
    techOpts.value = all.filter(t => t.toLowerCase().includes(e.query.toLowerCase()));
};

const addExperience = () => form.experiences.push({ role: '', company: '', period: '', desc: '' });
const removeExperience = (i: number) => form.experiences.splice(i, 1);

const submit = () => form.post(route('admin.profile.update'), { forceFormData: true, preserveScroll: true });
</script>

<template>
    <Head title="Perfil" />

    <div class="space-y-6">
        <div>
            <p class="text-xs font-bold uppercase tracking-[0.2em] text-[var(--juan-red-500)]">Perfil</p>
            <h1 class="text-3xl font-black">Dados do portfólio</h1>
            <p class="mt-1 text-muted-foreground">Identidade, biografia, redes sociais e SEO.</p>
        </div>

        <form @submit.prevent="submit" class="grid gap-6 lg:grid-cols-[1fr_320px]">
            <div class="space-y-6">
                <!-- Identidade -->
                <section class="rounded-2xl border border-border bg-card p-6 space-y-4">
                    <h2 class="font-bold text-lg">Identidade</h2>
                    <div class="grid gap-3 sm:grid-cols-2">
                        <div>
                            <label class="mb-1 block text-sm font-semibold">Nome exibido *</label>
                            <InputText v-model="form.display_name" class="w-full" />
                        </div>
                        <div>
                            <label class="mb-1 block text-sm font-semibold">Localização</label>
                            <InputText v-model="form.location" class="w-full" placeholder="Brasil" />
                        </div>
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-semibold">Headline</label>
                        <InputText v-model="form.headline" class="w-full" placeholder="Full-Stack Developer" />
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-semibold">Subtítulo</label>
                        <InputText v-model="form.subtitle" class="w-full" />
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-semibold">Bio</label>
                        <Textarea v-model="form.bio" rows="4" class="w-full" />
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-semibold">Tech stack</label>
                        <AutoComplete v-model="form.tech_stack" multiple :suggestions="techOpts" @complete="searchTech" class="w-full" :typeahead="false" />
                    </div>
                </section>

                <!-- Redes -->
                <section class="rounded-2xl border border-border bg-card p-6 space-y-4">
                    <h2 class="font-bold text-lg">Redes e contato</h2>
                    <div class="grid gap-3 sm:grid-cols-2">
                        <div><label class="mb-1 block text-sm font-semibold">GitHub username</label><InputText v-model="form.github_username" class="w-full" placeholder="seu-user" /></div>
                        <div><label class="mb-1 block text-sm font-semibold">GitHub URL</label><InputText v-model="form.github_url" class="w-full" /></div>
                        <div><label class="mb-1 block text-sm font-semibold">LinkedIn</label><InputText v-model="form.linkedin_url" class="w-full" /></div>
                        <div><label class="mb-1 block text-sm font-semibold">Instagram</label><InputText v-model="form.instagram_url" class="w-full" /></div>
                        <div><label class="mb-1 block text-sm font-semibold">Twitter/X</label><InputText v-model="form.twitter_url" class="w-full" /></div>
                        <div><label class="mb-1 block text-sm font-semibold">E-mail de contato</label><InputText v-model="form.email_contact" class="w-full" /></div>
                    </div>
                </section>

                <!-- Experiências -->
                <section class="rounded-2xl border border-border bg-card p-6 space-y-4">
                    <div class="flex items-center justify-between">
                        <h2 class="font-bold text-lg">Experiências</h2>
                        <Button type="button" label="Adicionar" icon="pi pi-plus" size="small" outlined @click="addExperience" />
                    </div>
                    <div v-for="(exp, i) in form.experiences" :key="i" class="grid gap-2 rounded-xl border border-border p-4 sm:grid-cols-[1fr_1fr_auto]">
                        <InputText v-model="exp.role" placeholder="Cargo" />
                        <InputText v-model="exp.company" placeholder="Empresa" />
                        <InputText v-model="exp.period" placeholder="2024 — hoje" />
                        <Textarea v-model="exp.desc" rows="2" placeholder="Descrição" class="sm:col-span-2" />
                        <Button type="button" icon="pi pi-trash" severity="danger" text rounded @click="removeExperience(i)" />
                    </div>
                    <p v-if="!form.experiences.length" class="text-sm text-muted-foreground text-center py-4">Nenhuma experiência cadastrada.</p>
                </section>

                <!-- SEO -->
                <section class="rounded-2xl border border-border bg-card p-6 space-y-4">
                    <h2 class="font-bold text-lg">SEO</h2>
                    <div><label class="mb-1 block text-sm font-semibold">Title</label><InputText v-model="form.seo_title" class="w-full" /></div>
                    <div><label class="mb-1 block text-sm font-semibold">Description</label><Textarea v-model="form.seo_description" rows="2" class="w-full" /></div>
                </section>
            </div>

            <!-- Aside: avatar + actions -->
            <div class="space-y-4">
                <section class="rounded-2xl border border-border bg-card p-6">
                    <h2 class="font-bold text-lg">Avatar</h2>
                    <div class="mt-4 flex flex-col items-center gap-3">
                        <div class="grid h-32 w-32 place-items-center overflow-hidden rounded-2xl border border-border bg-gradient-to-br from-[var(--juan-red-500)]/30 to-[var(--juan-red-800)]/30">
                            <img v-if="profile?.avatar_url" :src="profile.avatar_url" class="h-full w-full object-cover" />
                            <span v-else class="text-4xl font-black text-white">{{ form.display_name?.[0] || 'J' }}</span>
                        </div>
                        <input type="file" accept="image/*" @change="(e: any) => form.avatar = e.target.files[0]" class="block w-full text-sm file:mr-3 file:rounded-lg file:border-0 file:bg-[var(--juan-red-600)] file:px-3 file:py-2 file:text-white" />
                    </div>
                </section>

                <Button type="submit" label="Salvar alterações" icon="pi pi-check" :loading="form.processing" class="w-full !bg-[var(--juan-red-600)] !border-0 !text-white shadow-glow-red" />
            </div>
        </form>
    </div>
</template>
