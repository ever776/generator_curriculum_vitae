<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { FileText, Sparkles, FileDown, CheckCircle } from 'lucide-vue-next';
import { Button } from '@/components/ui/button';
import { dashboard, login, register } from '@/routes';

withDefaults(
    defineProps<{
        canRegister: boolean;
    }>(),
    {
        canRegister: true,
    },
);
</script>

<template>
    <Head title="CV Builder" />
    <div
        class="flex min-h-screen flex-col bg-background text-foreground dark:bg-[#0a0a0a]"
    >
        <nav
            class="flex h-16 items-center justify-between border-b px-6 dark:border-gray-800"
        >
            <div class="flex items-center gap-2">
                <FileText class="h-8 w-8 text-primary" stroke-width="1.5" />
                <span class="text-xl font-semibold">CV Builder</span>
            </div>
            <div class="flex items-center gap-4">
                <Link
                    v-if="$page.props.auth.user"
                    :href="dashboard()"
                    class="inline-block rounded-md border border-input bg-background px-4 py-2 text-sm font-medium shadow-xs hover:bg-accent hover:text-accent-foreground dark:bg-input/30 dark:hover:bg-input/50"
                >
                    Dashboard
                </Link>
                <template v-else>
                    <Link
                        :href="login()"
                        class="inline-block rounded-md px-4 py-2 text-sm font-medium hover:bg-accent hover:text-accent-foreground"
                    >
                        Iniciar sesión
                    </Link>
                    <Link v-if="canRegister" :href="register()">
                        <Button size="sm">Registrarse</Button>
                    </Link>
                </template>
            </div>
        </nav>

        <main class="flex-1">
            <section
                class="flex flex-col items-center justify-center px-6 py-20 lg:py-32"
            >
                <div class="mx-auto max-w-3xl text-center">
                    <div
                        class="mb-6 inline-flex items-center gap-2 rounded-full border bg-accent/50 px-4 py-1.5 text-sm dark:bg-accent/20"
                    >
                        <Sparkles class="h-4 w-4 text-primary" />
                        <span>Crea tu CV profesional en minutos</span>
                    </div>
                    <h1
                        class="mb-6 text-4xl font-bold tracking-tight lg:text-6xl"
                    >
                        Generador de
                        <span class="text-primary">Currículum Vitae</span>
                    </h1>
                    <p class="mb-8 text-lg text-muted-foreground lg:text-xl">
                        Diseña y descarga tu currículum vitae de forma
                        profesional. Sin conocimientos de diseño, sin
                        complicaciones.
                    </p>
                    <div
                        class="flex flex-col items-center gap-4 sm:flex-row sm:justify-center"
                    >
                        <Link v-if="canRegister" :href="register()">
                            <Button size="lg" class="gap-2">
                                <CheckCircle class="h-5 w-5" />
                                Comenzar ahora
                            </Button>
                        </Link>
                        <Link :href="login()">
                            <Button size="lg" variant="outline" class="gap-2">
                                Ya tengo cuenta
                            </Button>
                        </Link>
                    </div>
                </div>
            </section>

            <section class="border-y bg-accent/30 py-16 dark:bg-accent/10">
                <div class="mx-auto max-w-6xl px-6">
                    <h2
                        class="mb-12 text-center text-2xl font-bold tracking-tight lg:text-3xl"
                    >
                        ¿Por qué elegirnos?
                    </h2>
                    <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
                        <div class="flex flex-col items-center text-center">
                            <div
                                class="mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-primary/10 dark:bg-primary/20"
                            >
                                <FileText
                                    class="h-8 w-8 text-primary"
                                    stroke-width="1.5"
                                />
                            </div>
                            <h3 class="mb-2 text-lg font-semibold">
                                Fácil de usar
                            </h3>
                            <p class="text-sm text-muted-foreground">
                                Interfaz intuitiva que te guía paso a paso para
                                crear tu CV sin complicaciones.
                            </p>
                        </div>

                        <div class="flex flex-col items-center text-center">
                            <div
                                class="mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-primary/10 dark:bg-primary/20"
                            >
                                <Sparkles
                                    class="h-8 w-8 text-primary"
                                    stroke-width="1.5"
                                />
                            </div>
                            <h3 class="mb-2 text-lg font-semibold">
                                Diseño profesional
                            </h3>
                            <p class="text-sm text-muted-foreground">
                                Plantillas diseñadas por profesionales para que
                                tu CV destaque entre los demás.
                            </p>
                        </div>

                        <div class="flex flex-col items-center text-center">
                            <div
                                class="mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-primary/10 dark:bg-primary/20"
                            >
                                <FileDown
                                    class="h-8 w-8 text-primary"
                                    stroke-width="1.5"
                                />
                            </div>
                            <h3 class="mb-2 text-lg font-semibold">
                                Exporta a PDF
                            </h3>
                            <p class="text-sm text-muted-foreground">
                                Descarga tu currículum en formato PDF listo para
                                enviar a cualquier empresa.
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            <section class="py-16 text-center">
                <div class="mx-auto max-w-2xl px-6">
                    <h2 class="mb-4 text-2xl font-bold">
                        ¿Listo para destacar?
                    </h2>
                    <p class="mb-6 text-muted-foreground">
                        Únete a miles de profesionales que ya crearon su CV con
                        nosotros.
                    </p>
                    <Link v-if="canRegister" :href="register()">
                        <Button size="lg" class="gap-2">
                            Crear mi CV gratis
                        </Button>
                    </Link>
                </div>
            </section>
        </main>

        <footer
            class="border-t py-6 text-center text-sm text-muted-foreground dark:border-gray-800"
        >
            <p>© 2026 CV Builder. Todos los derechos reservados.</p>
        </footer>
    </div>
</template>
