<script setup lang="ts">
import { Form, Head } from "@inertiajs/vue3";
import { ref } from "vue";
import {
  store,
  update,
  destroy,
} from "@/actions/App/Http/Controllers/CertificadoController";
import Heading from "@/components/Heading.vue";
import InputError from "@/components/InputError.vue";
import { Button } from "@/components/ui/button";
import {
  Dialog,
  DialogClose,
  DialogContent,
  DialogDescription,
  DialogFooter,
  DialogHeader,
  DialogTitle,
  DialogTrigger,
} from "@/components/ui/dialog";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import AppLayout from "@/layouts/AppLayout.vue";
import { dashboard } from "@/routes";
import { index as certificadosRoute } from "@/routes/certificados";
import type { BreadcrumbItem } from "@/types";

interface Certificado {
  id: number;
  nombre: string;
  institucion: string;
  fecha_inicio: string;
  fecha_conclusion: string | null;
  duracion: number;
  created_at: string;
  updated_at: string;
  deleted_at: string | null;
}

interface Props {
  certificados: Certificado[];
}

const props = defineProps<Props>();

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
    return "En curso";
  }

  return new Date(date).toLocaleDateString("es-ES", {
    year: "numeric",
    month: "long",
    day: "numeric",
  });
};

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: "Dashboard",
    href: dashboard(),
  },
  {
    title: "Certificados",
    href: certificadosRoute(),
  },
];
</script>

<template>
  <Head title="Certificados" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="space-y-6">
      <div class="flex items-center justify-between">
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
                  <Label for="nombre">Nombre del curso/certificado</Label>
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
                    <Label for="fecha_inicio">Fecha de inicio</Label>
                    <Input id="fecha_inicio" name="fecha_inicio" type="date" required />
                    <InputError :message="errors.fecha_inicio" />
                  </div>

                  <div class="grid gap-2">
                    <Label for="fecha_conclusion">Fecha de conclusión</Label>
                    <Input id="fecha_conclusion" name="fecha_conclusion" type="date" />
                    <InputError :message="errors.fecha_conclusion" />
                  </div>
                </div>

                <div class="grid gap-2">
                  <Label for="duracion">Duración (horas)</Label>
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
              </div>

              <DialogFooter class="gap-2">
                <DialogClose as-child>
                  <Button variant="secondary" @click="clearErrors"> Cancelar </Button>
                </DialogClose>
                <Button type="submit" :disabled="processing"> Guardar </Button>
              </DialogFooter>
            </Form>
          </DialogContent>
        </Dialog>
      </div>

      <div
        v-if="props.certificados.length === 0"
        class="py-12 text-center text-muted-foreground"
      >
        <p>No hay certificados registrados.</p>
        <p class="text-sm">Haz clic en "Agregar Certificado" para comenzar.</p>
      </div>

      <div v-else class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
        <div
          v-for="certificado in props.certificados"
          :key="certificado.id"
          class="rounded-lg border bg-card p-6 text-card-foreground shadow-sm"
        >
          <div class="flex items-start justify-between space-x-4">
            <div class="space-y-2">
              <h3 class="font-semibold">
                {{ certificado.nombre }}
              </h3>
              <p class="text-sm text-muted-foreground">
                {{ certificado.institucion }}
              </p>
            </div>
            <div class="flex gap-1">
              <Button variant="ghost" size="icon" @click="openEditModal(certificado)">
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
                  <path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z" />
                  <path d="m15 5 4 4" />
                </svg>
              </Button>
              <Button variant="ghost" size="icon" @click="openDeleteModal(certificado)">
                <span class="sr-only">Eliminar</span>
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
                  <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6" />
                  <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2" />
                </svg>
              </Button>
            </div>
          </div>
          <div class="mt-4 space-y-1 text-sm">
            <p>
              <span class="font-medium">Período:</span>
              {{ formatDate(certificado.fecha_inicio) }} -
              {{ formatDate(certificado.fecha_conclusion) }}
            </p>
            <p>
              <span class="font-medium">Duración:</span>
              {{ certificado.duracion }} horas
            </p>
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
                <Label for="edit-nombre">Nombre del curso/certificado</Label>
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
                <Label for="edit-institucion">Institución</Label>
                <Input
                  id="edit-institucion"
                  name="institucion"
                  type="text"
                  :model-value="selectedCertificado.institucion"
                  required
                />
                <InputError :message="errors.institucion" />
              </div>

              <div class="grid grid-cols-2 gap-4">
                <div class="grid gap-2">
                  <Label for="edit-fecha_inicio">Fecha de inicio</Label>
                  <Input
                    id="edit-fecha_inicio"
                    name="fecha_inicio"
                    type="date"
                    :model-value="
                      selectedCertificado.fecha_inicio
                        ? selectedCertificado.fecha_inicio.split('T')[0]
                        : ''
                    "
                    required
                  />
                  <InputError :message="errors.fecha_inicio" />
                </div>

                <div class="grid gap-2">
                  <Label for="edit-fecha_conclusion">Fecha de conclusión</Label>
                  <Input
                    id="edit-fecha_conclusion"
                    name="fecha_conclusion"
                    type="date"
                    :model-value="
                      selectedCertificado.fecha_conclusion
                        ? selectedCertificado.fecha_conclusion.split('T')[0]
                        : ''
                    "
                  />
                  <InputError :message="errors.fecha_conclusion" />
                </div>
              </div>

              <div class="grid gap-2">
                <Label for="edit-duracion">Duración (horas)</Label>
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
            </div>

            <DialogFooter class="gap-2">
              <DialogClose as-child>
                <Button variant="secondary">Cancelar</Button>
              </DialogClose>
              <Button type="submit" :disabled="processing"> Actualizar </Button>
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
                ¿Estás seguro de que deseas eliminar el certificado "{{
                  selectedCertificado.nombre
                }}"? Esta acción no se puede deshacer.
              </DialogDescription>
            </DialogHeader>

            <DialogFooter class="gap-2">
              <DialogClose as-child>
                <Button variant="secondary">Cancelar</Button>
              </DialogClose>
              <Button type="submit" variant="destructive" :disabled="processing">
                Eliminar
              </Button>
            </DialogFooter>
          </Form>
        </DialogContent>
      </Dialog>
    </div>
  </AppLayout>
</template>
