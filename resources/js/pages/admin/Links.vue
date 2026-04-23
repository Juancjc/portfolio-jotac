<script setup lang="ts">
import { Head, router, useForm } from '@inertiajs/vue3';
import Button from 'primevue/button';
import Dialog from 'primevue/dialog';
import InputText from 'primevue/inputtext';
import Textarea from 'primevue/textarea';
import Select from 'primevue/select';
import ToggleSwitch from 'primevue/toggleswitch';
import { useToast } from 'primevue/usetoast';
import { useConfirm } from 'primevue/useconfirm';
import { ref } from 'vue';
import draggable from 'vuedraggable';
import { route } from '@/lib/route';

const props = defineProps<{ links: any[] }>();

const toast = useToast();
const confirm = useConfirm();

const dialogOpen = ref(false);
const editing = ref<any>(null);

const form = useForm({
    title: '',
    description: '',
    icon: '',
    type: 'external' as 'external' | 'internal',
    url: '',
    featured: false,
    active: true,
});

const typeOpts = [
    { label: 'Externo', value: 'external' },
    { label: 'Interno', value: 'internal' },
];

const iconSuggestions = [
    'pi pi-github', 'pi pi-linkedin', 'pi pi-instagram', 'pi pi-twitter',
    'pi pi-envelope', 'pi pi-file-pdf', 'pi pi-briefcase', 'pi pi-link',
    'pi pi-globe', 'pi pi-youtube', 'pi pi-facebook', 'pi pi-whatsapp',
];

const openCreate = () => {
    editing.value = null;
    form.reset();
    form.type = 'external';
    form.active = true;
    dialogOpen.value = true;
};

const openEdit = (l: any) => {
    editing.value = l;
    form.title = l.title;
    form.description = l.description ?? '';
    form.icon = l.icon ?? '';
    form.type = l.type;
    form.url = l.url;
    form.featured = !!l.featured;
    form.active = !!l.active;
    dialogOpen.value = true;
};

const submit = () => {
    if (editing.value) {
        form.put(route('admin.links.update', editing.value.id), {
            preserveScroll: true,
            onSuccess: () => { dialogOpen.value = false; toast.add({ severity: 'success', summary: 'Salvo', life: 2500 }); },
        });
    } else {
        form.post(route('admin.links.store'), {
            preserveScroll: true,
            onSuccess: () => { dialogOpen.value = false; toast.add({ severity: 'success', summary: 'Criado', life: 2500 }); },
        });
    }
};

const remove = (l: any) => {
    confirm.require({
        message: `Remover o link "${l.title}"?`,
        header: 'Confirmar remoção',
        acceptLabel: 'Remover', rejectLabel: 'Cancelar',
        acceptClass: 'p-button-danger',
        accept: () => router.delete(route('admin.links.destroy', l.id), { preserveScroll: true }),
    });
};

const localList = ref([...props.links]);
const onReorder = () => {
    const items = localList.value.map((l, i) => ({ id: l.id, sort_order: i + 1 }));
    router.post(route('admin.links.reorder'), { items } as any, { preserveScroll: true, preserveState: true });
};
</script>

<template>
    <Head title="Links" />

    <div class="space-y-6">
        <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
            <div>
                <p class="text-xs font-bold uppercase tracking-[0.2em] text-[var(--juan-red-500)]">Linktree</p>
                <h1 class="text-3xl font-black">Meus links</h1>
                <p class="mt-1 text-muted-foreground">Arraste para reordenar. Links em destaque aparecem com selo especial.</p>
            </div>
            <Button label="Novo link" icon="pi pi-plus" @click="openCreate" class="!bg-[var(--juan-red-600)] !border-0 !text-white shadow-glow-red" />
        </div>

        <div class="rounded-2xl border border-border bg-card p-4 sm:p-6">
            <draggable
                v-if="localList.length"
                v-model="localList"
                item-key="id"
                handle=".drag-handle"
                animation="200"
                ghost-class="opacity-40"
                @end="onReorder"
                class="space-y-3"
            >
                <template #item="{ element: l }">
                    <div class="flex items-center gap-3 rounded-xl border border-border bg-background p-3 transition hover:border-[var(--juan-red-500)]/40">
                        <button class="drag-handle grid h-9 w-9 cursor-grab place-items-center rounded-lg hover:bg-muted active:cursor-grabbing">
                            <i class="pi pi-bars text-muted-foreground" />
                        </button>
                        <span class="grid h-10 w-10 place-items-center rounded-lg bg-[var(--juan-red-500)]/10 text-[var(--juan-red-500)]">
                            <i :class="l.icon || 'pi pi-link'" />
                        </span>
                        <div class="min-w-0 flex-1">
                            <div class="flex items-center gap-2">
                                <p class="truncate font-semibold">{{ l.title }}</p>
                                <span v-if="l.featured" class="rounded-full bg-amber-500/15 px-1.5 py-0.5 text-[10px] font-bold uppercase text-amber-500">Destaque</span>
                                <span v-if="!l.active" class="rounded-full bg-muted px-1.5 py-0.5 text-[10px] font-bold uppercase text-muted-foreground">Inativo</span>
                            </div>
                            <p class="truncate text-xs text-muted-foreground">{{ l.type === 'internal' ? '[interno]' : '' }} {{ l.url }}</p>
                        </div>
                        <span class="hidden sm:block rounded-full bg-muted px-2.5 py-0.5 text-xs">{{ l.clicks }} clicks</span>
                        <Button icon="pi pi-pencil" text rounded @click="openEdit(l)" />
                        <Button icon="pi pi-trash" text rounded severity="danger" @click="remove(l)" />
                    </div>
                </template>
            </draggable>
            <div v-else class="rounded-xl border border-dashed border-border p-10 text-center text-muted-foreground">
                <i class="pi pi-link text-3xl" />
                <p class="mt-3 font-semibold">Nenhum link cadastrado ainda.</p>
            </div>
        </div>
    </div>

    <!-- Dialog -->
    <Dialog
        v-model:visible="dialogOpen"
        :header="editing ? 'Editar link' : 'Novo link'"
        modal :style="{ width: '540px' }" :dismissable-mask="true"
    >
        <form class="space-y-4" @submit.prevent="submit">
            <div>
                <label class="mb-1 block text-sm font-semibold">Título *</label>
                <InputText v-model="form.title" class="w-full" />
                <p v-if="form.errors.title" class="mt-1 text-xs text-red-500">{{ form.errors.title }}</p>
            </div>
            <div>
                <label class="mb-1 block text-sm font-semibold">Descrição</label>
                <Textarea v-model="form.description" rows="2" class="w-full" />
            </div>
            <div class="grid gap-3 sm:grid-cols-2">
                <div>
                    <label class="mb-1 block text-sm font-semibold">Tipo *</label>
                    <Select v-model="form.type" :options="typeOpts" option-label="label" option-value="value" class="w-full" />
                </div>
                <div>
                    <label class="mb-1 block text-sm font-semibold">URL / rota *</label>
                    <InputText v-model="form.url" class="w-full" :placeholder="form.type === 'internal' ? 'home' : 'https://...'" />
                </div>
            </div>
            <div>
                <label class="mb-1 block text-sm font-semibold">Ícone (classe PrimeIcons)</label>
                <InputText v-model="form.icon" class="w-full" placeholder="pi pi-github" />
                <div class="mt-2 flex flex-wrap gap-2">
                    <button
                        v-for="ic in iconSuggestions" :key="ic" type="button"
                        @click="form.icon = ic"
                        class="grid h-9 w-9 place-items-center rounded-lg border border-border hover:border-[var(--juan-red-500)]"
                    ><i :class="ic" /></button>
                </div>
            </div>
            <div class="flex gap-6">
                <label class="flex items-center gap-2 text-sm">
                    <ToggleSwitch v-model="form.featured" /> Destaque
                </label>
                <label class="flex items-center gap-2 text-sm">
                    <ToggleSwitch v-model="form.active" /> Ativo
                </label>
            </div>

            <div class="flex justify-end gap-2 pt-2">
                <Button type="button" label="Cancelar" severity="secondary" text @click="dialogOpen = false" />
                <Button type="submit" :label="editing ? 'Salvar' : 'Criar link'" icon="pi pi-check" :loading="form.processing" class="!bg-[var(--juan-red-600)] !border-0 !text-white" />
            </div>
        </form>
    </Dialog>
</template>
