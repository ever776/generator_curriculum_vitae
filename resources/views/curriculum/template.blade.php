<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Currículum Vitae - {{ $user->name }} {{ $user->apellidos }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
        }

        .page {
            padding: 40px;
            max-width: 800px;
            margin: 0 auto;
        }

        .header {
            background: #2c3e50;
            color: white;
            padding: 25px;
            margin-bottom: 20px;
            text-align: center;
        }

        .header h1 {
            font-size: 28px;
            margin-bottom: 5px;
        }

        .header .subtitle {
            font-size: 14px;
            opacity: 0.9;
        }

        .contact-info {
            margin-top: 10px;
            font-size: 11px;
        }

        .contact-info span {
            margin: 0 8px;
        }

        .section {
            margin-bottom: 25px;
        }

        .section-title {
            font-size: 16px;
            font-weight: bold;
            color: #2c3e50;
            border-bottom: 2px solid #3498db;
            padding-bottom: 5px;
            margin-bottom: 15px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .description {
            text-align: justify;
            margin-bottom: 15px;
            padding: 10px;
            background: #f8f9fa;
            border-left: 3px solid #3498db;
        }

        .item {
            margin-bottom: 15px;
            padding-left: 10px;
            border-left: 2px solid #ecf0f1;
        }

        .item-header {
            display: flex;
            justify-content: space-between;
            align-items: baseline;
            margin-bottom: 5px;
        }

        .item-title {
            font-weight: bold;
            font-size: 13px;
            color: #2c3e50;
        }

        .item-date {
            font-size: 11px;
            color: #7f8c8d;
        }

        .item-subtitle {
            font-style: italic;
            color: #3498db;
            margin-bottom: 5px;
            font-size: 12px;
        }

        .item-description {
            font-size: 11px;
            text-align: justify;
            color: #555;
        }

        .two-columns {
            display: flex;
            gap: 20px;
        }

        .column {
            flex: 1;
        }

        .no-data {
            color: #999;
            font-style: italic;
            font-size: 11px;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 15px;
            border-top: 1px solid #ecf0f1;
            font-size: 10px;
            color: #999;
        }
        
        .signature-section {
            margin-top: 50px;
            text-align: center;
        }
        
        .signature-line {
            width: 250px;
            border-top: 1px solid #333;
            margin: 0 auto 10px;
        }
        
        .signature-name {
            font-size: 14px;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 3px;
        }
        
        .signature-cedula {
            font-size: 11px;
            color: #555;
        }
    </style>
</head>

<body>
    <div class="page">
        <!-- Header -->
        <div class="header">
            <h1>{{ $user->name }} {{ $user->apellidos }}</h1>
            @if ($user->descripcion_profesional)
                <div class="subtitle">{{ $user->descripcion_profesional }}</div>
            @endif
            <div class="contact-info">
                @if ($user->email)
                    <span>✉ {{ $user->email }}</span>
                @endif
                @if ($user->celular)
                    <span>📱 {{ $user->celular }}</span>
                @endif
                @if ($user->domicilio)
                    <span>🏠 {{ $user->domicilio }}</span>
                @endif
            </div>
        </div>

        <!-- Información Personal -->
        @if (
            $user->lugar_fecha_nacimiento ||
                $user->nacionalidad ||
                $user->cedula_identidad ||
                $user->estado_civil ||
                $user->idioma)
            <div class="section">
                <div class="section-title">Información Personal</div>
                <table style="width: 100%; font-size: 11px;">
                    @if ($user->lugar_fecha_nacimiento)
                        <tr>
                            <td style="padding: 3px 0;"><strong>Lugar y Fecha de Nacimiento:</strong>
                                {{ $user->lugar_fecha_nacimiento }}</td>
                        </tr>
                    @endif
                    @if ($user->nacionalidad)
                        <tr>
                            <td style="padding: 3px 0;"><strong>Nacionalidad:</strong> {{ $user->nacionalidad }}</td>
                        </tr>
                    @endif
                    @if ($user->cedula_identidad)
                        <tr>
                            <td style="padding: 3px 0;"><strong>Cédula de Identidad:</strong>
                                {{ $user->cedula_identidad }}</td>
                        </tr>
                    @endif
                    @if ($user->estado_civil)
                        <tr>
                            <td style="padding: 3px 0;"><strong>Estado Civil:</strong> {{ $user->estado_civil }}</td>
                        </tr>
                    @endif
                    @if ($user->idioma)
                        <tr>
                            <td style="padding: 3px 0;"><strong>Idiomas:</strong> {{ $user->idioma }}</td>
                        </tr>
                    @endif
                </table>
            </div>
        @endif


        <!-- Títulos Académicos -->
        @if ($titulos->count() > 0)
            <div class="section">
                <div class="section-title">Formación Académica</div>
                @foreach ($titulos as $titulo)
                    <div class="item">
                        <div class="item-header">
                            <span class="item-title">{{ $titulo->nombre }}</span>
                            <span
                                class="item-date">{{ \Carbon\Carbon::parse($titulo->fecha_titulacion)->format('d/m/Y') }}</span>
                        </div>
                        <div class="item-subtitle">{{ $titulo->institucion }}</div>
                    </div>
                @endforeach
            </div>
        @endif

        <!-- Certificados -->
        @if ($certificados->count() > 0)
            <div class="section">
                <div class="section-title">Certificados</div>
                @foreach ($certificados as $certificado)
                    <div class="item">
                        <div class="item-header">
                            <span class="item-title">{{ $certificado->nombre }}</span>
                            <span class="item-date">
                                {{ \Carbon\Carbon::parse($certificado->fecha_inicio)->format('d/m/Y') }}
                                -
                                {{ $certificado->fecha_conclusion ? \Carbon\Carbon::parse($certificado->fecha_conclusion)->format('d/m/Y') : 'En curso' }}
                                @if ($certificado->duracion)
                                    ({{ $certificado->duracion }} horas)
                                @endif
                            </span>
                        </div>
                        <div class="item-subtitle">{{ $certificado->institucion }}</div>
                    </div>
                @endforeach
            </div>
        @endif

        <!-- Experiencias Laborales -->
        @if ($experiencias->count() > 0)
            <div class="section">
                <div class="section-title">Experiencia Laboral</div>
                @foreach ($experiencias as $experiencia)
                    <div class="item">
                        <div class="item-header">
                            <span class="item-title">{{ $experiencia->puesto }}</span>
                            <span class="item-date">
                                {{ \Carbon\Carbon::parse($experiencia->fecha_inicio)->format('d/m/Y') }}
                                -
                                {{ $experiencia->fecha_final ? \Carbon\Carbon::parse($experiencia->fecha_final)->format('d/m/Y') : 'Actualmente' }}
                                @if ($experiencia->duracion)
                                    ({{ floor($experiencia->duracion / 12) }} años, {{ $experiencia->duracion % 12 }}
                                    meses)
                                @endif
                            </span>
                        </div>
                        <div class="item-subtitle">{{ $experiencia->entidad }} - {{ $experiencia->direccion }}</div>
                        @if ($experiencia->descripcion)
                            <div class="item-description">{{ $experiencia->descripcion }}</div>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif


        <!-- Firma -->
        @if($user->name && $user->apellidos)
            <div class="signature-section">
                <div class="signature-line"></div>
                <div class="signature-name">{{ $user->name }} {{ $user->apellidos }}</div>
                @if($user->cedula_identidad)
                    <div class="signature-cedula">C.I. {{ $user->cedula_identidad }}</div>
                @endif
            </div>
        @endif

        <!-- Footer -->
        <div class="footer">
            Currículum Vitae generado automáticamente - {{ date('d/m/Y') }} | EQC
        </div>
    </div>
</body>

</html>
