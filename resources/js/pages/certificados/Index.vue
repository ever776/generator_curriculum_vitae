<script setup lang="ts">
import { Form, Head, router } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import {
    store,
    update,
    destroy,
} from '@/actions/App/Http/Controllers/CertificadoController';
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
import { index as certificadosRoute } from '@/routes/certificados';
import type { BreadcrumbItem } from '@/types';

interface Certificado {
    id: number;
    user_id: number;
    nombre: string;
    institucion: string;
    fecha_inicio: string;
    fecha_conclusion: string | null;
    duracion: number;
    pdf_path: string | null;
    created_at: string;
    updated_at: string;
    deleted_at: string | null;
}

interface Props {
    certificados: {
        data: Certificado[];
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

const selectedCertificado = ref<Certificado | null>(null);

const openEditModal = (certificado: Certificado) => {
    selectedCertificado.value = { ...certificado };
    showEditDialog.value = true;
};

const openDeleteModal = (certificado: Certificado) => {
    selectedCertificado.value = certificado;
    showDeleteDialog.value = true;
};

const formatDate = (date: string | null) => {
    if (!date) {
        return 'En curso';
    }

    return new Date(date).toLocaleDateString('es-ES', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
    });
};

const visiblePages = computed(() => {
    const current = props.certificados.current_page;
    const last = props.certificados.last_page;
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
        typeof certificadosRoute === 'function'
            ? certificadosRoute().url
            : certificadosRoute.url;
    router.get(url, { page, search: searchQuery.value });
};

const search = () => {
    const url =
        typeof certificadosRoute === 'function'
            ? certificadosRoute().url
            : certificadosRoute.url;
    router.get(url, { search: searchQuery.value, page: 1 }, { replace: true });
};

const clearSearch = () => {
    searchQuery.value = '';
    const url =
        typeof certificadosRoute === 'function'
            ? certificadosRoute().url
            : certificadosRoute.url;
    router.get(url, { search: '', page: 1 }, { replace: true });
};

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard(),
    },
    {
        title: 'Certificados',
        href: certificadosRoute(),
    },
];
</script>

<template>
    <Head title="Certificados" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="space-y-6">
            <div class="mr-4 ml-4 flex items-center justify-between">
                <Heading
                    variant="small"
                    title="Certificados"
                    description="Gestiona tus certificados y cursos"
                />
                <Dialog v-model:open="showCreateDialog">
                    <DialogTrigger as-child>
                        <Button>Agregar Certificado</Button>
                    </DialogTrigger>
                    <DialogContent>
                        <Form
                            :action="store()"
                            v-slot="{ errors, processing, clearErrors }"
                            @success="() => (showCreateDialog = false)"
                            class="space-y-6"
                        >
                            <DialogHeader class="space-y-3">
                                <DialogTitle>Nuevo Certificado</DialogTitle>
                                <DialogDescription>
                                    Ingresa los datos del certificado o curso.
                                </DialogDescription>
                            </DialogHeader>

                            <div class="grid gap-4">
                                <div class="grid gap-2">
                                    <Label for="nombre"
                                        >Nombre del curso/certificado</Label
                                    >
                                    <Input
                                        id="nombre"
                                        name="nombre"
                                        type="text"
                                        placeholder="Introducción a Laravel"
                                        required
                                    />
                                    <InputError :message="errors.nombre" />
                                </div>

                                <div class="grid gap-2">
                                    <Label for="institucion">Institución</Label>
                                    <Input
                                        id="institucion"
                                        name="institucion"
                                        type="text"
                                        placeholder="Platzi"
                                        required
                                    />
                                    <InputError :message="errors.institucion" />
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
                                            required
                                        />
                                        <InputError
                                            :message="errors.fecha_inicio"
                                        />
                                    </div>

                                    <div class="grid gap-2">
                                        <Label for="fecha_conclusion"
                                            >Fecha de conclusión</Label
                                        >
                                        <Input
                                            id="fecha_conclusion"
                                            name="fecha_conclusion"
                                            type="date"
                                        />
                                        <InputError
                                            :message="errors.fecha_conclusion"
                                        />
                                    </div>
                                </div>

                                <div class="grid gap-2">
                                    <Label for="duracion"
                                        >Duración (horas)</Label
                                    >
                                    <Input
                                        id="duracion"
                                        name="duracion"
                                        type="number"
                                        min="1"
                                        placeholder="40"
                                        required
                                    />
                                    <InputError :message="errors.duracion" />
                                </div>

                                <div class="grid gap-2">
                                    <Label for="pdf_path"
                                        >PDF del certificado</Label
                                    >
                                    <Input
                                        id="pdf_path"
                                        name="pdf_path"
                                        type="file"
                                        accept="application/pdf"
                                    />
                                    <InputError :message="errors.pdf_path" />
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
                        placeholder="Buscar por nombre o institución..."
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
                v-if="props.certificados.total === 0"
                class="py-12 text-center text-muted-foreground"
            >
                <p>No hay certificados registrados.</p>
                <p class="text-sm">
                    Haz clic en "Agregar Certificado" para comenzar.
                </p>
            </div>

            <div
                v-else-if="props.certificados.data.length > 0"
                class="space-y-4"
            >
                <div class="overflow-x-auto rounded-md border">
                    <table class="w-full whitespace-nowrap">
                        <thead class="bg-muted/50">
                            <tr>
                                <th
                                    class="px-4 py-3 text-left text-sm font-medium"
                                >
                                    Nombre
                                </th>
                                <th
                                    class="px-4 py-3 text-left text-sm font-medium"
                                >
                                    Institución
                                </th>
                                <th
                                    class="px-4 py-3 text-left text-sm font-medium"
                                >
                                    Fecha Inicio
                                </th>
                                <th
                                    class="px-4 py-3 text-left text-sm font-medium"
                                >
                                    Fecha Conclusión
                                </th>
                                <th
                                    class="px-4 py-3 text-left text-sm font-medium"
                                >
                                    Duración
                                </th>
                                <th
                                    class="px-4 py-3 text-left text-sm font-medium"
                                >
                                    PDF
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
                                v-for="certificado in props.certificados.data"
                                :key="certificado.id"
                                class="hover:bg-muted/50"
                            >
                                <td class="px-4 py-3 text-sm">
                                    {{ certificado.nombre }}
                                </td>
                                <td
                                    class="px-4 py-3 text-sm text-muted-foreground"
                                >
                                    {{ certificado.institucion }}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    {{ formatDate(certificado.fecha_inicio) }}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    {{
                                        formatDate(certificado.fecha_conclusion)
                                    }}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    {{ certificado.duracion }} hrs
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    <a
                                        v-if="certificado.pdf_path"
                                        :href="`/storage/${certificado.pdf_path}`"
                                        target="_blank"
                                        class="text-blue-600 hover:underline"
                                    >
                                        Ver PDF
                                    </a>
                                    <span v-else class="text-muted-foreground"
                                        >-</span
                                    >
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <div class="flex justify-end gap-1">
                                        <Button
                                            variant="ghost"
                                            size="icon"
                                            @click="openEditModal(certificado)"
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
                                                openDeleteModal(certificado)
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
                    v-if="props.certificados.last_page > 1"
                    class="flex items-center justify-between px-4 py-3"
                >
                    <div class="text-sm text-muted-foreground">
                        Mostrando {{ props.certificados.from }} a
                        {{ props.certificados.to }} de
                        {{ props.certificados.total }} resultados
                    </div>
                    <div class="flex gap-1">
                        <Button
                            variant="outline"
                            size="sm"
                            :disabled="props.certificados.current_page === 1"
                            @click="
                                changePage(props.certificados.current_page - 1)
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
                                    page === props.certificados.current_page,
                            }"
                            @click="changePage(page)"
                        >
                            {{ page }}
                        </Button>
                        <Button
                            variant="outline"
                            size="sm"
                            :disabled="
                                props.certificados.current_page ===
                                props.certificados.last_page
                            "
                            @click="
                                changePage(props.certificados.current_page + 1)
                            "
                        >
                            Siguiente
                        </Button>
                    </div>
                </div>
            </div>

            <!-- Edit Modal -->
            <Dialog v-model:open="showEditDialog">
                <DialogContent>
                    <Form
                        v-if="selectedCertificado"
                        :action="update(selectedCertificado.id)"
                        v-slot="{ errors, processing }"
                        @success="() => (showEditDialog = false)"
                        class="space-y-6"
                    >
                        <DialogHeader class="space-y-3">
                            <DialogTitle>Editar Certificado</DialogTitle>
                            <DialogDescription>
                                Actualiza los datos del certificado o curso.
                            </DialogDescription>
                        </DialogHeader>

                        <div class="grid gap-4">
                            <div class="grid gap-2">
                                <Label for="edit-nombre"
                                    >Nombre del curso/certificado</Label
                                >
                                <Input
                                    id="edit-nombre"
                                    name="nombre"
                                    type="text"
                                    :model-value="selectedCertificado.nombre"
                                    required
                                />
                                <InputError :message="errors.nombre" />
                            </div>

                            <div class="grid gap-2">
                                <Label for="edit-institucion"
                                    >Institución</Label
                                >
                                <Input
                                    id="edit-institucion"
                                    name="institucion"
                                    type="text"
                                    :model-value="
                                        selectedCertificado.institucion
                                    "
                                    required
                                />
                                <InputError :message="errors.institucion" />
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
                                            selectedCertificado.fecha_inicio
                                                ? selectedCertificado.fecha_inicio.split(
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
                                    <Label for="edit-fecha_conclusion"
                                        >Fecha de conclusión</Label
                                    >
                                    <Input
                                        id="edit-fecha_conclusion"
                                        name="fecha_conclusion"
                                        type="date"
                                        :model-value="
                                            selectedCertificado.fecha_conclusion
                                                ? selectedCertificado.fecha_conclusion.split(
                                                      'T',
                                                  )[0]
                                                : ''
                                        "
                                    />
                                    <InputError
                                        :message="errors.fecha_conclusion"
                                    />
                                </div>
                            </div>

                            <div class="grid gap-2">
                                <Label for="edit-duracion"
                                    >Duración (horas)</Label
                                >
                                <Input
                                    id="edit-duracion"
                                    name="duracion"
                                    type="number"
                                    min="1"
                                    :model-value="selectedCertificado.duracion"
                                    required
                                />
                                <InputError :message="errors.duracion" />
                            </div>

                            <div class="grid gap-2">
                                <Label for="edit-pdf_path"
                                    >PDF del certificado (opcional)</Label
                                >
                                <Input
                                    id="edit-pdf_path"
                                    name="pdf_path"
                                    type="file"
                                    accept="application/pdf"
                                />
                                <InputError :message="errors.pdf_path" />
                                <p
                                    v-if="selectedCertificado?.pdf_path"
                                    class="text-sm text-muted-foreground"
                                >
                                    Ya hay un PDF cargado. Sube uno nuevo para
                                    reemplazarlo.
                                </p>
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
                        v-if="selectedCertificado"
                        :action="destroy(selectedCertificado.id)"
                        v-slot="{ processing }"
                        @success="() => (showDeleteDialog = false)"
                        class="space-y-6"
                    >
                        <DialogHeader class="space-y-3">
                            <DialogTitle>Eliminar Certificado</DialogTitle>
                            <DialogDescription>
                                ¿Estás seguro de que deseas eliminar el
                                certificado "{{ selectedCertificado.nombre }}"?
                                Esta acción no se puede deshacer.
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
