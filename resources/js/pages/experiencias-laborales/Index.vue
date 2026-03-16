<script setup lang="ts">
import { Form, Head, router } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import {
    store,
    update,
    destroy,
} from '@/actions/App/Http/Controllers/ExperienciaLaboralController';
import Heading from '@/components/Heading.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import {
    Dialog,
    DialogClose,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from '@/components/ui/dialog';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { index as experienciasLaboralesRoute } from '@/routes/experiencias-laborales';
import type { BreadcrumbItem } from '@/types';

interface ExperienciaLaboral {
    id: number;
    user_id: number;
    entidad: string;
    puesto: string;
    descripcion: string;
    direccion: string;
    fecha_inicio: string;
    fecha_final: string | null;
    duracion: number | null;
    pdfs: string[] | null;
    created_at: string;
    updated_at: string;
    deleted_at: string | null;
}

interface Props {
    experiencias: {
        data: ExperienciaLaboral[];
        current_page: number;
        last_page: number;
        total: number;
        from: number;
        to: number;
    };
    filters?: {
        search?: string;
    };
}

const props = defineProps<Props>();

const searchQuery = ref(props.filters?.search || '');

const showCreateDialog = ref(false);
const showEditDialog = ref(false);
const showDeleteDialog = ref(false);

const selectedExperiencia = ref<ExperienciaLaboral | null>(null);

const openEditModal = (experiencia: ExperienciaLaboral) => {
    selectedExperiencia.value = { ...experiencia };
    showEditDialog.value = true;
};

const openDeleteModal = (experiencia: ExperienciaLaboral) => {
    selectedExperiencia.value = experiencia;
    showDeleteDialog.value = true;
};

const formatDate = (date: string | null) => {
    if (!date) {
        return 'Actualmente';
    }

    return new Date(date).toLocaleDateString('es-ES', {
        year: 'numeric',
        month: '2-digit',
        day: '2-digit',
    });
};

const formatDuration = (months: number | null) => {
    if (!months) {
        return '-';
    }

    const years = Math.floor(months / 12);
    const remainingMonths = months % 12;

    if (years > 0 && remainingMonths > 0) {
        return `${years} año(s) ${remainingMonths} mes(es)`;
    } else if (years > 0) {
        return `${years} año(s)`;
    } else {
        return `${remainingMonths} mes(es)`;
    }
};

const visiblePages = computed(() => {
    const current = props.experiencias.current_page;
    const last = props.experiencias.last_page;
    const pages: number[] = [];
    const delta = 2;

    let start = Math.max(1, current - delta);
    let end = Math.min(last, current + delta);

    if (current - delta < 1) {
        end = Math.min(last, end + (delta - current + 1));
    }

    if (current + delta > last) {
        start = Math.max(1, start - (current + delta - last));
    }

    for (let i = start; i <= end; i++) {
        pages.push(i);
    }

    return pages;
});

const changePage = (page: number) => {
    const url =
        typeof experienciasLaboralesRoute === 'function'
            ? experienciasLaboralesRoute().url
            : experienciasLaboralesRoute.url;
    router.get(url, { page, search: searchQuery.value });
};

const search = () => {
    const url =
        typeof experienciasLaboralesRoute === 'function'
            ? experienciasLaboralesRoute().url
            : experienciasLaboralesRoute.url;
    router.get(url, { search: searchQuery.value, page: 1 }, { replace: true });
};

const clearSearch = () => {
    searchQuery.value = '';
    const url =
        typeof experienciasLaboralesRoute === 'function'
            ? experienciasLaboralesRoute().url
            : experienciasLaboralesRoute.url;
    router.get(url, { search: '', page: 1 }, { replace: true });
};

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard(),
    },
    {
        title: 'Experiencias Laborales',
        href: experienciasLaboralesRoute(),
    },
];
</script>

<template>
    <Head title="Experiencias Laborales" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="space-y-6">
            <div class="mr-4 ml-4 flex items-center justify-between">
                <Heading
                    variant="small"
                    title="Experiencias Laborales"
                    description="Gestiona tu historial laboral"
                />
                <Dialog v-model:open="showCreateDialog">
                    <DialogTrigger as-child>
                        <Button>Agregar Experiencia</Button>
                    </DialogTrigger>
                    <DialogContent class="max-h-[70vh] overflow-y-auto">
                        <Form
                            :action="store()"
                            v-slot="{ errors, processing, clearErrors }"
                            @success="() => (showCreateDialog = false)"
                            class="space-y-6"
                        >
                            <DialogHeader class="space-y-3">
                                <DialogTitle
                                    >Nueva Experiencia Laboral</DialogTitle
                                >
                                <DialogDescription>
                                    Ingresa los datos de tu experiencia laboral.
                                </DialogDescription>
                            </DialogHeader>

                            <div class="grid gap-4">
                                <div class="grid gap-2">
                                    <Label for="entidad">Entidad</Label>
                                    <Input
                                        id="entidad"
                                        name="entidad"
                                        type="text"
                                        placeholder="Nombre de la empresa"
                                    />
                                    <InputError :message="errors.entidad" />
                                </div>

                                <div class="grid gap-2">
                                    <Label for="puesto">Puesto</Label>
                                    <Input
                                        id="puesto"
                                        name="puesto"
                                        type="text"
                                        placeholder="Desarrollador Full Stack"
                                    />
                                    <InputError :message="errors.puesto" />
                                </div>

                                <div class="grid gap-2">
                                    <Label for="descripcion"
                                        >Descripción de funciones</Label
                                    >
                                    <Input
                                        id="descripcion"
                                        name="descripcion"
                                        type="text"
                                        placeholder="Breve descripción de tus funciones..."
                                    />
                                    <InputError :message="errors.descripcion" />
                                </div>

                                <div class="grid gap-2">
                                    <Label for="direccion">Dirección</Label>
                                    <Input
                                        id="direccion"
                                        name="direccion"
                                        type="text"
                                        placeholder="Ciudad, País"
                                    />
                                    <InputError :message="errors.direccion" />
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div class="grid gap-2">
                                        <Label for="fecha_inicio"
                                            >Fecha de inicio</Label
                                        >
                                        <Input
                                            id="fecha_inicio"
                                            name="fecha_inicio"
                                            type="date"
                                        />
                                        <InputError
                                            :message="errors.fecha_inicio"
                                        />
                                    </div>

                                    <div class="grid gap-2">
                                        <Label for="fecha_final"
                                            >Fecha final</Label
                                        >
                                        <Input
                                            id="fecha_final"
                                            name="fecha_final"
                                            type="date"
                                        />
                                        <p
                                            class="text-xs text-muted-foreground"
                                        >
                                            Dejar vacío si es trabajo actual
                                        </p>
                                        <InputError
                                            :message="errors.fecha_final"
                                        />
                                    </div>
                                </div>

                                <div class="grid gap-2">
                                    <Label for="pdfs">PDFs (máximo 5)</Label>
                                    <input
                                        id="pdfs"
                                        name="pdfs[]"
                                        type="file"
                                        accept="application/pdf"
                                        multiple
                                        class="h-9 w-full min-w-0 rounded-md border border-input bg-transparent px-3 py-1 text-base shadow-xs transition-[color,box-shadow] outline-none selection:bg-primary selection:text-primary-foreground file:inline-flex file:h-7 file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground disabled:pointer-events-none disabled:cursor-not-allowed disabled:opacity-50 md:text-sm dark:bg-input/30"
                                    />
                                    <p class="text-xs text-muted-foreground">
                                        Selecciona hasta 5 archivos PDF
                                        (opcional)
                                    </p>
                                    <InputError :message="errors.pdfs" />
                                </div>
                            </div>

                            <DialogFooter class="gap-2">
                                <DialogClose as-child>
                                    <Button
                                        variant="secondary"
                                        @click="clearErrors"
                                    >
                                        Cancelar
                                    </Button>
                                </DialogClose>
                                <Button type="submit" :disabled="processing">
                                    Guardar
                                </Button>
                            </DialogFooter>
                        </Form>
                    </DialogContent>
                </Dialog>
            </div>

            <!-- Buscador -->
            <div class="mr-4 ml-4">
                <div class="relative">
                    <Input
                        v-model="searchQuery"
                        type="text"
                        placeholder="Buscar por entidad o puesto..."
                        class="w-1/2 pl-10"
                        @keyup.enter="search"
                    />
                    <svg
                        class="absolute top-1/2 left-3 h-4 w-4 -translate-y-1/2 text-muted-foreground"
                        xmlns="http://www.w3.org/2000/svg"
                        width="24"
                        height="24"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >
                        <circle cx="11" cy="11" r="8" />
                        <path d="m21 21-4.3-4.3" />
                    </svg>
                    <Button
                        v-if="searchQuery"
                        variant="ghost"
                        size="icon"
                        class="absolute top-1/2 right-0 h-8 w-8 -translate-y-1/2"
                        @click="clearSearch"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="16"
                            height="16"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        >
                            <path d="M18 6 6 18" />
                            <path d="m6 6 12 12" />
                        </svg>
                    </Button>
                </div>
            </div>

            <div
                v-if="props.experiencias.total === 0"
                class="py-12 text-center text-muted-foreground"
            >
                <p>No hay experiencias laborales registradas.</p>
                <p class="text-sm">
                    Haz clic en "Agregar Experiencia" para comenzar.
                </p>
            </div>

            <div
                v-else-if="props.experiencias.data.length > 0"
                class="space-y-4"
            >
                <div class="overflow-x-auto rounded-md border">
                    <table class="w-full whitespace-nowrap">
                        <thead class="bg-muted/50">
                            <tr>
                                <th
                                    class="px-4 py-3 text-left text-sm font-medium"
                                >
                                    Entidad
                                </th>
                                <th
                                    class="px-4 py-3 text-left text-sm font-medium"
                                >
                                    Puesto
                                </th>
                                <th
                                    class="px-4 py-3 text-left text-sm font-medium"
                                >
                                    Descripción
                                </th>
                                <th
                                    class="px-4 py-3 text-left text-sm font-medium"
                                >
                                    Dirección
                                </th>
                                <th
                                    class="px-4 py-3 text-left text-sm font-medium"
                                >
                                    Inicio
                                </th>
                                <th
                                    class="px-4 py-3 text-left text-sm font-medium"
                                >
                                    Final
                                </th>
                                <th
                                    class="px-4 py-3 text-left text-sm font-medium"
                                >
                                    Duración
                                </th>
                                <th
                                    class="px-4 py-3 text-left text-sm font-medium"
                                >
                                    PDFs
                                </th>
                                <th
                                    class="px-4 py-3 text-right text-sm font-medium"
                                >
                                    Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            <tr
                                v-for="experiencia in props.experiencias.data"
                                :key="experiencia.id"
                                class="hover:bg-muted/50"
                            >
                                <td class="px-4 py-3 text-sm">
                                    {{ experiencia.entidad }}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    {{ experiencia.puesto }}
                                </td>
                                <td class="max-w-xs truncate px-4 py-3 text-sm">
                                    {{ experiencia.descripcion }}
                                </td>
                                <td
                                    class="px-4 py-3 text-sm text-muted-foreground"
                                >
                                    {{ experiencia.direccion }}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    {{ formatDate(experiencia.fecha_inicio) }}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    {{ formatDate(experiencia.fecha_final) }}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    {{ formatDuration(experiencia.duracion) }}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    <span
                                        v-if="
                                            !experiencia.pdfs ||
                                            experiencia.pdfs.length === 0
                                        "
                                        class="text-muted-foreground"
                                        >-</span
                                    >
                                    <div v-else class="flex flex-wrap gap-2">
                                        <a
                                            v-for="(
                                                pdf, index
                                            ) in experiencia.pdfs"
                                            :key="index"
                                            :href="`/storage/${pdf}`"
                                            target="_blank"
                                            class="text-blue-600 hover:underline"
                                        >
                                            Ver PDF {{ index + 1 }}
                                        </a>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <div class="flex justify-end gap-1">
                                        <Button
                                            variant="ghost"
                                            size="icon"
                                            @click="openEditModal(experiencia)"
                                        >
                                            <span class="sr-only">Editar</span>
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                width="16"
                                                height="16"
                                                viewBox="0 0 24 24"
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="2"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                            >
                                                <path
                                                    d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"
                                                />
                                                <path d="m15 5 4 4" />
                                            </svg>
                                        </Button>
                                        <Button
                                            variant="ghost"
                                            size="icon"
                                            @click="
                                                openDeleteModal(experiencia)
                                            "
                                        >
                                            <span class="sr-only"
                                                >Eliminar</span
                                            >
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                width="16"
                                                height="16"
                                                viewBox="0 0 24 24"
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="2"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                            >
                                                <path d="M3 6h18" />
                                                <path
                                                    d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"
                                                />
                                                <path
                                                    d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"
                                                />
                                            </svg>
                                        </Button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Paginación -->
                <div
                    v-if="props.experiencias.last_page > 1"
                    class="flex items-center justify-between px-4 py-3"
                >
                    <div class="text-sm text-muted-foreground">
                        Mostrando {{ props.experiencias.from }} a
                        {{ props.experiencias.to }} de
                        {{ props.experiencias.total }} resultados
                    </div>
                    <div class="flex gap-1">
                        <Button
                            variant="outline"
                            size="sm"
                            :disabled="props.experiencias.current_page === 1"
                            @click="
                                changePage(props.experiencias.current_page - 1)
                            "
                        >
                            Anterior
                        </Button>
                        <Button
                            v-for="page in visiblePages"
                            :key="page"
                            variant="outline"
                            size="sm"
                            :class="{
                                'bg-muted':
                                    page === props.experiencias.current_page,
                            }"
                            @click="changePage(page)"
                        >
                            {{ page }}
                        </Button>
                        <Button
                            variant="outline"
                            size="sm"
                            :disabled="
                                props.experiencias.current_page ===
                                props.experiencias.last_page
                            "
                            @click="
                                changePage(props.experiencias.current_page + 1)
                            "
                        >
                            Siguiente
                        </Button>
                    </div>
                </div>
            </div>

            <!-- Edit Modal -->
            <Dialog v-model:open="showEditDialog">
                <DialogContent class="max-h-[70vh] overflow-y-auto">
                    <Form
                        v-if="selectedExperiencia"
                        :action="update(selectedExperiencia.id)"
                        v-slot="{ errors, processing }"
                        @success="() => (showEditDialog = false)"
                        class="space-y-6"
                    >
                        <DialogHeader class="space-y-3">
                            <DialogTitle
                                >Editar Experiencia Laboral</DialogTitle
                            >
                            <DialogDescription>
                                Actualiza los datos de tu experiencia laboral.
                            </DialogDescription>
                        </DialogHeader>

                        <div class="grid gap-4">
                            <div class="grid gap-2">
                                <Label for="edit-entidad">Entidad</Label>
                                <Input
                                    id="edit-entidad"
                                    name="entidad"
                                    type="text"
                                    :model-value="selectedExperiencia.entidad"
                                    required
                                />
                                <InputError :message="errors.entidad" />
                            </div>

                            <div class="grid gap-2">
                                <Label for="edit-puesto">Puesto</Label>
                                <Input
                                    id="edit-puesto"
                                    name="puesto"
                                    type="text"
                                    :model-value="selectedExperiencia.puesto"
                                    required
                                />
                                <InputError :message="errors.puesto" />
                            </div>

                            <div class="grid gap-2">
                                <Label for="edit-descripcion"
                                    >Descripción de funciones</Label
                                >
                                <Input
                                    id="edit-descripcion"
                                    name="descripcion"
                                    type="text"
                                    :model-value="
                                        selectedExperiencia.descripcion
                                    "
                                    required
                                />
                                <InputError :message="errors.descripcion" />
                            </div>

                            <div class="grid gap-2">
                                <Label for="edit-direccion">Dirección</Label>
                                <Input
                                    id="edit-direccion"
                                    name="direccion"
                                    type="text"
                                    :model-value="selectedExperiencia.direccion"
                                    required
                                />
                                <InputError :message="errors.direccion" />
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div class="grid gap-2">
                                    <Label for="edit-fecha_inicio"
                                        >Fecha de inicio</Label
                                    >
                                    <Input
                                        id="edit-fecha_inicio"
                                        name="fecha_inicio"
                                        type="date"
                                        :model-value="
                                            selectedExperiencia.fecha_inicio
                                                ? selectedExperiencia.fecha_inicio.split(
                                                      'T',
                                                  )[0]
                                                : ''
                                        "
                                        required
                                    />
                                    <InputError
                                        :message="errors.fecha_inicio"
                                    />
                                </div>

                                <div class="grid gap-2">
                                    <Label for="edit-fecha_final"
                                        >Fecha final</Label
                                    >
                                    <Input
                                        id="edit-fecha_final"
                                        name="fecha_final"
                                        type="date"
                                        :model-value="
                                            selectedExperiencia.fecha_final
                                                ? selectedExperiencia.fecha_final.split(
                                                      'T',
                                                  )[0]
                                                : ''
                                        "
                                    />
                                    <p class="text-xs text-muted-foreground">
                                        Dejar vacío si es trabajo actual
                                    </p>
                                    <InputError :message="errors.fecha_final" />
                                </div>
                            </div>

                            <div class="grid gap-2">
                                <Label for="edit-pdfs">PDFs (máximo 5)</Label>
                                <input
                                    id="edit-pdfs"
                                    name="pdfs[]"
                                    type="file"
                                    accept="application/pdf"
                                    multiple
                                    class="h-9 w-full min-w-0 rounded-md border border-input bg-transparent px-3 py-1 text-base shadow-xs transition-[color,box-shadow] outline-none selection:bg-primary selection:text-primary-foreground file:inline-flex file:h-7 file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground disabled:pointer-events-none disabled:cursor-not-allowed disabled:opacity-50 md:text-sm dark:bg-input/30"
                                />
                                <p class="text-xs text-muted-foreground">
                                    Selecciona hasta 5 archivos PDF
                                </p>
                                <div
                                    v-if="
                                        selectedExperiencia?.pdfs &&
                                        selectedExperiencia.pdfs.length > 0
                                    "
                                    class="mt-2"
                                >
                                    <p class="text-sm font-medium">
                                        PDFs actuales:
                                    </p>
                                    <ul class="mt-1 text-sm">
                                        <li
                                            v-for="(
                                                pdf, index
                                            ) in selectedExperiencia.pdfs"
                                            :key="index"
                                        >
                                            <a
                                                :href="`/storage/${pdf}`"
                                                target="_blank"
                                                class="text-blue-600 hover:underline"
                                            >
                                                PDF {{ index + 1 }}
                                            </a>
                                        </li>
                                    </ul>
                                    <p
                                        class="mt-1 text-xs text-muted-foreground"
                                    >
                                        Sube nuevos PDFs para agregarlos (máx. 5
                                        total)
                                    </p>
                                </div>
                                <InputError :message="errors.pdfs" />
                            </div>
                        </div>

                        <DialogFooter class="gap-2">
                            <DialogClose as-child>
                                <Button variant="secondary">Cancelar</Button>
                            </DialogClose>
                            <Button type="submit" :disabled="processing">
                                Actualizar
                            </Button>
                        </DialogFooter>
                    </Form>
                </DialogContent>
            </Dialog>

            <!-- Delete Modal -->
            <Dialog v-model:open="showDeleteDialog">
                <DialogContent>
                    <Form
                        v-if="selectedExperiencia"
                        :action="destroy(selectedExperiencia.id)"
                        v-slot="{ processing }"
                        @success="() => (showDeleteDialog = false)"
                        class="space-y-6"
                    >
                        <DialogHeader class="space-y-3">
                            <DialogTitle
                                >Eliminar Experiencia Laboral</DialogTitle
                            >
                            <DialogDescription>
                                ¿Estás seguro de que deseas eliminar la
                                experiencia "{{ selectedExperiencia.puesto }} en
                                {{ selectedExperiencia.entidad }}"? Esta acción
                                no se puede deshacer.
                            </DialogDescription>
                        </DialogHeader>

                        <DialogFooter class="gap-2">
                            <DialogClose as-child>
                                <Button variant="secondary">Cancelar</Button>
                            </DialogClose>
                            <Button
                                type="submit"
                                variant="destructive"
                                :disabled="processing"
                            >
                                Eliminar
                            </Button>
                        </DialogFooter>
                    </Form>
                </DialogContent>
            </Dialog>
        </div>
    </AppLayout>
</template>
