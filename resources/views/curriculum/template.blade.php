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
            font-family: 'Arial', sans-serif;
            font-size: 10px;
            line-height: 1.5;
            color: #333;
            background: #fff;
        }

        .page {
            max-width: 210mm;
            margin: 0 auto;
            background: white;
        }

        /* Header estilo moderno negro */
        .header {
            background: #1a1a1a;
            color: white;
            padding: 30px 40px;
        }

        .header-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            width: 100%;
        }

        .header-main {
            flex: 1;
            min-width: 0;
        }

        .header-name-row {
            display: block;
            width: 100%;
            margin-bottom: 10px;
        }

        .header-name-row::after {
            content: "";
            display: table;
            clear: both;
        }

        .header-name {
            float: left;
            font-size: 32px;
            font-weight: 700;
            letter-spacing: 1px;
            color: #fff;
        }

        .header-photo {
            float: right;
            width: 80px;
            height: 80px;
            border-radius: 4px;
            object-fit: cover;
            border: 2px solid #444;
        }

        .header-title {
            font-size: 13px;
            font-weight: 400;
            color: #b0b0b0;
            margin-bottom: 15px;
            line-height: 1.4;
        }

        .header-contact {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }

        .contact-item {
            display: flex;
            align-items: center;
            gap: 5px;
            color: #d0d0d0;
            font-size: 11px;
        }

        .contact-label {
            font-weight: 600;
            color: #888;
        }

        .contact-value {
            color: #fff;
        }

        /* Main content */
        .content {
            padding: 30px 40px;
        }

        /* Secciones */
        .section {
            margin-bottom: 25px;
        }

        .section-title {
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: #1a1a1a;
            border-bottom: 2px solid #1a1a1a;
            padding-bottom: 8px;
            margin-bottom: 15px;
        }

        /* Tablas */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10px;
        }

        .data-table th {
            background: #1a1a1a;
            color: white;
            padding: 10px 12px;
            text-align: left;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 9px;
        }

        .data-table td {
            padding: 10px 12px;
            border-bottom: 1px solid #e0e0e0;
            color: #333;
        }

        .data-table tr:nth-child(even) {
            background: #f8f8f8;
        }

        .data-table tr:hover {
            background: #f0f0f0;
        }

        .data-table .col-fecha {
            width: 80px;
        }

        .data-table .col-duracion {
            width: 70px;
            text-align: center;
        }

        .data-table .col-institucion {
            width: auto;
        }

        .data-table .col-nombre {
            width: 30%;
        }

        .data-table .col-puesto {
            width: 25%;
        }

        .data-table .col-empresa {
            width: 25%;
        }

        /* Items */
        .item {
            margin-bottom: 12px;
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }

        .item:last-child {
            border-bottom: none;
        }

        .item-header {
            display: flex;
            justify-content: space-between;
            align-items: baseline;
            margin-bottom: 3px;
        }

        .item-title {
            font-weight: 700;
            font-size: 11px;
            color: #1a1a1a;
        }

        .item-date {
            font-size: 10px;
            color: #666;
            font-weight: 500;
        }

        .item-subtitle {
            font-weight: 600;
            color: #444;
            font-size: 10px;
            margin-bottom: 3px;
        }

        .item-description {
            font-size: 10px;
            color: #555;
            text-align: justify;
        }

        .item-details {
            font-size: 9px;
            color: #777;
        }

        /* Información personal grid */
        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 8px 20px;
        }

        .info-item {
            display: flex;
        }

        .info-label {
            font-weight: 700;
            color: #1a1a1a;
            min-width: 100px;
            font-size: 10px;
        }

        .info-value {
            color: #444;
            font-size: 10px;
        }

        /* Firma */
        .signature-area {
            margin-top: 40px;
            padding: 25px 40px;
            background: #f5f5f5;
            text-align: center;
        }

        .signature-declaration {
            font-size: 10px;
            color: #444;
            font-style: italic;
            text-align: justify;
            margin-bottom: 25px;
            line-height: 1.6;
            padding: 0 20px;
        }

        .signature-block {
            display: inline-block;
            width: 250px;
            text-align: center;
        }

        .signature-line {
            border-top: 1px solid #333;
            margin-bottom: 8px;
            width: 100%;
        }

        .signature-label {
            font-size: 9px;
            color: #666;
            margin-bottom: 3px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .signature-name {
            font-size: 11px;
            font-weight: 700;
            color: #1a1a1a;
        }

        .signature-cedula {
            font-size: 10px;
            color: #444;
        }

        /* Footer */
        .footer {
            background: #1a1a1a;
            color: #666;
            padding: 12px 40px;
            text-align: center;
            font-size: 9px;
            letter-spacing: 1px;
        }
    </style>
</head>

<body>
    <div class="page">
        <!-- Header -->
        <div class="header">
            <div class="header-top">
                <div class="header-main">
                    <div class="header-name-row">
                        <h1 class="header-name">{{ $user->name }} {{ $user->apellidos }}</h1>
                        @if($user->foto)
                            <img src="{{ public_path('storage/' . $user->foto) }}" alt="Foto" class="header-photo" />
                        @endif
                    </div>
                    @if($user->descripcion_profesional)
                        <div class="header-title">{{ $user->descripcion_profesional }}</div>
                    @endif
                    <div class="header-contact">
                        @if($user->email)
                            <div class="contact-item">
                                <span class="contact-label">Email:</span>
                                <span class="contact-value">{{ $user->email }}</span>
                            </div>
                        @endif
                        @if($user->celular)
                            <div class="contact-item">
                                <span class="contact-label">Tel:</span>
                                <span class="contact-value">{{ $user->celular }}</span>
                            </div>
                        @endif
                        @if($user->domicilio)
                            <div class="contact-item">
                                <span class="contact-label">Dir:</span>
                                <span class="contact-value">{{ $user->domicilio }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="content">
            <!-- Información Personal -->
            @if(
                $user->lugar_fecha_nacimiento ||
                $user->nacionalidad ||
                $user->cedula_identidad ||
                $user->estado_civil ||
                $user->idioma)
                <div class="section">
                    <div class="section-title">Datos Personales</div>
                    <div class="info-grid">
                        @if($user->lugar_fecha_nacimiento)
                            <div class="info-item">
                                <span class="info-label">Lugar y Fecha Nacimiento:</span>
                                <span class="info-value">{{ $user->lugar_fecha_nacimiento }}</span>
                            </div>
                        @endif
                        @if($user->nacionalidad)
                            <div class="info-item">
                                <span class="info-label">Nacionalidad:</span>
                                <span class="info-value">{{ $user->nacionalidad }}</span>
                            </div>
                        @endif
                        @if($user->cedula_identidad)
                            <div class="info-item">
                                <span class="info-label">Cédula de Identidad:</span>
                                <span class="info-value">{{ $user->cedula_identidad }}</span>
                            </div>
                        @endif
                        @if($user->estado_civil)
                            <div class="info-item">
                                <span class="info-label">Estado Civil:</span>
                                <span class="info-value">{{ $user->estado_civil }}</span>
                            </div>
                        @endif
                        @if($user->idioma)
                            <div class="info-item" style="grid-column: 1 / -1;">
                                <span class="info-label">Idiomas:</span>
                                <span class="info-value">{{ $user->idioma }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Formación Académica -->
            @if($titulos->count() > 0)
                <div class="section">
                    <div class="section-title">Formación Académica</div>
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th class="col-nombre">Título</th>
                                <th class="col-institucion">Institución</th>
                                <th class="col-fecha">Fecha</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($titulos as $titulo)
                                <tr>
                                    <td>{{ $titulo->nombre }}</td>
                                    <td>{{ $titulo->institucion }}</td>
                                    <td>{{ \Carbon\Carbon::parse($titulo->fecha_titulacion)->format('d/m/Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            <!-- Certificados -->
            @if($certificados->count() > 0)
                <div class="section">
                    <div class="section-title">Certificados</div>
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th class="col-nombre">Nombre</th>
                                <th class="col-institucion">Institución</th>
                                <th class="col-fecha">Fecha Inicio</th>
                                <th class="col-fecha">Fecha Fin</th>
                                <th class="col-duracion">Duración</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($certificados as $certificado)
                                <tr>
                                    <td>{{ $certificado->nombre }}</td>
                                    <td>{{ $certificado->institucion }}</td>
                                    <td>{{ \Carbon\Carbon::parse($certificado->fecha_inicio)->format('d/m/Y') }}</td>
                                    <td>{{ $certificado->fecha_conclusion ? \Carbon\Carbon::parse($certificado->fecha_conclusion)->format('d/m/Y') : 'En curso' }}</td>
                                    <td class="col-duracion">{{ $certificado->duracion }} horas</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            <!-- Experiencia Laboral -->
            @if($experiencias->count() > 0)
                <div class="section">
                    <div class="section-title">Experiencia Laboral</div>
                    @foreach($experiencias as $experiencia)
                        <div class="item">
                            <div class="item-header">
                                <span class="item-title">{{ $experiencia->puesto }}</span>
                                <span class="item-date">
                                    {{ \Carbon\Carbon::parse($experiencia->fecha_inicio)->format('m/Y') }}
                                    -
                                    @if($experiencia->fecha_final)
                                        {{ \Carbon\Carbon::parse($experiencia->fecha_final)->format('m/Y') }}
                                    @else
                                        Actual
                                    @endif
                                    @if($experiencia->duracion)
                                        ({{ floor($experiencia->duracion / 12) }} años {{ $experiencia->duracion % 12 }} meses)
                                    @endif
                                </span>
                            </div>
                            <div class="item-subtitle"><strong>Entidad:</strong> {{ $experiencia->entidad }}</div>
                            @if($experiencia->direccion)
                                <div class="item-details"><strong>Dirección:</strong> {{ $experiencia->direccion }}</div>
                            @endif
                            @if($experiencia->descripcion)
                                <div class="item-description"><strong>Descripción:</strong> {{ $experiencia->descripcion }}</div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Firma -->
        @if($user->name && $user->apellidos)
            <div class="signature-area">
                <div class="signature-declaration">
                    Certifico que toda la información contenida en este currículum vitae es verídica y puede ser respaldada con la documentación original correspondiente.
                </div>
                <div class="signature-block">
                    <div class="signature-line"></div>
                    <div class="signature-label">Firma</div>
                    <div class="signature-name">{{ $user->name }} {{ $user->apellidos }}</div>
                    @if($user->cedula_identidad)
                        <div class="signature-cedula">C.I. {{ $user->cedula_identidad }}</div>
                    @endif
                </div>
            </div>
        @endif

        <!-- Footer -->
        <div class="footer">
            CURRÍCULUM VITAE | GENERADO AUTOMÁTICAMENTE | {{ date('d/m/Y') }} | EQC
        </div>
    </div>
</body>

</html>
