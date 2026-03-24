<script setup lang="ts">
import { Head, usePage } from '@inertiajs/vue3';
import { Chart as ChartJS, ArcElement, Tooltip, Legend } from 'chart.js';
import { FileText, Award, Briefcase } from 'lucide-vue-next';
import { onMounted, ref } from 'vue';
import { Doughnut } from 'vue-chartjs';
import AlertError from '@/components/AlertError.vue';
import { Button } from '@/components/ui/button';
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard as dashboardRoute } from '@/routes';
import type { BreadcrumbItem } from '@/types';

ChartJS.register(ArcElement, Tooltip, Legend);

interface FailedPdf {
    id: number;
    nombre: string;
    razon: string;
}

interface Props {
    stats: {
        totalTitulos: number;
        totalCertificados: number;
        totalExperiencias: number;
    };
}

const props = defineProps<Props>();

const page = usePage();

const failedPdfs = ref<FailedPdf[]>([]);
const showFailedAlert = ref(false);

onMounted(() => {
    const flashData = page.props.flash as
        | { failed_pdfs?: FailedPdf[] }
        | undefined;

    if (flashData?.failed_pdfs && flashData.failed_pdfs.length > 0) {
        failedPdfs.value = flashData.failed_pdfs;
        showFailedAlert.value = true;
    }
});

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboardRoute(),
    },
];

const generateCurriculum = () => {
    window.open('/curriculum/generate', '_blank');
};

const downloadTitulos = () => {
    window.open('/download/titulos-pdfs', '_blank');
};

const downloadCertificados = () => {
    window.open('/download/certificados-pdfs', '_blank');
};

const downloadExperiencias = () => {
    window.open('/download/experiencias-pdfs', '_blank');
};

const chartData = {
    labels: ['Títulos', 'Certificados', 'Experiencias'],
    datasets: [
        {
            data: [
                props.stats.totalTitulos,
                props.stats.totalCertificados,
                props.stats.totalExperiencias,
            ],
            backgroundColor: ['#3b82f6', '#10b981', '#f59e0b'],
            borderColor: ['#3b82f6', '#10b981', '#f59e0b'],
            borderWidth: 1,
        },
    ],
};

const chartOptions = {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
        legend: {
            position: 'bottom' as const,
        },
    },
};

const totalRegistros =
    props.stats.totalTitulos +
    props.stats.totalCertificados +
    props.stats.totalExperiencias;
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div v-if="showFailedAlert && failedPdfs.length > 0" class="mx-4 mt-4">
            <AlertError
                title="Algunos PDFs no pudieron ser combinados"
                :errors="failedPdfs.map((p) => `${p.nombre}: ${p.razon}`)"
            />
        </div>

        <div class="flex flex-col gap-6 p-4">
            <div class="flex justify-end">
                <Button @click="generateCurriculum">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="mr-2 h-4 w-4"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >
                        <path
                            d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"
                        />
                        <polyline points="14 2 14 8 20 8" />
                        <line x1="16" y1="13" x2="8" y2="13" />
                        <line x1="16" y1="17" x2="8" y2="17" />
                        <polyline points="10 9 9 9 8 9" />
                    </svg>
                    Descargar Currículum Vitae
                </Button>
            </div>

            <div class="grid gap-4 md:grid-cols-3">
                <div
                    class="flex flex-col items-center justify-center rounded-xl border border-sidebar-border/70 bg-card p-6 text-center dark:border-sidebar-border"
                >
                    <div
                        class="mb-3 flex h-14 w-14 items-center justify-center rounded-full bg-blue-100 text-blue-600 dark:bg-blue-900/30"
                    >
                        <FileText class="h-7 w-7" />
                    </div>
                    <p class="text-3xl font-bold">
                        {{ stats.totalTitulos }}
                    </p>
                    <p class="text-sm text-muted-foreground">Títulos</p>
                    <Button
                        variant="outline"
                        size="sm"
                        class="mt-3"
                        @click="downloadTitulos"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="mr-2 h-4 w-4"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                        >
                            <path
                                d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"
                            />
                            <polyline points="7 10 12 15 17 10" />
                            <line x1="12" y1="15" x2="12" y2="3" />
                        </svg>
                        Descargar PDFs
                    </Button>
                </div>

                <div
                    class="flex flex-col items-center justify-center rounded-xl border border-sidebar-border/70 bg-card p-6 text-center dark:border-sidebar-border"
                >
                    <div
                        class="mb-3 flex h-14 w-14 items-center justify-center rounded-full bg-green-100 text-green-600 dark:bg-green-900/30"
                    >
                        <Award class="h-7 w-7" />
                    </div>
                    <p class="text-3xl font-bold">
                        {{ stats.totalCertificados }}
                    </p>
                    <p class="text-sm text-muted-foreground">Certificados</p>
                    <Button
                        variant="outline"
                        size="sm"
                        class="mt-3"
                        @click="downloadCertificados"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="mr-2 h-4 w-4"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                        >
                            <path
                                d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"
                            />
                            <polyline points="7 10 12 15 17 10" />
                            <line x1="12" y1="15" x2="12" y2="3" />
                        </svg>
                        Descargar PDFs
                    </Button>
                </div>

                <div
                    class="flex flex-col items-center justify-center rounded-xl border border-sidebar-border/70 bg-card p-6 text-center dark:border-sidebar-border"
                >
                    <div
                        class="mb-3 flex h-14 w-14 items-center justify-center rounded-full bg-amber-100 text-amber-600 dark:bg-amber-900/30"
                    >
                        <Briefcase class="h-7 w-7" />
                    </div>
                    <p class="text-3xl font-bold">
                        {{ stats.totalExperiencias }}
                    </p>
                    <p class="text-sm text-muted-foreground">
                        Experiencias Laborales
                    </p>
                    <Button
                        variant="outline"
                        size="sm"
                        class="mt-3"
                        @click="downloadExperiencias"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="mr-2 h-4 w-4"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                        >
                            <path
                                d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"
                            />
                            <polyline points="7 10 12 15 17 10" />
                            <line x1="12" y1="15" x2="12" y2="3" />
                        </svg>
                        Descargar PDFs
                    </Button>
                </div>
            </div>

            <div
                class="flex flex-col items-center justify-center rounded-xl border border-sidebar-border/70 bg-card p-6 md:col-span-2 lg:col-span-1 dark:border-sidebar-border"
            >
                <h3 class="mb-4 text-lg font-semibold">
                    Distribución de Registros
                </h3>
                <div class="h-64 w-full max-w-sm">
                    <Doughnut :data="chartData" :options="chartOptions" />
                </div>
                <p class="mt-4 text-sm text-muted-foreground">
                    Total: {{ totalRegistros }} registros
                </p>
            </div>
        </div>
    </AppLayout>
</template>
