<script setup lang="ts">
import { Head, router, useForm } from '@inertiajs/vue3';
import Button from 'primevue/button';
import Dialog from 'primevue/dialog';
import InputText from 'primevue/inputtext';
import Textarea from 'primevue/textarea';
import ToggleSwitch from 'primevue/toggleswitch';
import FileUpload from 'primevue/fileupload';
import AutoComplete from 'primevue/autocomplete';
import { route } from '@/lib/route';
import { useConfirm } from 'primevue/useconfirm';
import { useToast } from 'primevue/usetoast';
import { ref } from 'vue';

const props = defineProps<{ projects: any[] }>();

const toast = useToast();
const confirm = useConfirm();

const dialogOpen = ref(false);
const editing = ref<any>(null);

const form = useForm({
    title: '',
    description: '',
    long_description: '',
    technologies: [] as string[],
    project_url: '',
    github_url: '',
    demo_url: '',
    featured: false,
    published: true,
    image: null as File | null,
});

const openCreate = () => {
    editing.value = null;
    form.reset();
    form.technologies = [];
    form.published = true;
    dialogOpen.value = true;
};

const openEdit = (p: any) => {
    editing.value = p;
    form.title = p.title;
    form.description = p.description ?? '';
    form.long_description = p.long_description ?? '';
    form.technologies = p.technologies ?? [];
    form.project_url = p.project_url ?? '';
    form.github_url = p.github_url ?? '';
    form.demo_url = p.demo_url ?? '';
    form.featured = !!p.featured;
    form.published = !!p.published;
    form.image = null;
    dialogOpen.value = true;
};

const submit = () => {
    const url = editing.value ? route('admin.projects.update', editing.value.id) : route('admin.projects.store');
    form.post(url, {
        forceFormData: true,
        preserveScroll: true,
        onSuccess: () => {
            dialogOpen.value = false;
            toast.add({ severity: 'success', summary: editing.value ? 'Atualizado' : 'Criado', life: 2500 });
        },
    });
};

const remove = (p: any) => {
    confirm.require({
        message: `Remover o projeto "${p.title}"?`,
        header: 'Confirmar remoção',
        acceptLabel: 'Remover', rejectLabel: 'Cancelar',
        acceptClass: 'p-button-danger',
        accept: () => router.delete(route('admin.projects.destroy', p.id), { preserveScroll: true }),
    });
};

// Autocomplete pseudo de tecnologias
const techQuery = ref('');
const techOpts = ref<string[]>([]);
const searchTech = (event: any) => {
    const all = ['Laravel', 'Vue 3', 'PrimeVue', 'Tailwind', 'TypeScript', 'Inertia', 'PostgreSQL', 'MySQL', 'Redis', 'Docker', 'AWS', 'Node.js', 'Python', 'Django', 'Go', 'Rust', 'React', 'Nuxt'];
    techOpts.value = all.filter(t => t.toLowerCase().includes(event.query.toLowerCase()));
};
</script>

<template>
    <Head title="Projetos" />

    <div class="space-y-6">
        <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
            <div>
                <p class="text-xs font-bold uppercase tracking-[0.2em] text-[var(--juan-red-500)]">Portfólio</p>
                <h1 class="text-3xl font-black">Projetos</h1>
                <p class="mt-1 text-muted-foreground">Vitrine dos seus trabalhos em destaque.</p>
            </div>
            <Button label="Novo projeto" icon="pi pi-plus" @click="openCreate" class="!bg-[var(--juan-red-600)] !border-0 !text-white shadow-glow-red" />
        </div>

        <div v-if="projects.length" class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            <div v-for="p in projects" :key="p.id" class="overflow-hidden rounded-2xl border border-border bg-card hover-lift">
                <div class="relative aspect-video bg-gradient-to-br from-[var(--juan-red-500)]/20 to-[var(--juan-red-800)]/30">
                    <img v-if="p.image_url" :src="p.image_url" class="h-full w-full object-cover" />
                    <span v-if="p.featured" class="absolute left-3 top-3 rounded-full bg-[var(--juan-red-600)] px-2 py-0.5 text-[10px] font-bold uppercase text-white">Destaque</span>
                    <span v-if="!p.published" class="absolute right-3 top-3 rounded-full bg-black/70 px-2 py-0.5 text-[10px] font-bold uppercase text-white backdrop-blur">Rascunho</span>
                </div>
                <div class="p-4">
                    <h3 class="truncate font-bold">{{ p.title }}</h3>
                    <p v-if="p.description" class="mt-1 line-clamp-2 text-sm text-muted-foreground">{{ p.description }}</p>
                    <div class="mt-3 flex justify-end gap-1">
                        <Button icon="pi pi-pencil" text rounded @click="openEdit(p)" />
                        <Button icon="pi pi-trash" text rounded severity="danger" @click="remove(p)" />
                    </div>
                </div>
            </div>
        </div>

        <div v-else class="rounded-2xl border border-dashed border-border p-12 text-center text-muted-foreground">
            <i class="pi pi-briefcase text-4xl" />
            <p class="mt-3 font-semibold">Nenhum projeto cadastrado.</p>
        </div>
    </div>

    <Dialog v-model:visible="dialogOpen" :header="editing ? 'Editar projeto' : 'Novo projeto'" modal :style="{ width: '640px' }">
        <form class="space-y-4" @submit.prevent="submit">
            <div>
                <label class="mb-1 block text-sm font-semibold">Título *</label>
                <InputText v-model="form.title" class="w-full" />
            </div>
            <div>
                <label class="mb-1 block text-sm font-semibold">Descrição curta</label>
                <Textarea v-model="form.description" rows="2" class="w-full" />
            </div>
            <div>
                <label class="mb-1 block text-sm font-semibold">Descrição longa</label>
                <Textarea v-model="form.long_description" rows="4" class="w-full" />
            </div>
            <div>
                <label class="mb-1 block text-sm font-semibold">Tecnologias</label>
                <AutoComplete v-model="form.technologies" multiple :suggestions="techOpts" @complete="searchTech" class="w-full" placeholder="Laravel, Vue, ..." :typeahead="false" />
            </div>
            <div class="grid gap-3 sm:grid-cols-2">
                <div>
                    <label class="mb-1 block text-sm font-semibold">URL do projeto</label>
                    <InputText v-model="form.project_url" class="w-full" placeholder="https://..." />
                </div>
                <div>
                    <label class="mb-1 block text-sm font-semibold">URL do GitHub</label>
                    <InputText v-model="form.github_url" class="w-full" placeholder="https://github.com/..." />
                </div>
            </div>
            <div>
                <label class="mb-1 block text-sm font-semibold">Imagem de capa</label>
                <input type="file" accept="image/*" @change="(e: any) => form.image = e.target.files[0]" class="block w-full text-sm file:mr-3 file:rounded-lg file:border-0 file:bg-[var(--juan-red-600)] file:px-3 file:py-2 file:text-white" />
            </div>
            <div class="flex gap-6">
                <label class="flex items-center gap-2 text-sm"><ToggleSwitch v-model="form.featured" /> Destaque na home</label>
                <label class="flex items-center gap-2 text-sm"><ToggleSwitch v-model="form.published" /> Publicado</label>
            </div>
            <div class="flex justify-end gap-2 pt-2">
                <Button type="button" label="Cancelar" severity="secondary" text @click="dialogOpen = false" />
                <Button type="submit" :label="editing ? 'Salvar' : 'Criar projeto'" icon="pi pi-check" :loading="form.processing" class="!bg-[var(--juan-red-600)] !border-0 !text-white" />
            </div>
        </form>
    </Dialog>
</template>
