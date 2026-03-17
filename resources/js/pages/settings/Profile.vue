<script setup lang="ts">
import { Form, Head, Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import ProfileController from '@/actions/App/Http/Controllers/Settings/ProfileController';
import DeleteUser from '@/components/DeleteUser.vue';
import Heading from '@/components/Heading.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Textarea } from '@/components/ui/textarea';
import AppLayout from '@/layouts/AppLayout.vue';
import SettingsLayout from '@/layouts/settings/Layout.vue';
import { edit } from '@/routes/profile';
import { send } from '@/routes/verification';
import type { BreadcrumbItem } from '@/types';

type Props = {
    mustVerifyEmail: boolean;
    status?: string;
};

defineProps<Props>();

const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: 'Profile settings',
        href: edit(),
    },
];

const page = usePage();
const user = computed(() => page.props.auth.user);
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbItems">
        <Head title="Profile settings" />

        <h1 class="sr-only">Profile settings</h1>

        <SettingsLayout>
            <div class="flex flex-col space-y-6">
                <Heading
                    variant="small"
                    title="Profile information"
                    description="Update your profile information"
                />

                <Form
                    v-bind="ProfileController.update.form()"
                    class="space-y-6"
                    v-slot="{ errors, processing, recentlySuccessful }"
                >
                    <div class="flex items-center gap-6">
                        <div class="relative">
                            <img
                                v-if="user.foto"
                                :src="'/storage/' + user.foto"
                                alt="Foto de perfil"
                                class="h-24 w-24 rounded-full border-2 border-gray-200 object-cover"
                            />
                            <div
                                v-else
                                class="flex h-24 w-24 items-center justify-center rounded-full border-2 border-gray-200 bg-gray-200"
                            >
                                <span class="text-3xl text-gray-400">{{
                                    user.name?.charAt(0).toUpperCase()
                                }}</span>
                            </div>
                        </div>
                        <div class="grid gap-2">
                            <Label for="foto">Foto de Perfil</Label>
                            <Input
                                id="foto"
                                type="file"
                                name="foto"
                                accept="image/jpeg,image/png,image/webp"
                            />
                            <InputError :message="errors.foto" />
                            <p class="text-xs text-gray-500">
                                JPG, PNG o WebP. Máximo 2MB.
                            </p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <div class="grid gap-2">
                            <Label for="name">Nombre</Label>
                            <Input
                                id="name"
                                name="name"
                                :default-value="user.name"
                                placeholder="Tu nombre"
                            />
                            <InputError :message="errors.name" />
                        </div>

                        <div class="grid gap-2">
                            <Label for="apellidos">Apellidos</Label>
                            <Input
                                id="apellidos"
                                name="apellidos"
                                :default-value="user.apellidos"
                                placeholder="Tus apellidos"
                            />
                            <InputError :message="errors.apellidos" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <div class="grid gap-2">
                            <Label for="email">Email</Label>
                            <Input
                                id="email"
                                type="email"
                                name="email"
                                :default-value="user.email"
                                placeholder="Tu email"
                            />
                            <InputError :message="errors.email" />
                        </div>

                        <div class="grid gap-2">
                            <Label for="celular">Celular</Label>
                            <Input
                                id="celular"
                                name="celular"
                                :default-value="user.celular"
                                placeholder="Tu número de celular"
                            />
                            <InputError :message="errors.celular" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <div class="grid gap-2">
                            <Label for="lugar_fecha_nacimiento"
                                >Lugar y Fecha de Nacimiento</Label
                            >
                            <Input
                                id="lugar_fecha_nacimiento"
                                name="lugar_fecha_nacimiento"
                                :default-value="user.lugar_fecha_nacimiento"
                                placeholder="Ciudad, País - Fecha"
                            />
                            <InputError
                                :message="errors.lugar_fecha_nacimiento"
                            />
                        </div>

                        <div class="grid gap-2">
                            <Label for="nacionalidad">Nacionalidad</Label>
                            <Input
                                id="nacionalidad"
                                name="nacionalidad"
                                :default-value="user.nacionalidad"
                                placeholder="Tu nacionalidad"
                            />
                            <InputError :message="errors.nacionalidad" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <div class="grid gap-2">
                            <Label for="cedula_identidad"
                                >Cédula de Identidad</Label
                            >
                            <Input
                                id="cedula_identidad"
                                name="cedula_identidad"
                                :default-value="user.cedula_identidad"
                                placeholder="Tu número de cédula"
                            />
                            <InputError :message="errors.cedula_identidad" />
                        </div>

                        <div class="grid gap-2">
                            <Label for="estado_civil">Estado Civil</Label>
                            <Input
                                id="estado_civil"
                                name="estado_civil"
                                :default-value="user.estado_civil"
                                placeholder="Tu estado civil"
                            />
                            <InputError :message="errors.estado_civil" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <div class="grid gap-2">
                            <Label for="idioma">Idioma</Label>
                            <Input
                                id="idioma"
                                name="idioma"
                                :default-value="user.idioma"
                                placeholder="Idiomas que dominas"
                            />
                            <InputError :message="errors.idioma" />
                        </div>

                        <div class="grid gap-2">
                            <Label for="domicilio">Domicilio</Label>
                            <Input
                                id="domicilio"
                                name="domicilio"
                                :default-value="user.domicilio"
                                placeholder="Tu dirección"
                            />
                            <InputError :message="errors.domicilio" />
                        </div>
                    </div>

                    <div class="grid gap-2">
                        <Label for="descripcion_profesional"
                            >Descripción Profesional</Label
                        >
                        <Textarea
                            id="descripcion_profesional"
                            name="descripcion_profesional"
                            :default-value="user.descripcion_profesional"
                            placeholder="Cuéntanos sobre ti profesionalmente..."
                            rows="5"
                        />
                        <InputError :message="errors.descripcion_profesional" />
                    </div>

                    <div v-if="mustVerifyEmail && !user.email_verified_at">
                        <p class="-mt-4 text-sm text-muted-foreground">
                            Tu email no está verificado.
                            <Link
                                :href="send()"
                                as="button"
                                class="text-foreground underline decoration-neutral-300 underline-offset-4 transition-colors duration-300 ease-out hover:decoration-current! dark:decoration-neutral-500"
                            >
                                Haz clic aquí para reenviar el correo de
                                verificación.
                            </Link>
                        </p>

                        <div
                            v-if="status === 'verification-link-sent'"
                            class="mt-2 text-sm font-medium text-green-600"
                        >
                            Se ha enviado un nuevo enlace de verificación a tu
                            correo.
                        </div>
                    </div>

                    <div class="flex items-center gap-4">
                        <Button
                            :disabled="processing"
                            data-test="update-profile-button"
                            >Guardar</Button
                        >

                        <Transition
                            enter-active-class="transition ease-in-out"
                            enter-from-class="opacity-0"
                            leave-active-class="transition ease-in-out"
                            leave-to-class="opacity-0"
                        >
                            <p
                                v-show="recentlySuccessful"
                                class="text-sm text-neutral-600"
                            >
                                Guardado.
                            </p>
                        </Transition>
                    </div>
                </Form>
            </div>

            <DeleteUser />
        </SettingsLayout>
    </AppLayout>
</template>
