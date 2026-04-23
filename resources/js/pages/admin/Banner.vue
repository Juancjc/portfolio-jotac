<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';
import Button from 'primevue/button';
import InputText from 'primevue/inputtext';
import Textarea from 'primevue/textarea';
import Slider from 'primevue/slider';
import ToggleSwitch from 'primevue/toggleswitch';
import ColorPicker from 'primevue/colorpicker';
import { route } from '@/lib/route';
import { computed } from 'vue';

const props = defineProps<{ banner: any }>();

const form = useForm({
    title: props.banner?.title ?? '',
    subtitle: props.banner?.subtitle ?? '',
    cta_label: props.banner?.cta_label ?? '',
    cta_url: props.banner?.cta_url ?? '',
    overlay_color: props.banner?.overlay_color ?? '000000',
    overlay_opacity: props.banner?.overlay_opacity ?? 40,
    active: props.banner?.active ?? true,
    image: null as File | null,
});

const previewUrl = computed(() => props.banner?.image_url);
const overlayCss = computed(() => `#${form.overlay_color.replace('#', '')}`);

const submit = () => {
    form.post(route('admin.banner.update'), {
        forceFormData: true, preserveScroll: true,
    });
};
</script>

<template>
    <Head title="Banner" />

    <div class="space-y-6">
        <div>
            <p class="text-xs font-bold uppercase tracking-[0.2em] text-[var(--juan-red-500)]">Banner</p>
            <h1 class="text-3xl font-black">Banner de destaque</h1>
            <p class="mt-1 text-muted-foreground">Imagem + texto que aparecem no topo da landing page.</p>
        </div>

        <div class="grid gap-6 lg:grid-cols-[1.2fr_1fr]">
            <form class="space-y-5 rounded-2xl border border-border bg-card p-6" @submit.prevent="submit">
                <div>
                    <label class="mb-1 block text-sm font-semibold">Imagem do banner</label>
                    <input type="file" accept="image/*" @change="(e: any) => form.image = e.target.files[0]" class="block w-full text-sm file:mr-3 file:rounded-lg file:border-0 file:bg-[var(--juan-red-600)] file:px-3 file:py-2 file:text-white" />
                    <p class="mt-1 text-xs text-muted-foreground">JPG/PNG até 8MB. Recomendado: 1920x1080.</p>
                </div>

                <div>
                    <label class="mb-1 block text-sm font-semibold">Título</label>
                    <InputText v-model="form.title" class="w-full" placeholder="Disponível para novos projetos" />
                </div>
                <div>
                    <label class="mb-1 block text-sm font-semibold">Subtítulo</label>
                    <Textarea v-model="form.subtitle" rows="2" class="w-full" />
                </div>

                <div class="grid gap-3 sm:grid-cols-2">
                    <div>
                        <label class="mb-1 block text-sm font-semibold">Texto do CTA</label>
                        <InputText v-model="form.cta_label" class="w-full" placeholder="Saiba mais" />
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-semibold">Link do CTA</label>
                        <InputText v-model="form.cta_url" class="w-full" placeholder="https://..." />
                    </div>
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label class="mb-1 block text-sm font-semibold">Cor do overlay</label>
                        <div class="flex items-center gap-3">
                            <ColorPicker v-model="form.overlay_color" />
                            <InputText v-model="form.overlay_color" class="w-32" />
                        </div>
                    </div>
                    <div>
                        <label class="mb-1 flex justify-between text-sm font-semibold">
                            Opacidade do overlay <span class="text-muted-foreground">{{ form.overlay_opacity }}%</span>
                        </label>
                        <Slider v-model="form.overlay_opacity" :min="0" :max="100" />
                    </div>
                </div>

                <label class="flex items-center gap-2 text-sm"><ToggleSwitch v-model="form.active" /> Banner ativo</label>

                <div class="flex justify-end">
                    <Button type="submit" label="Salvar banner" icon="pi pi-check" :loading="form.processing" class="!bg-[var(--juan-red-600)] !border-0 !text-white" />
                </div>
            </form>

            <!-- Preview -->
            <div class="space-y-3">
                <p class="text-xs font-bold uppercase tracking-widest text-muted-foreground">Preview</p>
                <div class="relative overflow-hidden rounded-2xl border border-border bg-[#0a0a0d] aspect-[16/9]">
                    <img v-if="previewUrl" :src="previewUrl" class="absolute inset-0 h-full w-full object-cover" />
                    <div class="absolute inset-0" :style="{ background: overlayCss, opacity: form.overlay_opacity / 100 }" />
                    <div class="absolute inset-0 grid place-items-center p-6 text-white text-center">
                        <div>
                            <p class="text-lg font-black sm:text-xl">{{ form.title || 'Seu título aqui' }}</p>
                            <p class="mt-1 text-sm text-white/80">{{ form.subtitle || 'Subtítulo do banner' }}</p>
                            <span v-if="form.cta_label" class="mt-3 inline-block rounded-xl bg-[var(--juan-red-600)] px-4 py-2 text-xs font-semibold">{{ form.cta_label }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
